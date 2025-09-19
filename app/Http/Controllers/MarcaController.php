<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('marca/index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar el campo
        $request->validate([
            'nombre' => 'required|string|max:150|min:2|unique:marcas,nombre',
        ]);

        // Guardar en la base de datos
        Marca::create([
            'nombre' => $request->nombre,
        ]);

        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Marca registrada correctamente.');
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
