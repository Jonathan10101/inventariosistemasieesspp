<?php

namespace App\Services;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Illuminate\Support\Facades\Storage;

class TenantDatabaseStorage
{
    /**
     * Nombre de la conexión utilizada por los tenants.
     */
    public function connectionName(): string
    {
        return (string) config(
            'intevi.tenant_database_connection',
            'tenant'
        );
    }

    /**
     * Obtiene la conexión correspondiente al tenant.
     */
    private function connection(): Connection
    {
        return DB::connection($this->connectionName());
    }

    /**
     * Límite configurado en megabytes.
     *
     * Este valor proviene de:
     * TENANT_DATABASE_LIMIT_MB
     */
    public function limitMb(): int
    {
        return max(
            1,
            (int) config('intevi.tenant_database_limit_mb', 4096)
        );
    }

    /**
     * Convierte el límite de megabytes a bytes.
     */
    public function limitBytes(): int
    {
        return $this->limitMb() * 1024 * 1024;
    }

    /**
     * Devuelve el nombre de la base de datos tenant actual.
     */
    public function databaseName(): string
    {
        $databaseName = (string) $this->connection()->getDatabaseName();

        if ($databaseName === '') {
            throw new RuntimeException(
                'No se pudo identificar la base de datos del tenant actual.'
            );
        }

        return $databaseName;
    }

    /**
     * Calcula el espacio utilizado por toda la base de datos tenant.
     *
     * Incluye:
     * - Datos de las tablas.
     * - Índices.
     *
     * No incluye archivos guardados en storage/, public/ o servicios externos.
     */
/**
 * Calcula únicamente el espacio usado por la base de datos.
 */
    public function databaseUsedBytes(): int
    {
        $connection = $this->connection();
        $databaseName = $this->databaseName();

        try {
            $connection->statement(
                'SET SESSION information_schema_stats_expiry = 0'
            );
        } catch (QueryException $exception) {
            // Continuar si la versión de MySQL/MariaDB no lo soporta.
        }

        $result = $connection->selectOne(
            '
            SELECT
                COALESCE(
                    SUM(
                        COALESCE(DATA_LENGTH, 0)
                        +
                        COALESCE(INDEX_LENGTH, 0)
                    ),
                    0
                ) AS used_bytes
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            ',
            [$databaseName]
        );

        return max(
            0,
            (int) ($result->used_bytes ?? 0)
        );
    }

    /**
     * Espacio disponible en bytes.
     */
    public function remainingBytes(): int
    {
        return max(
            0,
            $this->limitBytes() - $this->usedBytes()
        );
    }

    /**
     * Indica si el almacenamiento ya está lleno.
     */
    public function isFull(): bool
    {
        return $this->usedBytes() >= $this->limitBytes();
    }

    /**
     * Devuelve toda la información necesaria para el dashboard.
     */
    public function summary(): array
    {
        $databaseName = $this->databaseName();
        $limitBytes = $this->limitBytes();
        $usedBytes = $this->usedBytes();
        $remainingBytes = max(0, $limitBytes - $usedBytes);

        $realPercentage = $limitBytes > 0
            ? ($usedBytes / $limitBytes) * 100
            : 0;

        /*
         * Para la barra visual nunca mostramos más del 100%,
         * aunque la base ya haya superado el límite.
         */
        $displayPercentage = min(
            100,
            max(0, round($realPercentage, 2))
        );

        $isFull = $usedBytes >= $limitBytes;

        return [
            'database_name' => $databaseName,

            'connection_name' => $this->connectionName(),

            'limit_mb' => $this->limitMb(),

            'limit_bytes' => $limitBytes,
            'used_bytes' => $usedBytes,
            'remaining_bytes' => $remainingBytes,

            'limit_formatted' => $this->formatBytes($limitBytes),
            'used_formatted' => $this->formatBytes($usedBytes),
            'remaining_formatted' => $this->formatBytes($remainingBytes),

            /*
             * Porcentaje utilizado para la barra del dashboard.
             */
            'percentage' => $displayPercentage,

            /*
             * Porcentaje real. Puede ser mayor al 100%.
             */
            'real_percentage' => round($realPercentage, 2),

            /*
             * Estados exclusivos.
             */
            'is_warning' => (
                $realPercentage >= 80
                && $realPercentage < 95
            ),

            'is_critical' => (
                $realPercentage >= 95
                && $realPercentage < 100
            ),

            'is_full' => $isFull,

            'can_write' => !$isFull,
        ];
    }

    /**
     * Bloquea cualquier nueva operación cuando el tenant
     * alcanzó o superó el almacenamiento permitido.
     *
     * $incomingBytes permite considerar el tamaño de un archivo
     * o contenido que está a punto de guardarse.
     */
    public function assertCanWrite(int $incomingBytes = 0): void
    {
        $incomingBytes = max(0, $incomingBytes);

        $limitBytes = $this->limitBytes();
        $usedBytes = $this->usedBytes();
        $projectedBytes = $usedBytes + $incomingBytes;

        if ($usedBytes >= $limitBytes || $projectedBytes >= $limitBytes) {
            throw ValidationException::withMessages([
                'storage' => sprintf(
                    'El almacenamiento de esta institución está lleno. '
                    . 'Actualmente se han utilizado %s de %s. '
                    . 'Solicita una ampliación de espacio para continuar registrando información.',
                    $this->formatBytes($usedBytes),
                    $this->formatBytes($limitBytes)
                ),
            ]);
        }
    }

    /**
     * Convierte bytes a B, KB, MB, GB o TB.
     *
     * Se muestran dos decimales para poder observar cambios pequeños.
     */
    private function formatBytes(int $bytes): string
    {
        $bytes = max(0, $bytes);

        if ($bytes === 0) {
            return '0 MB';
        }

        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
        ];

