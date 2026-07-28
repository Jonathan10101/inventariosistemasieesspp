<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class TenantUserLimit
{
    /**
     * Obtener el máximo de usuarios permitidos.
     */
    public function limit(): int
    {
        return max(
            1,
            (int) config('intevi.tenant_user_limit', 10)
        );
    }

    /**
     * Obtener la cantidad actual de usuarios del tenant.
     */
    public function used(): int
    {
        return User::query()->count();
    }

    /**
     * Obtener los espacios disponibles.
     */
    public function remaining(): int
    {
        return max(
            0,
            $this->limit() - $this->used()
        );
    }

    /**
     * Saber si el tenant ya alcanzó el límite.
     */
    public function reached(): bool
    {
        return $this->used() >= $this->limit();
    }

    /**
     * Impedir la creación de más usuarios.
     *
     * @throws ValidationException
     */
    public function assertCanCreate(): void
    {
        if (!$this->reached()) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => sprintf(
                'Esta institución alcanzó el límite de %d usuarios permitidos. Elimina un usuario existente antes de registrar uno nuevo.',
                $this->limit()
            ),
        ]);
    }
}