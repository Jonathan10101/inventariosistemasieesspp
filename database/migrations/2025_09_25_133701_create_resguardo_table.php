<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resguardos', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion");
            $table->unsignedBigInteger('marca_id');
            $table->string("modelo");
            $table->string("nserie")->unique();
            $table->string("nresguardo")->nullable()->unique();
            $table->unsignedBigInteger('estado_uso_id');
            $table->unsignedBigInteger('area_de_uso_id');
            $table->unsignedBigInteger('ubicacion_fisicas_id');
            $table->unsignedBigInteger('resguardante_id');
            $table->unsignedBigInteger('puesto_id');
            $table->unsignedBigInteger('resguardo_id');

              
            // Imagen del producto original
            $table->string("imagen")->nullable();
            $table->string("resguardo_pdf")->nullable();


            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('estado_uso_id')->references('id')->on('estado_uso');
            $table->foreign('area_de_uso_id')->references('id')->on('area_de_uso');
            $table->foreign('ubicacion_fisicas_id')->references('id')->on('ubicacion_fisicas');
            $table->foreign('resguardante_id')->references('id')->on('resguardantes');
            $table->foreign('puesto_id')->references('id')->on('puestos');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardos');
    }
};
