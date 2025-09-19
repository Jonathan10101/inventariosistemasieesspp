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
        Schema::create('estatus_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->enum('estatus', ['ACTIVO', 'BAJA'])->default('ACTIVO');
            $table->date('fecha_baja')->nullable();
            $table->text('motivo_baja')->nullable();
            $table->timestamps();

            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatus_estudiantes');
    }
};
