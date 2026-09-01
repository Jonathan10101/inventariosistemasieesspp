<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DNS1D;

class EtiquetaController extends Controller
{
    public function show($codigo)
    {
        $etiqueta = $this->generarEtiquetaBarcode($codigo);

        $pdf = Pdf::loadView('etiquetas.pdf', [
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
        */

        $pdf->setPaper([
            0,
            0,
            70.87,   // 25 mm
            141.73   // 50 mm
        ]);

        $codigoArchivo = ltrim($codigo, '0');

        return $pdf->download(
            "Etiqueta del equipo con id {$codigoArchivo}.pdf"
        );
    }

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