<?php

namespace App\Exports;

use App\Models\Resguardo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentsExport implements FromView{
    public function view(): View
    {
        return view('excel/exportStudents',[
            'inventarios' => Resguardo::all()
        ]);
    }

    
}