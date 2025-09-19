<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1',25)->nullable(false);
            $table->string('nombre2',25)->nullable(false);
            $table->string('apellido1',25)->nullable(false);
            $table->string('apellido2',25)->nullable(false);
            $table->timestamps();
            
            // Asegurar unicidad combinada
            $table->unique(['nombre1', 'nombre2', 'apellido1', 'apellido2']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructores');
    }
};
