<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfCompressor
{
    /**
     * Comprime un archivo PDF utilizando Ghostscript.
     *
     * Perfiles disponibles:
     * screen  = máxima compresión, menor calidad
     * ebook   = buena compresión y calidad aceptable
     * printer = mejor calidad, archivo más pesado
     * prepress = máxima calidad, poca compresión
     */
    public function compress(
        string $inputPath,
        string $outputPath,
        string $quality = 'ebook'
    ): string {
        $allowedQualities = [
            'screen',
            'ebook',
            'printer',
            'prepress',
        ];

        if (!in_array($quality, $allowedQualities, true)) {
            $quality = 'ebook';
        }

        if (!File::exists($inputPath)) {
            throw new RuntimeException(
                'El archivo PDF original no existe.'
            );
        }

        File::ensureDirectoryExists(dirname($outputPath));

        $ghostscript = PHP_OS_FAMILY === 'Windows'
            ? 'gswin64c'
            : 'gs';

        $process = new Process([
            $ghostscript,
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.4',
            '-dPDFSETTINGS=/' . $quality,
            '-dNOPAUSE',
            '-dQUIET',
            '-dBATCH',
            '-dSAFER',
            '-sOutputFile=' . $outputPath,
            $inputPath,
        ]);

        $process->setTimeout(180);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException(
                'No fue posible comprimir el PDF: '
                . $process->getErrorOutput()
            );
        }

        if (!File::exists($outputPath) || File::size($outputPath) === 0) {
            throw new RuntimeException(
                'Ghostscript no generó correctamente el PDF comprimido.'
            );
        }

        return $outputPath;
    }
}