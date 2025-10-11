<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index()
    {
        return view('puestos/index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|min:2|unique:puestos,nombre',
        ]);
        // Guardar en la base de datos
        Puesto::create([
            'nombre' => $request->nombre,
        ]);
        // Redirigir con mensaje
        return redirect()->back()->with('success', 'Puesto registrado correctamente.');
    }

    public function show(Puesto $puesto)
    {
        
    }

    public function edit(Puesto $puesto)
    {
        
    }

    public function update(Request $request, Puesto $puesto)
    {
        
    }

    public function destroy(Puesto $puesto)
    {
        
    }
}
