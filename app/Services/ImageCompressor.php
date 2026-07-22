<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;
use Throwable;

class ImageCompressor
{
    /**
     * Comprime, redimensiona y guarda una imagen en formato WebP.
     *
     * Retorna una ruta como:
     * resguardos/resguardo_20260722_xxxxx.webp
     */
    public function store(
        UploadedFile $file,
        string $directory = 'resguardos',
        string $disk = 'public',
        int $maxWidth = 1600,
        int $maxHeight = 1600,
        int $quality = 75
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Comprobar archivo
        |--------------------------------------------------------------------------
        */

        if (!$file->isValid()) {
            throw new RuntimeException(
                'La imagen recibida no es válida o no terminó de cargarse.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Normalizar valores
        |--------------------------------------------------------------------------
        */

        $directory = trim($directory, '/');

        $maxWidth = max(1, $maxWidth);
        $maxHeight = max(1, $maxHeight);

        $quality = max(
            1,
            min(100, $quality)
        );

        /*
        |--------------------------------------------------------------------------
        | Generar nombre definitivo
        |--------------------------------------------------------------------------
        */

        $fileName = 'resguardo_'
            . now()->format('Ymd_His')
            . '_'
            . Str::random(16)
            . '.webp';

        $path = $directory . '/' . $fileName;

        try {
            /*
            |--------------------------------------------------------------------------
            | Leer directamente el UploadedFile
            |--------------------------------------------------------------------------
            |
            | Intervention Image v3 puede leer directamente objetos UploadedFile
            | y TemporaryUploadedFile de Livewire.
            |
            */

            $image = Image::read($file);

            /*
            |--------------------------------------------------------------------------
            | Redimensionar
            |--------------------------------------------------------------------------
            |
            | scaleDown conserva la proporción y evita ampliar imágenes pequeñas.
            |
            */

            $image->scaleDown(
                width: $maxWidth,
                height: $maxHeight
            );

            /*
            |--------------------------------------------------------------------------
            | Convertir a WebP
            |--------------------------------------------------------------------------
            */

            $encodedImage = $image->toWebp(
                quality: $quality,
                strip: true
            );

            /*
            |--------------------------------------------------------------------------
            | Guardar
            |--------------------------------------------------------------------------
            |
            | Utilizamos un puntero para evitar manejar innecesariamente una
            | segunda copia completa de la imagen en memoria.
            |
            */

            $saved = LaravelStorage::disk($disk)->put(
                $path,
                $encodedImage->toFilePointer()
            );

            if (!$saved) {
                throw new RuntimeException(
                    'Laravel no pudo escribir la imagen en el disco public.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Comprobar que realmente quedó guardada
            |--------------------------------------------------------------------------
            */

            if (!LaravelStorage::disk($disk)->exists($path)) {
                throw new RuntimeException(
                    'La imagen fue procesada, pero no aparece en el almacenamiento.'
                );
            }

            $savedSize = LaravelStorage::disk($disk)->size($path);

            if ($savedSize <= 0) {
                LaravelStorage::disk($disk)->delete($path);

                throw new RuntimeException(
                    'La imagen comprimida se generó vacía.'
                );
            }

            return $path;
        } catch (Throwable $exception) {
            /*
            * Registrar el error verdadero en:
            * storage/logs/laravel.log
            */
            report($exception);

            /*
            * Eliminar cualquier archivo incompleto.
            */
            if (LaravelStorage::disk($disk)->exists($path)) {
                LaravelStorage::disk($disk)->delete($path);
            }

            throw new RuntimeException(
                'No fue posible comprimir la imagen: '
                . $exception->getMessage(),
                0,
                $exception
            );
        }
    }
}