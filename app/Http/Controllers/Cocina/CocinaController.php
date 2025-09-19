<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function index()
    {
        //return "hola administrador";
        return view("cocina/index");
    }

    public function store(Request $request)
    {
        
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
