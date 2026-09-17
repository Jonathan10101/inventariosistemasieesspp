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
        Schema::create('evidencias_resguardo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resguardo_id');
            $table->unsignedBigInteger('solicitud_evidencia_id')->nullable();

            $table->date('fecha_evidencia');
            $table->string('tipo')->default('foto'); // foto o video
            $table->string('archivo'); // ruta del archivo
            $table->text('observaciones')->nullable(); // comentarios del estado
            $table->timestamps();

            $table->foreign('resguardo_id')->references('id')->on('resguardos')->onDelete('cascade');
            $table->foreign('solicitud_evidencia_id')->references('id')->on('solicitudes_evidencia')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias_resguardo');
    }
};
