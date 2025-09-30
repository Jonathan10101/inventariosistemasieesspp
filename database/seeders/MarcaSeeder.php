<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nombre' => 'DELL'],
            ['nombre' => 'HP'],
            ['nombre' => 'LENOVO'],
            ['nombre' => 'CANON'],
        ]);  
    }
}
