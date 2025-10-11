<?php

namespace App\Http\Controllers;

use App\Models\Resguardante;
use Illuminate\Http\Request;

class ResguardanteController extends Controller
{
    public function index()
    {
        return view('resguardante/index');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre1' => 'required|string|max:150|min:2',            
            'apellido1' => 'required|string|max:150|min:2',            
        ]);

        $query = Resguardante::query();

        $query->where('nombre1', $request->nombre1)
            ->where('apellido1', $request->apellido1);

        if ($request->nombre2) {
            $query->where('nombre2', $request->nombre2);
        } else {
            $query->whereNull('nombre2');
        }

        if ($request->apellido2) {
            $query->where('apellido2', $request->apellido2);
        } else {
            $query->whereNull('apellido2');
        }

        $existe = $query->exists();

        if($existe){
            return redirect()->back()->with('success', 'El nombre del resguardante ya estaba registrado.');

        }else{
            Resguardante::create([
                'nombre1' => $request->nombre1,
                'nombre2' => $request->nombre2,
                'apellido1' => $request->apellido1,
                'apellido2' => $request->apellido2,        
            ]);
            return redirect()->back()->with('success', 'Resguardante guardado correctamente.');
        }
    }

    public function show($id)
    {
        $resguardante = Resguardante::find($id);
        return view("resguardante.show", [
            'resguardante' => $resguardante
        ]);    
    }

    public function edit(Resguardante $resguardante)
    {
        
    }

    public function update(Request $request, Resguardante $resguardante)
    {
        
    }

    public function destroy(Resguardante $resguardante)
    {
        
    }
}
