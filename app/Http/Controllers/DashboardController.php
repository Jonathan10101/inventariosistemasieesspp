<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Resguardo;
use App\Models\Resguardante;
use App\Models\AreaDeUso;
use App\Models\Marca;
use App\Services\TenantDatabaseStorage;

class DashboardController extends Controller
{    
    public function index(TenantDatabaseStorage $tenantDatabaseStorage)
    {     
        //return view("dashboard/index");
        $storage = $tenantDatabaseStorage->summary();

        return view('dashboard', [
            'totalInventarios' => Resguardo::count(),
            'totalMarcas' => Marca::count(),
            'totalResguardantes' => Resguardante::count(),
            'totalAreas' => AreaDeUso::count(),
            'ultimosResguardos' => Resguardo::latest()->take(5)->get(),
            'storage' => $storage
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
