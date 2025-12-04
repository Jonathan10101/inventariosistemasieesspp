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
        //$ubicacionesFisicas = UbicacionFisica::all();
        //return view('ubicaciones/index',compact('ubicacionesFisicas'));
        return view('ubicaciones/index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {        
        /*
        $request->validate([
            'ubicacion' => 'required|string|max:150|min:2|unique:ubicacion_fisicas,descripcion',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('ubicaciones', 'public');
        }
        // Guardar en la base de datos
        UbicacionFisica::create([
            'descripcion' => $request->ubicacion,
            'imagen' => $rutaImagen,
        ]);
        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Ubicación registrada correctamente.');
        */
    }

    public function show($id)
    {
        $ubicacionFisica = UbicacionFisica::find($id);

        if (!$ubicacionFisica) {
            abort(404);
        }

        $user = Auth::user();

        // 👉 ROLES QUE PUEDEN VER TODO (NO incluye subdirector)
        if ($user->hasRole('Administrador') || 
            $user->hasRole('Delegacion')   ||
            $user->hasRole('Director')) {

            $historiales = $ubicacionFisica->historialResguardos()
                ->whereNull('fecha_liberacion')
                ->paginate($this->perPage);

            return view("ubicaciones.show", [
                'historiales' => $historiales,
                'ubicacionFisica' => $ubicacionFisica
            ]);
        }

        // 👉 SUBDIRECTOR Y USUARIO NORMAL: validar subdirección
        $puedeVer = $ubicacionFisica->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->whereHas('resguardante.user', function ($q) use ($user) {
                $q->where('subdireccion', $user->subdireccion);
            })
            ->exists();

        if (!$puedeVer) {
            abort(403, 'No tienes permiso para ver esta ubicación física.');
        }

        // Historiales activos con paginación (para subdirección)
        $historiales = $ubicacionFisica->historialResguardos()
            ->whereNull('fecha_liberacion')
            ->paginate($this->perPage);

        return view("ubicaciones.show", [
            'historiales' => $historiales,
            'ubicacionFisica' => $ubicacionFisica
        ]);
    }

    public function edit(UbicacionFisica $ubicacionFisica)
    {
        
    }

    public function update(Request $request, UbicacionFisica $ubicacionFisica)
    {
        
    }

    public function destroy(UbicacionFisica $ubicacionFisica)
    {
        
    }
}
