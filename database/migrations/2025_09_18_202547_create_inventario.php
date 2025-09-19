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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 50)->nullable();
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('numerodeserie', 50)->nullable();
            $table->string('numerodeinventario', 50)->nullable();
            $table->string('numeroderesguardo', 50)->nullable();
            $table->string('estadodeuso', 50)->nullable();
            $table->string('areadeasignacion', 50)->nullable();
            $table->string('ubicacionfisica', 50)->nullable();
            $table->string('nombreusuarioresguardante', 50)->nullable();
            $table->string('puestousuarioresguardante', 50)->nullable();
            $table->string('numerodeinventarioactualizado', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
