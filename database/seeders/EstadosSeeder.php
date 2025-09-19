<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
            [
                'nombre' => 'Ciudad de México',
            ],
            [
                'nombre' => 'Aguascalientes',
            ],
            [
                'nombre' => 'Baja California',
            ],
            [
                'nombre' => 'Baja California Sur',
            ],
            [
                'nombre' => 'Campeche',
            ],
            [
                'nombre' => 'Chiapas',
            ],
            [
                'nombre' => 'Chihuahua',
            ],
            [
                'nombre' => 'Coahuila de Zaragoza',
            ],
            [
                'nombre' => 'Colima',
            ],
            [
                'nombre' => 'Durango',
            ],
            [
                'nombre' => 'Guanajuato',
            ],
            [
                'nombre' => 'Guerrero',
            ],
            [
                'nombre' => 'Hidalgo',
            ],
            [
                'nombre' => 'Jalisco',
            ],
            [
                'nombre' => 'Estado de México',
            ],
            [
                'nombre' => 'Michoacán de Ocampo',
            ],
            [
                'nombre' => 'Morelos',
            ],
            [
                'nombre' => 'Nayarit',
            ],
            [
                'nombre' => 'Nuevo León',
            ],
            [
                'nombre' => 'Oaxaca',
            ],
            [
                'nombre' => 'Puebla',
            ],
            [
                'nombre' => 'Querétaro',
            ],
            [
                'nombre' => 'Quintana Roo',
            ],
            [
                'nombre' => 'San Luis Potosí',
            ],
            [
                'nombre' => 'Sinaloa',
            ],
            [
                'nombre' => 'Sonora',
            ],
            [
                'nombre' => 'Tabasco',
            ],
            [
                'nombre' => 'Tamaulipas',
            ],
            [
                'nombre' => 'Tlaxcala',
            ],
            [
                'nombre' => 'Veracruz',
            ],
            [
                'nombre' => 'Yucatán',
            ],
            [
                'nombre' => 'Zacatecas',
            ]            
            ]);
    }
}
