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
        Schema::create('solicitudes_evidencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resguardo_id');
            $table->unsignedBigInteger('resguardante_id')->nullable(); // a quien se solicita
            $table->dateTime('scheduled_at'); // cuando se generó la solicitud
            $table->dateTime('due_at')->nullable(); // fecha límite para subir evidencia
            $table->dateTime('sent_at')->nullable();
            $table->enum('status', ['pending','sent','completed','overdue','cancelled'])->default('pending');
            $table->unsignedSmallInteger('reminder_count')->default(0);
            $table->unsignedBigInteger('evidencia_id')->nullable(); // se llena cuando el usuario sube la evidencia
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
        Schema::dropIfExists('solicitudes_evidencia');
    }
};
