<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TenantDatabaseStorage
{
    /**
     * Límite total permitido por base tenant.
     */
    public function limitBytes(): int
    {
        return (int) config(
            'intevi.tenant_database_limit_bytes',
            4 * 1024 * 1024 * 1024
        );
    }

    /**
     * Espacio usado actualmente por la base tenant.
     */
    public function usedBytes(): int
    {
        $connection = DB::connection();

        $connection->statement(
            'SET SESSION information_schema_stats_expiry = 0'
        );

        $databaseName = $connection->getDatabaseName();

        $result = $connection->selectOne(
            '
            SELECT
                COALESCE(
                    SUM(
                        COALESCE(DATA_LENGTH, 0)
                        + COALESCE(INDEX_LENGTH, 0)
                    ),
                    0
                ) AS used_bytes
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            ',
            [$databaseName]
        );

        return (int) ($result->used_bytes ?? 0);
    }

    /**
     * Resumen completo para mostrar en el dashboard.
     */
    public function summary(): array
    {
        $limitBytes = $this->limitBytes();
        $usedBytes = $this->usedBytes();
        $remainingBytes = max(0, $limitBytes - $usedBytes);

        $percentage = $limitBytes > 0
            ? round(($usedBytes / $limitBytes) * 100, 2)
            : 0;

        $percentage = min(100, max(0, $percentage));

        return [
            'database_name' => DB::connection()->getDatabaseName(),

            'limit_bytes' => $limitBytes,
            'used_bytes' => $usedBytes,
            'remaining_bytes' => $remainingBytes,

            'limit_formatted' => $this->formatBytes($limitBytes),
            'used_formatted' => $this->formatBytes($usedBytes),
            'remaining_formatted' => $this->formatBytes($remainingBytes),

            'percentage' => $percentage,

            'is_warning' => $percentage >= 80,
            'is_critical' => $percentage >= 95,
            'is_full' => $usedBytes >= $limitBytes,
        ];
    }

    /**
     * Impide nuevas operaciones cuando no queda espacio.
     */
    public function assertCanWrite(int $incomingBytes = 0): void
    {
        $limitBytes = $this->limitBytes();
        $usedBytes = $this->usedBytes();

        if (($usedBytes + $incomingBytes) >= $limitBytes) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'storage' => 'El almacenamiento de esta institución está lleno. '
                    . 'Has utilizado ' . $this->formatBytes($usedBytes)
                    . ' de ' . $this->formatBytes($limitBytes)
                    . '. Solicita una ampliación de espacio.',
            ]);
        }
    }

    /**
     * Convierte bytes a KB, MB, GB o TB.
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 MB';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $power = (int) floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        $value = $bytes / (1024 ** $power);

        return number_format(
            $value,
            $power >= 3 ? 2 : 1
        ) . ' ' . $units[$power];
    }
}