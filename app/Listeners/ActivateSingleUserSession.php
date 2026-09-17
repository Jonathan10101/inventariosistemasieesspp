<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Str;

class ActivateSingleUserSession
{
    /**
     * Genera una nueva sesión exclusiva cuando el usuario inicia sesión.
     */
    public function handle(Login $event): void
    {
        /*
         * Token que solamente se guarda dentro de la sesión actual
         * del navegador.
         */
        $plainToken = Str::random(80);

        session()->put('active_session_token', $plainToken);

        /*
         * En la base de datos no guardamos el token original.
         * Solamente guardamos su hash SHA-256.
         */
        $event->user->forceFill([
            'active_session_token' => hash('sha256', $plainToken),
        ])->saveQuietly();
    }
}