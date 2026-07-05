<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Resguardo;
use App\Models\Resguardante;
use App\Models\AreaDeUso;

class DashboardController extends Controller
{    
    public function index()
    {     
        //return view("dashboard/index");
        return view('dashboard', [
        'totalInventarios' => Inventario::count(),
        'totalResguardos' => Resguardo::count(),
        'totalResguardantes' => Resguardante::count(),
        'totalAreas' => AreaDeUso::count(),
        'ultimosResguardos' => Resguardo::latest()->take(5)->get(),
    ]);
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
