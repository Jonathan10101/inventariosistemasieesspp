<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfCompressor
{
    /*
    |--------------------------------------------------------------------------
    | Comprimir un PDF
    |--------------------------------------------------------------------------
    |
    | Niveles disponibles:
    |
    | normal:
    |   Buena calidad y reducción moderada.
    |
    | fuerte:
    |   Recomendado para INTEVI. Reduce imágenes a 96 dpi.
    |
    | extrema:
    |   Reduce imágenes a 72 dpi. Produce archivos mucho más pequeños,
    |   pero puede afectar firmas, sellos, fotografías y letras pequeñas.
    |
    */

    public function compress(
        string $inputPath,
        string $outputPath,
        string $level = 'fuerte'
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Verificar archivo original
        |--------------------------------------------------------------------------
        */

        if (!File::exists($inputPath)) {
            throw new RuntimeException(
                'El archivo PDF original no existe.'
            );
        }

        if (File::size($inputPath) === 0) {
            throw new RuntimeException(
                'El archivo PDF original está vacío.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Crear carpeta de salida
        |--------------------------------------------------------------------------
        */

        File::ensureDirectoryExists(
            dirname($outputPath)
        );

        /*
        |--------------------------------------------------------------------------
        | Seleccionar resolución
        |--------------------------------------------------------------------------
        |
        | La mayor parte del peso de un PDF escaneado está en sus imágenes.
        | Reducir su resolución es lo que genera el ahorro más importante.
        |
        */

        $settings = match ($level) {
            /*
             * Calidad aceptable para imprimir y visualizar.
             */
            'normal' => [
                'colorResolution' => 150,
                'grayResolution' => 150,
                'monoResolution' => 300,
            ],

            /*
             * Máxima reducción razonable para documentos institucionales.
             */
            'extrema' => [
                'colorResolution' => 72,
                'grayResolution' => 72,
                'monoResolution' => 150,
            ],

            /*
             * Nivel recomendado.
             */
            default => [
                'colorResolution' => 96,
                'grayResolution' => 96,
                'monoResolution' => 200,
            ],
        };

        /*
        |--------------------------------------------------------------------------
        | Ejecutable de Ghostscript
        |--------------------------------------------------------------------------
        */

        $ghostscriptBinary = PHP_OS_FAMILY === 'Windows'
            ? 'gswin64c.exe'
            : 'gs';

        /*
        |--------------------------------------------------------------------------
        | Crear proceso de compresión
        |--------------------------------------------------------------------------
        */

        $process = new Process([
            $ghostscriptBinary,

            /*
             * Generar un nuevo archivo PDF.
             */
            '-sDEVICE=pdfwrite',

            /*
             * Mantener compatibilidad con lectores de PDF modernos.
             */
            '-dCompatibilityLevel=1.4',

            /*
             * Procesar el documento sin interacción.
             */
            '-dNOPAUSE',
            '-dQUIET',
            '-dBATCH',
            '-dSAFER',

            /*
            |--------------------------------------------------------------------------
            | Comprimir imágenes a color
            |--------------------------------------------------------------------------
            */

            '-dDownsampleColorImages=true',

            /*
             * Bicubic ofrece mejor calidad al reducir imágenes.
             */
            '-dColorImageDownsampleType=/Bicubic',

            /*
             * Resolución de imágenes a color.
             */
            '-dColorImageResolution='
                . $settings['colorResolution'],

            /*
             * Obligar a recomprimir imágenes JPEG.
             */
            '-dPassThroughJPEGImages=false',

            /*
             * No conservar imágenes JPEG 2000 sin comprimir nuevamente.
             */
            '-dPassThroughJPXImages=false',

            /*
             * Utilizar compresión JPEG para imágenes a color.
             */
            '-dAutoFilterColorImages=false',
            '-dColorImageFilter=/DCTEncode',

            /*
            |--------------------------------------------------------------------------
            | Comprimir imágenes en escala de grises
            |--------------------------------------------------------------------------
            */

            '-dDownsampleGrayImages=true',
            '-dGrayImageDownsampleType=/Bicubic',
            '-dGrayImageResolution='
                . $settings['grayResolution'],

            /*
             * Utilizar compresión JPEG para imágenes grises.
             */
            '-dAutoFilterGrayImages=false',
            '-dGrayImageFilter=/DCTEncode',

            /*
            |--------------------------------------------------------------------------
            | Comprimir imágenes monocromáticas
            |--------------------------------------------------------------------------
            |
            | Las imágenes monocromáticas corresponden normalmente a documentos
            | escaneados exclusivamente en blanco y negro.
            |
            */

            '-dDownsampleMonoImages=true',
            '-dMonoImageDownsampleType=/Subsample',
            '-dMonoImageResolution='
                . $settings['monoResolution'],

            /*
            |--------------------------------------------------------------------------
            | Optimizar recursos
            |--------------------------------------------------------------------------
            */

            /*
             * Detectar imágenes repetidas dentro del PDF.
             */
            '-dDetectDuplicateImages=true',

            /*
             * Comprimir las fuentes incluidas.
             */
            '-dCompressFonts=true',

            /*
             * Guardar solamente los caracteres realmente utilizados.
             */
            '-dSubsetFonts=true',

            /*
             * Eliminar miniaturas internas que no son necesarias.
             */
            '-dPreserveHalftoneInfo=false',

            /*
             * Archivo de salida.
             */
            '-sOutputFile=' . $outputPath,

            /*
             * Archivo de entrada.
             */
            $inputPath,
        ]);

        /*
         * Permitir hasta cinco minutos para documentos grandes.
         */
        $process->setTimeout(300);

        $process->run();

        /*
        |--------------------------------------------------------------------------
        | Verificar resultado
        |--------------------------------------------------------------------------
        */

        if (!$process->isSuccessful()) {
            throw new RuntimeException(
                'No fue posible comprimir el PDF: '
                . trim($process->getErrorOutput())
            );
        }

        if (!File::exists($outputPath)) {
            throw new RuntimeException(
                'Ghostscript no generó el PDF comprimido.'
            );
        }

        if (File::size($outputPath) === 0) {
            throw new RuntimeException(
                'Ghostscript generó un PDF vacío.'
            );
        }

        return $outputPath;
    }
}