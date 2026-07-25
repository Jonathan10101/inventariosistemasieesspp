<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSingleUserSession
{
    /**
     * Comprueba que la sesión actual sea la última
     * sesión iniciada por el usuario.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
         * Si todavía no inició sesión, el middleware
         * no tiene nada que validar.
         */
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        /*
         * Token guardado dentro de la sesión actual.
         */
        $sessionToken = $request->session()->get(
            'active_session_token'
        );

        /*
         * Token cifrado registrado como la sesión activa
         * más reciente del usuario.
         */
        $databaseToken = $user->active_session_token;

        $sessionIsValid =
            is_string($sessionToken) &&
            $sessionToken !== '' &&
            is_string($databaseToken) &&
            $databaseToken !== '' &&
            hash_equals(
                $databaseToken,
                hash('sha256', $sessionToken)
            );

        if (! $sessionIsValid) {
            /*
             * Cierra únicamente esta sesión.
             * No altera la sesión más reciente del usuario.
             */
            Auth::guard('web')->logoutCurrentDevice();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tu sesión fue cerrada porque esta cuenta inició sesión en otro dispositivo.',
                ]);
        }

        return $next($request);
    }
}