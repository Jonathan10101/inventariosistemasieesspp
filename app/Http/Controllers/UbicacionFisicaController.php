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
        /*
        |--------------------------------------------------------------------------
        | Protección adicional de multitenancy
        |--------------------------------------------------------------------------
        |
        | Aunque la ruta ya debe estar protegida por InitializeTenancyByDomain,
        | verificamos que realmente exista un tenant inicializado.
        |
        */

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
        | Consulta base
        |--------------------------------------------------------------------------
        |
        | Esta consulta se ejecuta automáticamente sobre la base de datos
        | del tenant actual.
        |
        */

        $historialesQuery = $ubicacionFisica
            ->historialResguardos()
            ->whereNull('fecha_liberacion');

        /*
        |--------------------------------------------------------------------------
        | Administrador, Director y Delegación
        |--------------------------------------------------------------------------
        |
        | Pueden consultar todos los resguardos activos de esta ubicación,
        | pero únicamente dentro del tenant actual.
        |
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

        if (empty($user->subdireccion)) {
            abort(
                403,
                'Tu usuario no tiene una subdirección asignada.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filtrar por subdirección
        |--------------------------------------------------------------------------
        */

        $historialesQuery->whereHas(
            'resguardante.user',
            function ($query) use ($user) {
                $query->where(
                    'subdireccion',
                    $user->subdireccion
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Verificar permiso
        |--------------------------------------------------------------------------
        |
        | La ubicación sí pertenece al tenant actual, pero el usuario solamente
        | podrá abrirla si tiene algún resguardo relacionado con su subdirección.
        |
        */

        if (!(clone $historialesQuery)->exists()) {
            abort(
                403,
                'No tienes permiso para ver los resguardos de esta ubicación física.'
            );
        }

        $historiales = $historialesQuery
            ->paginate($this->perPage)
            ->withQueryString();

        return view('ubicaciones.show', compact(
            'ubicacionFisica',
            'historiales'
        ));
    }

    
}