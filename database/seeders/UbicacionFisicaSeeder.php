<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UbicacionFisicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ubicacion_fisicas')->insert([
            ['descripcion' => 'SALA DE COMPUTO COMPLEJO 1'],
            ['descripcion' => 'SALA DE COMPUTO COMPLEJO 2'],
            ['descripcion' => 'GIMNASIO'],
            ['descripcion' => 'COMEDORES COMPLEJO 1'],
            ['descripcion' => 'COMEDORES COMPLEJO 2'],
        ]);
    }
}
