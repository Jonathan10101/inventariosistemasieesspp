<?php

namespace App\Http\Controllers;

use App\Models\UbicacionFisica;
use Illuminate\Http\Request;


class UbicacionFisicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ubicaciones/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    // Validar el campo
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

    /**
     * Display the specified resource.
     */
    public function show(UbicacionFisica $ubicacionFisica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UbicacionFisica $ubicacionFisica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UbicacionFisica $ubicacionFisica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UbicacionFisica $ubicacionFisica)
    {
        //
    }
}
