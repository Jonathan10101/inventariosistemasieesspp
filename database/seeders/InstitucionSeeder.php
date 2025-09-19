<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instituciones')->insert([
            [
                'nombre' => 'SECRETARIA DE SEGURIDAD PUBLICA DEL ESTADO DE MICHOACAN (SSP)',
                'url_imagen' => 'guardiacivillogo.png'
            ],
            [
                'nombre' => 'SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL DE SEGURIDAD PUBLICA (SESESP)',
                'url_imagen' => 'sesesp.png'
            ],

        ]);        
    }
    
}
