<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('puestos')->insert([
            [                
                'nombre' => 'ANALISTA',                
            ],
            [                
                'nombre' => 'ANALISTA PROFESIONAL',                
            ],
            [                
                'nombre' => 'ENCARGADO DEL DEPARTAMENTO',                
            ],
            [                
                'nombre' => 'COCINERO',                
            ],
        ]);
    }
}
