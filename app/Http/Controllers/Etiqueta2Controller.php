<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DNS1D;

class Etiqueta2Controller extends Controller
{
    public function show($codigo)
    {
        /*
        |--------------------------------------------------------------------------
        | GENERAR CÓDIGO DE BARRAS
        |--------------------------------------------------------------------------
        */

        $etiqueta = $this->generarEtiquetaBarcode($codigo);

        /*
        |--------------------------------------------------------------------------
        | GENERAR PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView('etiquetas.pdf2', [
            'etiqueta' => $etiqueta,
            'codigo' => $codigo,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PDF VERTICAL
        |--------------------------------------------------------------------------
        |
        | 25 mm ancho
        | 50 mm alto
        |
        | Exactamente la misma medida que la etiqueta de inventario.
        |
        */

        $pdf->setPaper([
            0,
            0,
            70.87,   // 25 mm
            141.73   // 50 mm
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOMBRE DEL ARCHIVO
        |--------------------------------------------------------------------------
        */

        $codigoArchivo = ltrim((string) $codigo, '0');

        if ($codigoArchivo === '') {
            $codigoArchivo = '0';
        }

        return $pdf->download(
            "Etiqueta de ubicacion {$codigoArchivo}.pdf"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CÓDIGO DE BARRAS
    |--------------------------------------------------------------------------
    */

    private function generarEtiquetaBarcode($codigo)
    {
        return DNS1D::getBarcodeHTML(
            $codigo,
            'C128',
            1.7,
            48
        );
    }
}