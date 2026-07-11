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
    public function show(UbicacionFisica $ubicacionFisica)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Administrador, Director y Delegación
        |--------------------------------------------------------------------------
        | Estos roles pueden consultar todos los resguardos activos.
        */

        if ($user->hasAnyRole([
            'Administrador',
            'Director',
            'Delegacion',
        ])) {
            $historiales = $ubicacionFisica
                ->historialResguardos()
                ->whereNull('fecha_liberacion')
                ->paginate($this->perPage);

            return view('ubicaciones.show', compact(
                'ubicacionFisica',
                'historiales'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Subdirector y usuarios normales
        |--------------------------------------------------------------------------
        | Solo pueden consultar registros de su propia subdirección.
        */

        if (empty($user->subdireccion)) {
            abort(
                403,
                'Tu usuario no tiene una subdirección asignada.'
            );
        }

        $historialesQuery = $ubicacionFisica
            ->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->whereHas('resguardante.user', function ($query) use ($user) {
                $query->where(
                    'subdireccion',
                    $user->subdireccion
                );
            });

        if (!(clone $historialesQuery)->exists()) {
            abort(
                403,
                'No tienes permiso para ver esta ubicación física.'
            );
        }

        $historiales = $historialesQuery
            ->paginate($this->perPage);

        return view('ubicaciones.show', compact(
            'ubicacionFisica',
            'historiales'
        ));
    }
}