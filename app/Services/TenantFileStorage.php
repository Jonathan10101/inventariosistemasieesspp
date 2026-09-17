<?php

namespace App\Services;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TenantFileStorage
{
    /**
     * Tablas del tenant donde pueden existir rutas de archivos.
     */
    private const TABLES = [
        'resguardos',
        'historial_resguardos',
        'ubicacion_fisicas',
    ];

    /**
     * Extensiones consideradas imágenes.
     */
    private const IMAGE_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'webp',
        'gif',
        'bmp',
        'svg',
        'avif',
        'heic',
        'heif',
    ];

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
     * Conexión actual del tenant.
     */
    private function connection(): Connection
    {
        return DB::connection(
            $this->connectionName()
        );
    }

    /**
     * Calcula el almacenamiento usado por el tenant actual.
     */
    public function usage(): array
    {
        $disk = Storage::disk('public');

        $pdfBytes = 0;
        $imageBytes = 0;

        $pdfFiles = 0;
        $imageFiles = 0;

        $missingFiles = 0;

        /*
         * Las rutas ya vienen sin duplicados.
         *
         * Esto evita contar varias veces un PDF o imagen compartidos
         * por múltiples registros.
         */
        $paths = $this->referencedPaths();

        foreach ($paths as $path) {
            try {
                if (!$disk->exists($path)) {
                    $missingFiles++;

                    continue;
                }

                $size = (int) $disk->size($path);

                if ($size <= 0) {
                    continue;
                }

                $extension = strtolower(
                    pathinfo($path, PATHINFO_EXTENSION)
                );

                if ($extension === 'pdf') {
                    $pdfBytes += $size;
                    $pdfFiles++;

                    continue;
                }

                if (
                    in_array(
                        $extension,
                        self::IMAGE_EXTENSIONS,
                        true
                    )
                ) {
                    $imageBytes += $size;
                    $imageFiles++;
                }
            } catch (Throwable) {
                $missingFiles++;
            }
        }

        $totalBytes = $pdfBytes + $imageBytes;

        return [
            'tenant_id' => tenant('id'),

            'pdf' => [
                'files' => $pdfFiles,
                'bytes' => $pdfBytes,
                'mb' => $this->bytesToMb($pdfBytes),
            ],

            'images' => [
                'files' => $imageFiles,
                'bytes' => $imageBytes,
                'mb' => $this->bytesToMb($imageBytes),
            ],

            'total' => [
                'files' => $pdfFiles + $imageFiles,
                'bytes' => $totalBytes,
                'mb' => $this->bytesToMb($totalBytes),
            ],

            'missing_files' => $missingFiles,
        ];
    }

    /**
     * Busca rutas de archivos en las tablas del tenant.
     */
    private function referencedPaths(): array
    {
        $connection = $this->connection();
        $schema = $connection->getSchemaBuilder();

        $paths = [];

        foreach (self::TABLES as $table) {
            if (!$schema->hasTable($table)) {
                continue;
            }

            $columns = $schema->getColumnListing($table);

            if (empty($columns)) {
                continue;
            }

            $orderColumn = in_array('id', $columns, true)
                ? 'id'
                : $columns[0];

            $connection
                ->table($table)
                ->select($columns)
                ->orderBy($orderColumn)
                ->chunk(
                    500,
                    function ($rows) use (&$paths, $columns) {
                        foreach ($rows as $row) {
                            foreach ($columns as $column) {
                                $value = $row->{$column} ?? null;

                                if (
                                    !is_string($value)
                                    || trim($value) === ''
                                ) {
                                    continue;
                                }

                                $path = $this->normalizePath(
                                    $value
                                );

                                if ($path !== null) {
                                    /*
                                     * La ruta se usa como llave para evitar
                                     * archivos duplicados.
                                     */
                                    $paths[$path] = true;
                                }
                            }
                        }
                    }
                );
        }

        return array_keys($paths);
    }

    /**
     * Convierte rutas o URLs en rutas relativas al disco public.
     *
     * Ejemplos aceptados:
     *
     * resguardos/archivo.webp
     * resguardos/pdf/archivo.pdf
     * ubicaciones/archivo.webp
     * storage/resguardos/archivo.webp
     * /var/www/laravel/public/storage/resguardos/archivo.webp
     */
    private function normalizePath(string $value): ?string
    {
        $value = html_entity_decode(
            trim($value)
        );

        if ($value === '') {
            return null;
        }

        /*
         * Si es una URL completa, conservar solamente la ruta.
         */
        $urlPath = parse_url(
            $value,
            PHP_URL_PATH
        );

        if (
            is_string($urlPath)
            && $urlPath !== ''
        ) {
            $value = $urlPath;
        }

        $value = urldecode($value);

        $value = str_replace(
            '\\',
            '/',
            $value
        );

        /*
         * Detectar rutas absolutas que contengan /storage/.
         */
        $storagePosition = strpos(
            $value,
            '/storage/'
        );

        if ($storagePosition !== false) {
            $value = substr(
                $value,
                $storagePosition + strlen('/storage/')
            );
        }

        $value = ltrim(
            $value,
            '/'
        );

        /*
         * Eliminar prefijos frecuentes.
         */
        $prefixes = [
            'public/storage/',
            'storage/app/public/',
            'app/public/',
            'storage/',
        ];

        foreach ($prefixes as $prefix) {
            if (str_starts_with($value, $prefix)) {
                $value = substr(
                    $value,
                    strlen($prefix)
                );
            }
        }

        $value = ltrim(
            $value,
            '/'
        );

        /*
         * Solamente considerar archivos de las carpetas actuales
         * de INTEVI.
         */
        if (
            !preg_match(
                '#^(resguardos|ubicaciones)/#i',
                $value
            )
        ) {
            return null;
        }

        $extension = strtolower(
            pathinfo($value, PATHINFO_EXTENSION)
        );

        $allowedExtensions = array_merge(
            ['pdf'],
            self::IMAGE_EXTENSIONS
        );

        if (
            !in_array(
                $extension,
                $allowedExtensions,
                true
            )
        ) {
            return null;
        }

        return $value;
    }

    /**
     * Convertir bytes a megabytes.
     */
    private function bytesToMb(int $bytes): float
    {
        return round(
            $bytes / 1024 / 1024,
            2
        );
    }
}