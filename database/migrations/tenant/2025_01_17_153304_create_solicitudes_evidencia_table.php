<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL may keep the table when the original foreign key statement fails.
        // Let Laravel record the migration on retry without losing existing rows.
        if (Schema::hasTable('solicitudes_evidencia')) {
            if (! Schema::hasColumns('solicitudes_evidencia', [
                'id', 'resguardo_id', 'motivo', 'estado', 'created_at', 'updated_at',
            ])) {
                throw new \RuntimeException(
                    'La tabla solicitudes_evidencia existe con una estructura incompleta; revise sus columnas antes de continuar.'
                );
            }

            return;
        }

        Schema::create('solicitudes_evidencia', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resguardo_id');

            $table->text('motivo')->nullable();

            $table->string('estado')->default('pendiente');

            $table->timestamps();

            // The foreign key is added after the resguardos table exists.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_evidencia');
    }
};