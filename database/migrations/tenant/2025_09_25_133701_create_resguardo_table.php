<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resguardos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->unsignedBigInteger("cantidad");
            $table->unsignedBigInteger('marca_id');
            $table->string('modelo');
            //$table->string('nserie')->unique();
            $table->string('nserie', 50); // quitar ->unique()
            $table->string('nresguardo')->nullable()->unique();

 
            $table->unsignedBigInteger('resguardante_id')->nullable();
            $table->unsignedBigInteger('puesto_id')->nullable();

            $table->string('imagen')->nullable();
            $table->enum('estado_actual', ['disponible', 'asignado', 'baja'])->default('disponible');

            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
            $table->foreign('resguardante_id')->references('id')->on('resguardantes')->onDelete('set null');
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resguardos');
    }
};
