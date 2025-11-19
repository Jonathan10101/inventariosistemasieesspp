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
            "name" => "Administrador",
            "email" => "admin@ieesspp.com",
            "password" => bcrypt('JBHjhon13')
        ])->assignRole("Administrador");

        User::create([
            "name" => "Jonathan Bedolla Hurtado",
            "email" => "jonathan.bedolla@ieesspp.com",
            "password" => bcrypt('Jonathan#47')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Alicia Maldonado Flores",
            "email" => "alicia.maldonado@ieesspp.com",
            "password" => bcrypt('Alicia*83')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Yuvitzy Rebollar Rivera",
            "email" => "yuvitzy.rebollar@ieesspp.com",
            "password" => bcrypt('Yuvitzy!66')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Blanca Esthela Padilla Garcia",
            "email" => "blanca.padilla@ieesspp.com",
            "password" => bcrypt('Blanca$12')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Angelica Herrera Zavala",
            "email" => "angelica.herrera@ieesspp.com",
            "password" => bcrypt('Angelica%91')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Antonia Delgado Hernandez",
            "email" => "antonia.delgado@ieesspp.com",
            "password" => bcrypt('Antonia&34')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Beatriz Cervantes Velazquez",
            "email" => "beatriz.cervantes@ieesspp.com",
            "password" => bcrypt('Beatriz#77')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Bryan Alexis Ayala Ambriz",
            "email" => "bryan.ayala@ieesspp.com",
            "password" => bcrypt('Bryan*22')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Carolina Cruz Garcia",
            "email" => "carolina.cruz@ieesspp.com",
            "password" => bcrypt('Carolina!59')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Citlali Marcela Gaytan",
            "email" => "citlali.marcela@ieesspp.com",
            "password" => bcrypt('Citlali$41')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Cristina Gonzalez Martinez",
            "email" => "cristina.gonzalez@ieesspp.com",
            "password" => bcrypt('Cristina%73')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Jose Guadalupe Rodriguez Barajas",
            "email" => "jose.rodriguez@ieesspp.com",
            "password" => bcrypt('Jose&84')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Dafne Quintanilla Moreno",
            "email" => "dafne.quintanilla@ieesspp.com",
            "password" => bcrypt('Dafne#19')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Maria De J. Gallegos Ramirez",
            "email" => "maria.gallegos@ieesspp.com",
            "password" => bcrypt('Maria*52')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Monica Esmeralda Lopez Zizumbo",
            "email" => "monica.lopez@ieesspp.com",
            "password" => bcrypt('Monica!88')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Eva Maria Martinez Hernandez",
            "email" => "eva.martinez@ieesspp.com",
            "password" => bcrypt('Eva$33')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Evelia Alcantar León",
            "email" => "evelia.alcantar@ieesspp.com",
            "password" => bcrypt('Evelia%64')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Evelia Mora Hernandez",
            "email" => "evelia.mora@ieesspp.com",
            "password" => bcrypt('Evelia&27')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Fermin Calderon Calderon",
            "email" => "fermin.calderon@ieesspp.com",
            "password" => bcrypt('Fermin#92')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Francisco Javier Villagomez Navarrete",
            "email" => "francisco.villagomez@ieesspp.com",
            "password" => bcrypt('Francisco*81')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Geovani Vijosa Ibarra",
            "email" => "geovani.vijosa@ieesspp.com",
            "password" => bcrypt('Geovani!45')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Graciela Gutierrez Martinez",
            "email" => "graciela.gutierrez@ieesspp.com",
            "password" => bcrypt('Graciela$24')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Hannia Michelle Gonzalez Calderon",
            "email" => "hannia.gonzalez@ieesspp.com",
            "password" => bcrypt('Hannia%63')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Hector Perez Garcia",
            "email" => "hector.perez@ieesspp.com",
            "password" => bcrypt('Hector&18')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Iliana Marisol Perez Carrillo",
            "email" => "iliana.perez@ieesspp.com",
            "password" => bcrypt('Iliana#74')
        ])->assignRole("Empleado");

        User::create([
            "name" => "J. Silvestre Dominguez Cadenas",
            "email" => "silvestre.dominguez@ieesspp.com",
            "password" => bcrypt('Silvestre*29')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Jovanna Janet Lopez Menera",
            "email" => "jovanna.lopez@ieesspp.com",
            "password" => bcrypt('Jovanna!67')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Juan Daniel Gonzalez Rodriguez",
            "email" => "juan.gonzalez@ieesspp.com",
            "password" => bcrypt('Juan$56')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Juan Ricardo Zavala Alvarez",
            "email" => "juan.zavala@ieesspp.com",
            "password" => bcrypt('Ricardo%11')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Julian Salomon Camacho Rodriguez",
            "email" => "julian.camacho@ieesspp.com",
            "password" => bcrypt('Julian&39')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Laura Serna Gomez",
            "email" => "laura.serna@ieesspp.com",
            "password" => bcrypt('Laura#68')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Estefania Almanza Lagunas",
            "email" => "estefania.almanza@ieesspp.com",
            "password" => bcrypt('Estefania*95')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Leonardo Rene Roman Dominguez",
            "email" => "leonardo.roman@ieesspp.com",
            "password" => bcrypt('Leonardo!72')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Leticia Bedolla Chavez",
            "email" => "leticia.bedolla@ieesspp.com",
            "password" => bcrypt('Leticia$44')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Maria Del Socorro Dominguez B.",
            "email" => "maria.dominguez@ieesspp.com",
            "password" => bcrypt('Socorro%57')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Maria Guadalupe Ochoa Dom.",
            "email" => "maria.ochoa@ieesspp.com",
            "password" => bcrypt('Guadalupe&21')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Mario Iran Fuentes Ramirez",
            "email" => "mario.fuentes@ieesspp.com",
            "password" => bcrypt('Mario#14')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Miriam Bernal Maldonado",
            "email" => "miriam.bernal@ieesspp.com",
            "password" => bcrypt('Miriam*53')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Nadir Montelongo Martinez",
            "email" => "nadir.montelongo@ieesspp.com",
            "password" => bcrypt('Nadir!32')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Oswaldo Martinez Gonzalez",
            "email" => "oswaldo.martinez@ieesspp.com",
            "password" => bcrypt('Oswaldo$61')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Paola Monserrat Mancera C.",
            "email" => "paola.mancera@ieesspp.com",
            "password" => bcrypt('Paola%48')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Patricio Andrade Salgado",
            "email" => "patricio.andrade@ieesspp.com",
            "password" => bcrypt('Patricio&25')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Paulina Rizo Botello",
            "email" => "paulina.rizo@ieesspp.com",
            "password" => bcrypt('Paulina#96')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Pedro Lopez Menera",
            "email" => "pedro.lopez@ieesspp.com",
            "password" => bcrypt('Pedro*58')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Perla Yolanda Naranjo Cruz",
            "email" => "perla.naranjo@ieesspp.com",
            "password" => bcrypt('Perla!43')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Ramon Orozco Velazquez",
            "email" => "ramon.orozco@ieesspp.com",
            "password" => bcrypt('Ramon$69')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Rogelio Arriaga Guzman",
            "email" => "rogelio.arriaga@ieesspp.com",
            "password" => bcrypt('Rogelio%28')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Yoqsan Azael Perez Melendez",
            "email" => "yoqsan.perez@ieesspp.com",
            "password" => bcrypt('Yoqsan&55')
        ])->assignRole("Empleado");

        User::create([
            "name" => "Yunuen Ireri Villanueva Palencia",
            "email" => "yunuen.villanueva@ieesspp.com",
            "password" => bcrypt('Yunuen#31')
        ])->assignRole("Empleado");
    }
    
}