        $power = (int) floor(
            log($bytes, 1024)
        );

        $power = min(
            $power,
            count($units) - 1
        );

        $value = $bytes / (1024 ** $power);

        $decimals = match ($power) {
            0 => 0,
            default => 2,
        };

        return number_format(
            $value,
            $decimals
        ) . ' ' . $units[$power];
    }


    /**
     * Uso total del tenant:
     *
     * Base de datos + imágenes + PDF.
     */
    public function usedBytes(): int
    {
        return $this->databaseUsedBytes()
            + $this->filesUsedBytes();
    }

    /**
     * Calcula los archivos pertenecientes al tenant actual.
     *
     * Aunque los archivos estén mezclados en las carpetas del servidor,
     * las rutas se obtienen desde la base de datos del tenant activo.
     */
    public function filesUsedBytes(): int
    {
        $disk = Storage::disk('public');

        $totalBytes = 0;

        foreach ($this->tenantFilePaths() as $path) {
            try {
                if (!$disk->exists($path)) {
                    continue;
                }

                $totalBytes += max(
                    0,
                    (int) $disk->size($path)
                );
            } catch (\Throwable $exception) {
                /*
                * Un archivo inexistente o dañado no detiene el sistema.
                */
            }
        }

        return $totalBytes;
    }

    /**
     * Obtiene imágenes y PDF registrados en la base
     * del tenant actualmente activo.
     */
    private function tenantFilePaths(): array
    {
        $connection = $this->connection();

        $schema = $connection->getSchemaBuilder();

        /*
        * Se usa la ruta como llave para evitar contar dos veces
        * una imagen o PDF compartido por varios registros.
        */
        $paths = [];

        /*
        * PDF e imágenes del historial de resguardos.
        */
        if (
            $schema->hasTable('historial_resguardos')
            && $schema->hasColumn(
                'historial_resguardos',
                'resguardo_pdf'
            )
        ) {
            $pdfPaths = $connection
                ->table('historial_resguardos')
                ->whereNotNull('resguardo_pdf')
                ->where('resguardo_pdf', '<>', '')
                ->pluck('resguardo_pdf');

            foreach ($pdfPaths as $path) {
                $path = $this->normalizeFilePath($path);

                if ($path !== null) {
                    $paths[$path] = true;
                }
            }
        }

        if (
            $schema->hasTable('historial_resguardos')
            && $schema->hasColumn(
                'historial_resguardos',
                'imagen_evidencia'
            )
        ) {
            $imagePaths = $connection
                ->table('historial_resguardos')
                ->whereNotNull('imagen_evidencia')
                ->where('imagen_evidencia', '<>', '')
                ->pluck('imagen_evidencia');

            foreach ($imagePaths as $path) {
                $path = $this->normalizeFilePath($path);

                if ($path !== null) {
                    $paths[$path] = true;
                }
            }
        }

        /*
        * Imagen principal del resguardo, si esa columna existe.
        */
        if (
            $schema->hasTable('resguardos')
            && $schema->hasColumn(
                'resguardos',
                'imagen'
            )
        ) {
            $resguardoImages = $connection
                ->table('resguardos')
                ->whereNotNull('imagen')
                ->where('imagen', '<>', '')
                ->pluck('imagen');

            foreach ($resguardoImages as $path) {
                $path = $this->normalizeFilePath($path);

                if ($path !== null) {
                    $paths[$path] = true;
                }
            }
        }

        /*
        * Imágenes de ubicaciones físicas.
        */
        if (
            $schema->hasTable('ubicacion_fisicas')
            && $schema->hasColumn(
                'ubicacion_fisicas',
                'imagen'
            )
        ) {
            $ubicacionImages = $connection
                ->table('ubicacion_fisicas')
                ->whereNotNull('imagen')
                ->where('imagen', '<>', '')
                ->pluck('imagen');

            foreach ($ubicacionImages as $path) {
                $path = $this->normalizeFilePath($path);

                if ($path !== null) {
                    $paths[$path] = true;
                }
            }
        }

        return array_keys($paths);
    }

    /**
     * Convierte la ruta guardada en la base de datos
     * en una ruta válida para Storage::disk('public').
     */
    private function normalizeFilePath(mixed $path): ?string
    {
        if (!is_string($path)) {
            return null;
        }

        $path = trim($path);

        if ($path === '') {
            return null;
        }

        $path = str_replace('\\', '/', $path);

        /*
        * Si se almacenó una URL completa.
        */
        if (
            str_starts_with($path, 'http://')
            || str_starts_with($path, 'https://')
        ) {
            $urlPath = parse_url(
                $path,
                PHP_URL_PATH
            );

            if (!is_string($urlPath)) {
                return null;
            }

            $path = $urlPath;
        }

        $path = urldecode($path);

        /*
        * Ejemplo:
        *
        * /var/www/laravel/public/storage/resguardos/archivo.webp
        *
        * se convierte en:
        *
        * resguardos/archivo.webp
        */
        $storagePosition = strpos(
            $path,
            '/storage/'
        );

        if ($storagePosition !== false) {
            $path = substr(
                $path,
                $storagePosition + strlen('/storage/')
            );
        }

        $path = ltrim($path, '/');

        $prefixes = [
            'public/storage/',
            'storage/app/public/',
            'storage/',
        ];

        foreach ($prefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $path = substr(
                    $path,
                    strlen($prefix)
                );
            }
        }

        $path = ltrim($path, '/');

        if (
            !str_starts_with($path, 'resguardos/')
            && !str_starts_with($path, 'ubicaciones/')
        ) {
            return null;
        }

        return $path;
    }

}