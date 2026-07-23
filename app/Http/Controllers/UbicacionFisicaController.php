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
        abort_if(
            !tenant(),
            404,
            'No se encontró el tenant correspondiente.'
        );

        $user = Auth::user();

        abort_if(
            !$user,
            401,
            'Debes iniciar sesión para consultar esta información.'
        );

        /*
        |--------------------------------------------------------------------------
        | Consulta del historial completo
        |--------------------------------------------------------------------------
        */

        $historialesQuery = $ubicacionFisica
            ->historialResguardos()
            ->with([
                'resguardo',
                'resguardante',
            ])
            ->orderByDesc('fecha_asignacion');

        /*
        |--------------------------------------------------------------------------
        | Usuarios con acceso completo
        |--------------------------------------------------------------------------
        */

        if ($user->hasAnyRole([
            'Administrador',
            'Director',
            'Delegacion',
        ])) {
            $historiales = $historialesQuery
                ->paginate($this->perPage)
                ->withQueryString();

            return view('ubicaciones.show', compact(
                'ubicacionFisica',
                'historiales'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Subdirector y usuarios normales
        |--------------------------------------------------------------------------
        */

        if (blank($user->subdireccion)) {
            abort(
                403,
                'Tu usuario no tiene una subdirección asignada.'
            );
        }

        $historialesQuery->whereHas(
            'resguardante.user',
            function ($query) use ($user) {
                $query->where(
                    'subdireccion',
                    $user->subdireccion
                );
            }
        );

        $historiales = $historialesQuery
            ->paginate($this->perPage)
            ->withQueryString();

        return view('ubicaciones.show', compact(
            'ubicacionFisica',
            'historiales'
        ));
    }

    
}