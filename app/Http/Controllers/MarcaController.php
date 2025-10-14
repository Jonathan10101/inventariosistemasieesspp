<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::paginate(3);
        return view('marca/index',compact("marcas"));
    }

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
