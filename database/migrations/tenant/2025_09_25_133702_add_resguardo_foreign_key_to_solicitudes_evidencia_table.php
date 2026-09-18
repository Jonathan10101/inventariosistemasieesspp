<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Existing tenants may already have this constraint from the original migration.
        foreach (Schema::getForeignKeys('solicitudes_evidencia') as $foreignKey) {
            if ($foreignKey['columns'] === ['resguardo_id']
                && $foreignKey['foreign_table'] === 'resguardos'
                && $foreignKey['foreign_columns'] === ['id']) {
                return;
            }
        }

        Schema::table('solicitudes_evidencia', function (Blueprint $table) {
            $table->foreign('resguardo_id')
                ->references('id')
                ->on('resguardos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes_evidencia', function (Blueprint $table) {
            $table->dropForeign(['resguardo_id']);
        });
    }
};
