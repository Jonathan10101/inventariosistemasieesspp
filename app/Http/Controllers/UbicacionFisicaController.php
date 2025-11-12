<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use App\Models\Resguardante;
use Illuminate\Http\Request;
use Livewire\WithPagination;


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

        // Obtener solo los historiales activos (sin fecha_liberacion) con paginación
        $historiales = $ubicacionFisica
        ? $ubicacionFisica->historialResguardos()
        ->whereNull('fecha_liberacion')
        ->paginate($this->perPage)
        : collect();

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
