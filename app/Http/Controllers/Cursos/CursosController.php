<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    
    public function index()
    {        
        return view("cursos/index");
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
