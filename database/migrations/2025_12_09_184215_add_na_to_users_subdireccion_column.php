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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('subdireccion', [
                'SUBDIRECCIÓN DE DESARROLLO POLICIAL',
                'SUBDIRECCIÓN DE COORDINACIÓN E INFRAESTRUCTURA INSTITUCIONAL',
                'NA'
            ])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('subdireccion', [
                'SUBDIRECCIÓN DE DESARROLLO POLICIAL',
                'SUBDIRECCIÓN DE COORDINACIÓN E INFRAESTRUCTURA INSTITUCIONAL',
            ])->nullable()->change();
        });
    }
};
