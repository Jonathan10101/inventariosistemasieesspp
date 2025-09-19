<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{    
    public function run(): void
    {
        /*
        Esto lo comente porque ya los habia registrado y ya estan en la base de datos
        User::create([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => bcrypt('ieesspp2024!')        
        ])->assignRole("Admin");

        User::create([
            "name" => "Jonathan",
            "email" => "jonathanbedolla@alumno.com",
            "password" => bcrypt('jon332$Ee')        
        ])->assignRole("Alumno");

        User::create([
            "name" => "Oscar",
            "email" => "oscarmedina@profesor.com",
            "password" => bcrypt('medina45#32')        
        ])->assignRole("Profesor");
       
        User::create([
            "name" => "Alfredo",
            "email" => "alfredogarcia@administrativo.com",
            "password" => bcrypt('Garcia$32')        
        ])->assignRole("Administrativo");     
        */
        User::create([
            "name" => "Admin",
            "email" => "admin@ieesspp.com",
            "password" => bcrypt('ieesspp2025!')        
        ])->assignRole("Administrador");
        
        User::create([
            "name" => "Control Escolar",
            "email" => "controlescolar@ieesspp.com",
            "password" => bcrypt('contRolscolar2025#')        
        ])->assignRole("ControlEscolar");   

        User::create([
            "name" => "Profezionalizacion",
            "email" => "profesionalizacion@ieesspp.com",
            "password" => bcrypt('profesionalizaciOn2025$')        
        ])->assignRole("Profesionalizacion");   
    }
    
}
