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
        Schema::create('movimientos_resguardo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resguardo_id');
            $table->unsignedBigInteger('resguardante_id');
            $table->date('fecha_entrega')->nullable(); // cuándo se asignó
            $table->date('fecha_recepcion')->nullable(); // cuándo se devolvió o cambió
            $table->string('motivo')->nullable(); // cambio, baja, mantenimiento, etc.
            $table->timestamps();

            $table->foreign('resguardo_id')->references('id')->on('resguardos')->onDelete('cascade');
            $table->foreign('resguardante_id')->references('id')->on('resguardantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_resguardo');
    }
};
