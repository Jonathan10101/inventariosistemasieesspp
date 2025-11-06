<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{    
    public function run(): void
    {
        User::create([
            "name" => "Admin",
            "email" => "jonathanbedollahurtado@gmail.com",
            "password" => bcrypt('JBHjhon13')        
        ])->assignRole("Administrador");  

        User::create([
            "name" => "Alicia",
            "email" => "alicia@ieesspp.com",
            "password" => bcrypt('braulio')        
        ])->assignRole("Empleado");

    }
    
}
