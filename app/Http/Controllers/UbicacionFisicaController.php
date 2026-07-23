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
        $ubicacionfisica = UbicacionFisica::find($id);
        if (!$ubicacionfisica) {
            abort(404);
        }
        $historiales = $ubicacionfisica
            ->historialResguardos()
            ->with([
                'resguardo',
                'resguardante',
            ])
            ->orderByDesc('fecha_asignacion')
            ->paginate($this->perPage)
            ->withQueryString();

        return view('ubicaciones.show', compact(
            'ubicacionfisica',
            'historiales'
        ));
    }

    
}