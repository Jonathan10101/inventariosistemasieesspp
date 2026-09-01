<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DNS1D;

class EtiquetaController extends Controller
{
    public function show($codigo)
    {
        $etiqueta = $this->generarEtiquetaBarcode($codigo);

        $pdf = Pdf::loadView('etiquetas.pdf', compact('etiqueta', 'codigo'));

        // 50 mm x 25 mm
        $pdf->setPaper([
            0,
            0,
            141.73,
            70.87
        ]);

        $codigoArchivo = ltrim($codigo, '0');

        return $pdf->download(
            "Etiqueta del equipo con id {$codigoArchivo}.pdf"
        );
    }

    private function generarEtiquetaBarcode($codigo)
    {
        $barcode = DNS1D::getBarcodeHTML(
            $codigo,
            'C128',
            2,
            40
        );

        // Centrado dentro de una etiqueta de 50 mm
        return "
            <div style='
                width: 100%;
                text-align: center;
                margin: 0 auto;
            '>
                $barcode
            </div>
        ";
    }
}