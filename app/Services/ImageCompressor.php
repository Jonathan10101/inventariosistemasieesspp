<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;

class ImageCompressor
{
    /**
     * Comprime, redimensiona y guarda una imagen en WebP.
     *
     * Devuelve la ruta relativa que debe guardarse en la base de datos.
     */
    public function store(
        UploadedFile $file,
        string $directory = 'resguardos',
        string $disk = 'public',
        int $maxWidth = 1600,
        int $maxHeight = 1600,
        int $quality = 75
    ): string {
        $realPath = $file->getRealPath();

        if (!$realPath || !is_file($realPath)) {
            throw new RuntimeException(
                'No fue posible localizar la imagen temporal.'
            );
        }

        $directory = trim($directory, '/');

        $fileName = 'resguardo_'
            . now()->format('Ymd_His')
            . '_'
            . Str::random(16)
            . '.webp';

        $path = $directory . '/' . $fileName;

        /*
         * scaleDown conserva la proporción original.
         * También evita aumentar imágenes que ya sean pequeñas.
         */
        $compressedImage = Image::read($realPath)
            ->scaleDown(
                width: $maxWidth,
                height: $maxHeight
            )
            ->toWebp(
                quality: $quality,
                strip: true
            );

        $saved = LaravelStorage::disk($disk)->put(
            $path,
            (string) $compressedImage
        );

        if (!$saved) {
            throw new RuntimeException(
                'No fue posible guardar la imagen comprimida.'
            );
        }

        return $path;
    }
}