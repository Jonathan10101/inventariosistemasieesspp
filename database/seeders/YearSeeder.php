<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('years')->insert([
            [                
                'number' => 2024,             
            ],
            [                
                'number' => 2025,             
            ],     
            [                
                'number' => 2026,             
            ],         
            [                
                'number' => 2027,             
            ],  
            [                
                'number' => 2028,             
            ],  
            [                
                'number' => 2029,             
            ],  
            [                
                'number' => 2030,             
            ],  
            [                
                'number' => 2031,             
            ],  
            [                
                'number' => 2032,             
            ],  
            [                
                'number' => 2033,             
            ],  
            [                
                'number' => 2034,             
            ],  
            
        ]);
    }
}
