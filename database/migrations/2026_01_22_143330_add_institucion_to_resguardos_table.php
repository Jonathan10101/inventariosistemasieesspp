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
        Schema::table('resguardos', function (Blueprint $table) {
            $table->string('institucion', 20)->default('IEESSPP')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resguardos', function (Blueprint $table) {
            $table->dropColumn('institucion');
        });
    }
};
