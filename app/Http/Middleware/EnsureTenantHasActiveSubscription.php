<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantHasActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();

        /*
         * Si por alguna razón la petición no pertenece a un tenant,
         * este middleware no interviene.
         */
        if ($tenant === null) {
            return $next($request);
        }

        if ($tenant->hasSystemAccess()) {
            return $next($request);
        }

        /*
         * Actualiza el estado solamente cuando realmente venció
         * un periodo de prueba.
         */
        $tenant->markTrialAsExpired();

        /*
         * Evita que los métodos Livewire puedan ejecutarse después
         * del vencimiento, incluso si el usuario dejó abierta la página.
         */
        if ($request->hasHeader('X-Livewire')) {
            return response(
                content: 'INTEVI_TRIAL_EXPIRED',
                status: 402
            )->header('X-INTEVI-TRIAL-EXPIRED', '1');
        }

        return redirect()->route('subscription.expired');
    }
}