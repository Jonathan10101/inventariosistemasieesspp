<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{    
    public function index()
    {     
        return view("dashboard/index");
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
