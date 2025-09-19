<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1', 50);
            $table->string('nombre2', 50)->nullable();
            $table->string('apellido1', 50);
            $table->string('apellido2', 50)->nullable();
            $table->string('matricula_cuip', 20)->unique();            
            $table->unsignedBigInteger('municipio_id');
            $table->string('curp', 18)->unique();
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('escolaridad_id');
            $table->enum('genero', ['M', 'H']);
            $table->string('correo_electronico', 100);
            $table->string('celular', 25)->unique();
            $table->string('cuip')->nullable()->unique();

            

       

            

            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('escolaridad_id')->references('id')->on('escolaridad');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
};
