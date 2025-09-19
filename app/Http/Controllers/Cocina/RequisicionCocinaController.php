<?php

namespace App\Http\Controllers\Cocina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequisicionCocinaController extends Controller
{
    public function index()
    {
        return view("requisiciones/index");
    }
    
    public function store(Request $request)
    {

    }

    public function show(int $id)
    {
        (int)$nRequisicion  = $id;
        return view("requisiciones/show",compact("nRequisicion"));
    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
