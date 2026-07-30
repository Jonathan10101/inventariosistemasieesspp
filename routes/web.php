<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sitio central de INTEVI
|--------------------------------------------------------------------------
|
| Este archivo controla únicamente los dominios centrales definidos en
| config/tenancy.php, por ejemplo intevi.app y www.intevi.app.
|
| Las rutas de los tenants permanecen en routes/tenant.php.
|
*/

foreach (config('tenancy.central_domains', []) as $index => $domain) {
    Route::domain($domain)
        ->middleware('web')
        ->group(function () use ($index): void {
            Route::view('/', 'central.home')
                ->name(
                    $index === 0
                        ? 'central.home'
                        : "central.home.{$index}"
                );

            Route::view('/landing', 'central.home2')
                ->name(
                    $index === 0
                        ? 'central.home2'
                        : "central.home2.{$index}"
                );

            Route::view('/aviso-de-privacidad', 'central.privacy')
                ->name(
                    $index === 0
                        ? 'privacidad'
                        : "privacidad.{$index}"
                );

            Route::view('/terminos-del-servicio', 'central.terms')
                ->name(
                    $index === 0
                        ? 'terminos'
                        : "terminos.{$index}"
                );

            Route::view('/condiciones-comerciales', 'central.commercial')
                ->name(
                    $index === 0
                        ? 'condiciones.comerciales'
                        : "condiciones.comerciales.{$index}"
                );

            Route::get('/conexion-intevi', function () {
                return response()
                    ->noContent()
                    ->header(
                        'Cache-Control',
                        'no-store, no-cache, must-revalidate, max-age=0'
                    )
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
            })->name(
                $index === 0
                    ? 'central.connection'
                    : "central.connection.{$index}"
            );
        });
}
