<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EscolaridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('escolaridad')->insert([
            [                
                'nivel_escolaridad' => 'Kinder',                          
            ],
            [                
                'nivel_escolaridad' => 'Primaria',                             
            ],
            [                
                'nivel_escolaridad' => 'Secundaria',                             
            ],
            [                
                'nivel_escolaridad' => 'Preparatoria',                             
            ],
            [                
                'nivel_escolaridad' => 'Universidad',                             
            ],
            [                
                'nivel_escolaridad' => 'Maestria',                             
            ],
            [                
                'nivel_escolaridad' => 'Doctorado',                             
            ],
        ]);
    }
}
