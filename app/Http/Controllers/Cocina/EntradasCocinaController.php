<?php

namespace App\Http\Controllers\Cocina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntradasCocinaController extends Controller
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
