<?php

namespace App\Http\Controllers;

use App\Models\Resguardante;
use Illuminate\Http\Request;

class ResguardanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('resguardante/index');
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
    //return $request;
    //return "se va a registrar";
    Resguardante::create([
        'nombre1' => $request->nombre1,
        'nombre2' => $request->nombre2,
        'apellido1' => $request->apellido1,
        'apellido2' => $request->apellido2,        
    ]);

                return redirect()->back()->with('success', 'Resguardante guardado correctamente.');

}

    }


    /**
     * Display the specified resource.
     */
    public function show(Resguardante $resguardante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resguardante $resguardante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resguardante $resguardante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resguardante $resguardante)
    {
        //
    }
}
