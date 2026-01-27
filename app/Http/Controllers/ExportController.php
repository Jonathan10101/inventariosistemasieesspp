<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Exports\InventariosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class ExportController extends Controller
{
    //
    public function index(){
        return view('export');
    }

    public function export(){
        $fechaHora = Carbon::now()->format('d-m-Y H:i:s');

        return Excel::download(
            new InventariosExport,
            'INVENTARIOIEESSPP' . $fechaHora . '.xlsx'
        );
    }
}
