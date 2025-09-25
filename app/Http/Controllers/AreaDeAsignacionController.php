<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaDeUso;

class AreaDeAsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("areasasignacion/index");
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
