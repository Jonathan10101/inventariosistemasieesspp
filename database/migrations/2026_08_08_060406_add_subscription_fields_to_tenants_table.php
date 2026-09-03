<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table): void {
            $table->timestamp('trial_started_at')
                ->nullable();

            $table->timestamp('trial_ends_at')
                ->nullable()
                ->index();

            /*
             * Estados permitidos:
             *
             * trial     = periodo de prueba
             * active    = licencia pagada
             * expired   = prueba o licencia vencida
             * suspended = institución suspendida manualmente
             *
             * Se deja "active" como valor inicial para no bloquear
             * accidentalmente a los tenants que ya existen.
             */
            $table->string('subscription_status', 30)
                ->default('active')
                ->index();

            $table->timestamp('subscription_started_at')
                ->nullable();

            $table->timestamp('subscription_ends_at')
                ->nullable()
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table): void {
            $table->dropIndex(['trial_ends_at']);
            $table->dropIndex(['subscription_status']);
            $table->dropIndex(['subscription_ends_at']);

            $table->dropColumn([
                'trial_started_at',
                'trial_ends_at',
                'subscription_status',
                'subscription_started_at',
                'subscription_ends_at',
            ]);
        });
    }
};
