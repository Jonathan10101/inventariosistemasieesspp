<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        return view('users/index');
    }

    public function store(Request $request)
    {
        // Validar el campo
        $request->validate([
            'nombre' => 'required|string|max:150|min:2|unique:marcas,nombre',
        ]);
        // Guardar en la base de datos
        User::create([
            'nombre' => $request->nombre,
        ]);
        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Marca registrada correctamente.');
    }
}
