<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ResguardanteSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('resguardantes')->insert([
            ['nombre1' => 'ALFREDO','nombre2' => '','apellido1'=>"ALVARADO",'apellido2'=>'CONTRERAS'],
            ['nombre1' => 'JONATHAN','nombre2' => '','apellido1'=>"BEDOLLA",'apellido2'=>'HURTADO'],

        ]);  
    }

}
