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
            'codigo'   => $codigo,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tamaño físico de la etiqueta
        |--------------------------------------------------------------------------
        |
        | 25 mm x 50 mm
        | 2.5 cm x 5 cm
        |
        | DomPDF utiliza puntos:
        | 25 mm = 70.87 pt
        | 50 mm = 141.73 pt
        |
        */

        $pdf->setPaper([
            0,
            0,
            141.73, // 50 mm
            70.87   // 25 mm
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
            1.8,
            55
        );
    }


}