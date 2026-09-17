<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_evidencia', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resguardo_id');

            $table->text('motivo')->nullable();

            $table->string('estado')->default('pendiente');

            $table->timestamps();

            $table->foreign('resguardo_id')
                ->references('id')
                ->on('resguardos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_evidencia');
    }
};