<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Resguardo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

//class UsersExport implements FromCollection{
class UsersExport implements FromView{

/*
    public function collection()
    {
        return Resguardo::all();
    }
*/
    public function view(): View
    {
        return view('exportUsers',[
            'resguardos' => Resguardo::all()
        ]);
        
    }
}