<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use Illuminate\Support\Facades\Auth;


class UbicacionFisicaController extends Controller
{
    private int $perPage = 2;

    /**
     * Mostrar el listado de ubicaciones físicas.
     */
    public function index()
    {
        return view('ubicaciones.index');
    }

    /**
     * Mostrar el detalle de una ubicación física.
     */
    public function show($id)
    {
        $ubicacionFisica = UbicacionFisica::find($id);
        if (!$ubicacionFisica) {
            abort(404);
        }
        $historiales = $ubicacionFisica
            ->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->whereNull('fecha_baja')
            ->paginate($this->perPage);

        return view('ubicaciones.show', compact(
            'ubicacionFisica',
            'historiales'
        ));
    }

    
}