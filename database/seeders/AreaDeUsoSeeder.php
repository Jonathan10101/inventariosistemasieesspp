<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreaDeUsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('area_de_uso')->insert([
            ['nombre' => 'DIRECCIÓN GENERAL'],
            ['nombre' => 'SUBDIRECCIÓN DE DESARROLLO POLICIAL'],                
            ['nombre' => 'DEPARTAMENTO DE PROFESIONALIZACIÓN POLICIAL'],  
            ['nombre' => 'DEPARTAMENTO DE COMANDANCIA DE CUERPO DE CADETES Y REGULACIÓN DE INSTRUCTORES'],  
            ['nombre' => 'DEPARTAMENTO DE CONTROL ESCOLAR Y SEGUIMIENTO ACADÉMICO'],  
            ['nombre' => 'SUBDIRECCIÓN DE COORDINACIÓN E INFRAESTRUCTURA INSTITUCIONAL'],  
            ['nombre' => 'DEPARTAMENTO DE COORDINACIÓN Y VINCULACIÓN'],  
            ['nombre' => 'DEPARTAMENTO DE INFRAESTRUCTURA INSTITUCIONAL'],  
            ['nombre' => 'DEPARTAMENTO DE DIFUSIÓN'], 
            ['nombre' => 'DEPARTAMENTO JURÍDICA'], 
            ['nombre' => 'DELEGACIÓN ADMINISTRATIVA'], 
            ['nombre' => 'DEPARTAMENTO DE ADMINISTRACIÓN FINANCIERA DE RECURSOS HUMANOS Y MATERIALES'], 
        ]);
    }
}
