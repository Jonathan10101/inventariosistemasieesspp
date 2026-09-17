<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Support\Str;
use Intervention\Image\Format;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;
use Throwable;

class ImageCompressor
{
    /**
     * Comprime, redimensiona y guarda una imagen en WebP.
     *
     * Retorna una ruta relativa como:
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
        if (!$file->isValid()) {
            throw new RuntimeException(
                'La imagen no es válida o no terminó de cargarse.'
            );
        }

        $directory = trim($directory, '/');

        $quality = max(1, min(100, $quality));
        $maxWidth = max(1, $maxWidth);
        $maxHeight = max(1, $maxHeight);

        $fileName = 'resguardo_'
            . now()->format('Ymd_His')
            . '_'
            . Str::random(16)
            . '.webp';

        $path = $directory . '/' . $fileName;

        try {
            /*
             * Intervention Image v4:
             * decode() reemplaza a read().
             */
            $image = Image::decode($file);

            /*
             * Conserva la proporción y no agranda imágenes pequeñas.
             */
            $image->scaleDown(
                width: $maxWidth,
                height: $maxHeight
            );

            /*
             * Intervention Image v4:
             * encodeUsingFormat() reemplaza a toWebp().
             */
            $encodedImage = $image->encodeUsingFormat(
                Format::WEBP,
                quality: $quality,
                strip: true
            );

            $saved = LaravelStorage::disk($disk)->put(
                $path,
                (string) $encodedImage
            );

            if (!$saved) {
                throw new RuntimeException(
                    'Laravel no pudo guardar la imagen comprimida.'
                );
            }

            if (!LaravelStorage::disk($disk)->exists($path)) {
                throw new RuntimeException(
                    'La imagen fue procesada, pero no aparece en el almacenamiento.'
                );
            }

            $size = LaravelStorage::disk($disk)->size($path);

            if ($size <= 0) {
                LaravelStorage::disk($disk)->delete($path);

                throw new RuntimeException(
                    'La imagen comprimida se generó vacía.'
                );
            }

            return $path;
        } catch (Throwable $exception) {
            report($exception);

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