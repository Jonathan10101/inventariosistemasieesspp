<?php

namespace App\Http\Controllers\Cocina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Product;
use Livewire\WithPagination;


class ProductosCocinaController extends Controller
{    
    
    public function index()
    {                        
        return view('cocina/productos');        
    }   

    public function store(Request $request)
    {
 
    }

    public function show(string $id)
    {
        return $id;
    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
