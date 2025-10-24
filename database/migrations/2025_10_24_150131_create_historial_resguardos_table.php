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
            $table->unsignedBigInteger('resguardante_id');
            $table->string('resguardo_pdf')->nullable();
            $table->dateTime('fecha_asignacion')->nullable();
            $table->dateTime('fecha_liberacion')->nullable(); // cuando deja de estar asignado
            $table->timestamps();

            $table->foreign('resguardo_id')->references('id')->on('resguardos')->onDelete('cascade');
            $table->foreign('resguardante_id')->references('id')->on('resguardantes')->onDelete('cascade');
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
