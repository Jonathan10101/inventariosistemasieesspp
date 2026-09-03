<?php

declare(strict_types=1);

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
        Schema::create('tenant_email_domains', function (Blueprint $table) {
            $table->id();

            /*
             * ID del tenant de stancl/tenancy.
             *
             * Lo dejamos como string porque stancl/tenancy utiliza
             * IDs string/UUID por defecto.
             */
            $table->string('tenant_id')->index();

            /*
             * Dominio de correo autorizado.
             *
             * Ejemplos:
             * ieesspp.edu.mx
             * umich.mx
             * empresa.com
             */
            $table->string('email_domain')->unique();

            /*
             * Permite desactivar el acceso sin borrar
             * la configuración.
             */
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_email_domains');
    }
};