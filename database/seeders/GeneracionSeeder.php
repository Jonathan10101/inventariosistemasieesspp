<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('generaciones')->insert([
            [                
                'nombre_generacion' => 'NINGUNA',
                'fecha_inicio' => '2000-01-01',
                'fecha_terminacion' => '2020-01-01'                        
            ],
            [                
                'nombre_generacion' => 'GENERACION 2024',
                'fecha_inicio' => '2024-01-01',
                'fecha_terminacion' => '2024-12-31'                        
            ],
            [                
                'nombre_generacion' => 'GENERACION 2025',                
                'fecha_inicio' => '2025-01-01',
                'fecha_terminacion' => '2025-12-31'                                                     
            ],
           
        ]);
    }
}
