<?php

namespace App\Exports;

use App\Models\Resguardo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventarioExport implements FromView{
    public function view(): View
    {
        return view('excel/exportInventario',[
            'inventarios' => Resguardo::all()
        ]);
    }   
}