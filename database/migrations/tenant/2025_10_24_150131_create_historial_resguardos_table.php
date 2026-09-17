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
        Schema::create('historial_resguardos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resguardo_id');
            $table->unsignedBigInteger('resguardante_id')->nullable();

            $table->dateTime('fecha_asignacion')->nullable();
            $table->dateTime('fecha_liberacion')->nullable();
            $table->dateTime('fecha_baja')->nullable();

            $table->string('resguardo_pdf')->nullable(); // PDF al asignar
            $table->string('baja_pdf')->nullable();      // PDF al dar de baja
            $table->string('evidencia_baja')->nullable();
            $table->text('motivo_baja')->nullable();
            $table->string('imagen_evidencia')->nullable();
            
            $table->unsignedBigInteger('estado_uso_id')->nullable();
            $table->unsignedBigInteger('area_de_uso_id')->nullable();
            $table->unsignedBigInteger('ubicacion_fisicas_id')->nullable();


            $table->foreign('resguardo_id')->references('id')->on('resguardos')->onDelete('cascade');
            $table->foreign('resguardante_id')->references('id')->on('resguardantes')->onDelete('set null');
            $table->foreign('estado_uso_id')->references('id')->on('estado_uso')->onDelete('set null');
            $table->foreign('area_de_uso_id')->references('id')->on('area_de_uso')->onDelete('set null');
            $table->foreign('ubicacion_fisicas_id')->references('id')->on('ubicacion_fisicas')->onDelete('set null');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_resguardos');
    }
};
