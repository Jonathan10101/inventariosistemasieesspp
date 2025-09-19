<?php

namespace App\Http\Controllers\Inscripciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InscripcionesController extends Controller
{
    
    public function index()
    {
        return view("inscripciones/index");
    }
    
}
