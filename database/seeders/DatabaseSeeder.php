<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\EstadoUsoSeeder;
use Database\Seeders\AreaDeUsoSeeder;
use Database\Seeders\UbicacionFisicaSeeder;
use Database\Seeders\PuestoSeeder;
use Database\Seeders\ResguardanteSeeder;
use Database\Seeders\MarcaSeeder;
use Database\Seeders\YearSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {   
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(YearSeeder::class);

        $this->call(EstadoUsoSeeder::class);
        $this->call(AreaDeUsoSeeder::class);
        $this->call(UbicacionFisicaSeeder::class);
        $this->call(PuestoSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(ResguardanteSeeder::class);   
    }
}


