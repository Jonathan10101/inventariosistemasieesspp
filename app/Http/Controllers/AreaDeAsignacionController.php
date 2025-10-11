<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaDeUso;

class AreaDeAsignacionController extends Controller
{
    public function index()
    {
        return view("areasasignacion/index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|min:2|unique:area_de_uso,nombre',
        ]);

        // Guardar en la base de datos
        AreaDeUso::create([
            'nombre' => $request->nombre
        ]);

        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Área de uso registrada correctamente.');
    }

    public function show(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}
