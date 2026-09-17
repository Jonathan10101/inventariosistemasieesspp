<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * Columnas reales de la tabla central tenants.
     *
     * Conserva aquí cualquier otra columna personalizada
     * que ya tengas actualmente.
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'trial_started_at',
            'trial_ends_at',
            'subscription_status',
            'subscription_started_at',
            'subscription_ends_at',
        ];
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'trial_started_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'subscription_started_at' => 'datetime',
            'subscription_ends_at' => 'datetime',
        ]);
    }

    /**
     * Determina si actualmente está dentro de la prueba.
     */
    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial'
            && $this->trial_ends_at !== null
            && now()->lt($this->trial_ends_at);
    }

    /**
     * Determina si tiene una suscripción pagada vigente.
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->subscription_status !== 'active') {
            return false;
        }

        /*
         * Una fecha nula puede representar una licencia
         * sin vencimiento definido o administrada manualmente.
         */
        return $this->subscription_ends_at === null
            || now()->lt($this->subscription_ends_at);
    }

    /**
     * Indica si el tenant puede entrar y utilizar INTEVI.
     */
    public function hasSystemAccess(): bool
    {
        if ($this->subscription_status === 'suspended') {
            return false;
        }

        return $this->isOnTrial()
            || $this->hasActiveSubscription();
    }

    /**
     * Días restantes redondeados hacia arriba.
     *
     * Ejemplo:
     * 6 días y 10 horas = muestra 7 días.
     */
    public function trialDaysRemaining(): int
    {
        if (!$this->isOnTrial() || $this->trial_ends_at === null) {
            return 0;
        }

        $remainingSeconds = $this->trial_ends_at->getTimestamp()
            - now()->getTimestamp();

        return max(
            0,
            (int) ceil($remainingSeconds / 86400)
        );
    }

    /**
     * Horas restantes, útil durante el último día.
     */
    public function trialHoursRemaining(): int
    {
        if (!$this->isOnTrial() || $this->trial_ends_at === null) {
            return 0;
        }

        $remainingSeconds = $this->trial_ends_at->getTimestamp()
            - now()->getTimestamp();

        return max(
            0,
            (int) ceil($remainingSeconds / 3600)
        );
    }

    /**
     * Cambia automáticamente una prueba vencida a expired.
     */
    public function markTrialAsExpired(): void
    {
        if (
            $this->subscription_status === 'trial'
            && (
                $this->trial_ends_at === null
                || now()->greaterThanOrEqualTo($this->trial_ends_at)
            )
        ) {
            $this->forceFill([
                'subscription_status' => 'expired',
            ])->save();
        }
    }

    
}