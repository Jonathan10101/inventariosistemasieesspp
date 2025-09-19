<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [                
                'name' => 'Carnes',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [                
                'name' => 'Lacteos',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [                
                'name' => 'Abarrotes',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [                
                'name' => 'Frutas',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [                
                'name' => 'Gas LP',                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Agregar más productos según sea necesario
        ]);
    }
}
