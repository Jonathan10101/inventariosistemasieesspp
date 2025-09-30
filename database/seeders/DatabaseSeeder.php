<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\EstadoUsoSeeder;
use Database\Seeders\AreaDeUsoSeeder;
use Database\Seeders\UbicacionFisicaSeeder;
use Database\Seeders\PuestoSeeder;
use Database\Seeders\ResguardanteSeeder;

use Database\Seeders\MunicipiosSeeder;
use Database\Seeders\AdscripcionesSeeder;
use Database\Seeders\SedesSeeder;
use Database\Seeders\GruposSeeder;
use Database\Seeders\EscolaridadSeeder;
use Database\Seeders\GeneracionSeeder;
use Database\Seeders\CursoSeeder;
use Database\Seeders\EstadosSeeder;
use Database\Seeders\YearSeeder;
use Database\Seeders\InstitucionSeeder;
use Database\Seeders\MarcaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //$this->call(CategorySeeder::class);
        $this->call(EstadoUsoSeeder::class);
        $this->call(AreaDeUsoSeeder::class);
        $this->call(UbicacionFisicaSeeder::class);
        $this->call(PuestoSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(ResguardanteSeeder::class);



        $this->call(EstadosSeeder::class);
        $this->call(MunicipiosSeeder::class);
        
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdscripcionesSeeder::class);
        $this->call(SedesSeeder::class);
        $this->call(GruposSeeder::class);
        $this->call(EscolaridadSeeder::class);
        $this->call(GeneracionSeeder::class);
        $this->call(CursoSeeder::class);
        $this->call(YearSeeder::class);
        $this->call(InstitucionSeeder::class);

        
        //$this->call(EscolaridadSeeder::class);
        //$this->call(ProductsSeeder::class);
        
        
        
    }
}


