<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use DNS1D;

class Etiqueta2Controller extends Controller
{
    public function show($codigo)
    {
        $etiqueta = $this->generarEtiquetaBarcode($codigo);
        // Genera el PDF a partir de una vista
        $pdf = Pdf::loadView('etiquetas.pdf2', compact('etiqueta', 'codigo'));
        $codigo = ltrim($codigo,'0');
        // Forzar descarga del archivo
        return $pdf->download("Etiqueta de la ubicación física con id {$codigo}.pdf");
    }

    private function generarEtiquetaBarcode($codigo)
    {
        // Usa C128 para solo números, más compacto y legible
        $barcode = DNS1D::getBarcodeHTML($codigo, 'C128', 2, 40); // grosor=2, altura=40
        // Contenedor centrado, sin escalar para no romper legibilidad
        $html = "<div style='width:160px; text-align:center; overflow:hidden;'>$barcode</div>";
        return $html;
    }
}
