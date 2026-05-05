<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use App\Models\Resguardante;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class UbicacionFisicaController extends Controller
{
    use WithPagination;
    public $perPage = 2;

    public function index()
    {
        return view('ubicaciones/index');
    }

    public function show($id)
    {
        $ubicacionFisica = UbicacionFisica::find($id);

        if (!$ubicacionFisica) {
            abort(404);
        }

        $user = Auth::user();

        /* ============================================================
        🟦 ADMINISTRADOR — DIRECTOR — DELEGACION
        ➤ Estos roles pueden ver TODO
        ============================================================ */
        if ($user->hasRole('Administrador') 
            || $user->hasRole('Director') 
            || $user->hasRole('Delegacion')) 
        {
            $historiales = $ubicacionFisica->historialResguardos()
                ->whereNull('fecha_liberacion')
                ->paginate($this->perPage);

            return view("ubicaciones.show", [
                'historiales' => $historiales,
                'ubicacionFisica' => $ubicacionFisica
            ]);
        }

        /* ============================================================
        🟩 SUBDIRECTOR — Solo puede ver su propia subdirección
        ============================================================ */
        if ($user->hasRole('Subdirector')) {

            // Validar si esta ubicación física pertenece a su subdirección
            $puedeVer = $ubicacionFisica->historialResguardos()
                ->whereNull('fecha_liberacion')
                ->whereHas('resguardante.user', function ($q) use ($user) {
                    $q->where('subdireccion', $user->subdireccion);
                })
                ->exists();

            if (!$puedeVer) {
                abort(403, 'No tienes permiso para ver esta ubicación física.');
            }

            // Cargar historial filtrado por su subdirección
            $historiales = $ubicacionFisica->historialResguardos()
                ->whereNull('fecha_liberacion')
                ->whereHas('resguardante.user', function ($q) use ($user) {
                    $q->where('subdireccion', $user->subdireccion);
                })
                ->paginate($this->perPage);

            return view("ubicaciones.show", [
                'historiales' => $historiales,
                'ubicacionFisica' => $ubicacionFisica
            ]);
        }

        /* ============================================================
        🟧 USUARIO NORMAL — Solo ver su propia subdirección
        ============================================================ */
        $puedeVer = $ubicacionFisica->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->whereHas('resguardante.user', function ($q) use ($user) {
                $q->where('subdireccion', $user->subdireccion);
            })
            ->exists();

        if (!$puedeVer) {
            abort(403, 'No tienes permiso para ver esta ubicación física.');
        }

        $historiales = $ubicacionFisica->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->whereHas('resguardante.user', function ($q) use ($user) {
                $q->where('subdireccion', $user->subdireccion);
            })
            ->paginate($this->perPage);

        return view("ubicaciones.show", [
            'historiales' => $historiales,
            'ubicacionFisica' => $ubicacionFisica
        ]);
    }
    
}
