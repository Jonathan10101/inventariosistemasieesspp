<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use Illuminate\Http\Request;

class UbicacionFisicaController extends Controller
{
    public function index()
    {
        return view('ubicaciones/index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {        
        $request->validate([
            'ubicacion' => 'required|string|max:150|min:2|unique:ubicacion_fisicas,descripcion',
        ]);
        // Guardar en la base de datos
        UbicacionFisica::create([
            'descripcion' => $request->ubicacion
        ]);
        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Ubicación registrada correctamente.');
    }

    public function show(UbicacionFisica $ubicacionFisica)
    {
        
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
