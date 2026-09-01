<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Resguardante;
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

    public function imprimirPorResguardante($resguardanteId)
    {
        $resguardante = Resguardante::with([
            'resguardos' => function ($query) {
                $query->orderBy('id');
            }
        ])->findOrFail($resguardanteId);

        if ($resguardante->resguardos->isEmpty()) {
            return back()->with(
                'error',
                'Este resguardante no tiene bienes asignados.'
            );
        }

        $etiquetas = $resguardante->resguardos->map(function ($resguardo) {

            $codigo = str_pad(
                (string) $resguardo->id,
                6,
                '0',
                STR_PAD_LEFT
            );

            return [
                'codigo' => $codigo,
                'etiqueta' => $this->generarEtiquetaBarcode($codigo),
                'resguardo' => $resguardo,
            ];
        });

        $pdf = Pdf::loadView(
            'etiquetas.pdf-resguardante',
            compact('resguardante', 'etiquetas')
        );

        $nombreCompleto = trim(
            $resguardante->nombre1 . ' ' .
            $resguardante->nombre2 . ' ' .
            $resguardante->apellido1 . ' ' .
            $resguardante->apellido2
        );

        $nombreArchivo = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $nombreCompleto
        );

        return $pdf->download(
            "Etiquetas_{$nombreArchivo}.pdf"
        );
    }
}