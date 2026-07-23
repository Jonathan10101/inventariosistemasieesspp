<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AreaDeAsignacionController,
    DashboardController,
    Etiqueta2Controller,
    EtiquetaController,
    ExportController,
    InventarioController,
    MarcaController,
    PuestoController,
    ResguardanteController,
    RolController,
    UbicacionFisicaController,
    UserController
};

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Rutas de los tenants
|--------------------------------------------------------------------------
|
| Estas rutas funcionan para dominios como:
|
| https://ieesspp.intevi.app
| https://demo.intevi.app
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Página principal del tenant
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('dashboard')
            : redirect()->route('login');
    })->name('tenant.home');

    /*
    |--------------------------------------------------------------------------
    | Rutas protegidas
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Inventario
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'inventario',
            InventarioController::class
        )->middleware('can:inventario.index');

        /*
        |--------------------------------------------------------------------------
        | Marcas
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'marcas',
            MarcaController::class
        )->middleware('can:marcas.index');

        /*
        |--------------------------------------------------------------------------
        | Resguardantes
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'resguardante',
            ResguardanteController::class
        )->middleware('can:resguardante.index');

        /*
        |--------------------------------------------------------------------------
        | Puestos
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'puestos',
            PuestoController::class
        )->middleware('can:puestos.create');

        /*
        |--------------------------------------------------------------------------
        | Ubicaciones físicas
        |--------------------------------------------------------------------------
        |
        | El controlador solamente tiene los métodos:
        |
        | index()
        | show()
        |
        */
        Route::get(
            '/ubicacionfisica',
            [UbicacionFisicaController::class, 'index']
        )->name('ubicacionfisica.index')
         ->middleware('can:ubicacionfisica.index');
         
        Route::get(
            '/ubicacionfisica/{ubicacionfisica}',
            [UbicacionFisicaController::class, 'show']
        )->name('ubicaciones.show')
         ->middleware('can:ubicacionfisica.index');



        /*
        |--------------------------------------------------------------------------
        | Áreas de asignación
        |--------------------------------------------------------------------------
        |
        | El controlador solamente tiene los métodos:
        |
        | index()
        | store()
        |
        */

        Route::controller(AreaDeAsignacionController::class)
            ->prefix('areadeasignacion')
            ->name('areadeasignacion.')
            ->group(function () {

                Route::get('/', 'index')
                    ->name('index')
                    ->middleware('can:areadeasignacion.index');

                Route::post('/', 'store')
                    ->name('store')
                    ->middleware('can:areadeasignacion.create');
            });

        /*
        |--------------------------------------------------------------------------
        | Usuarios
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'usuarios',
            UserController::class
        )->middleware('can:puestos.create');

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'roles',
            RolController::class
        )->middleware('can:puestos.create');

        /*
        |--------------------------------------------------------------------------
        | Etiqueta principal
        |--------------------------------------------------------------------------
        */

        Route::get('/etiqueta/{codigo}', [
            EtiquetaController::class,
            'show',
        ])
            ->name('etiquetas.show')
            ->middleware('can:inventario.index');

        /*
        |--------------------------------------------------------------------------
        | Segunda etiqueta
        |--------------------------------------------------------------------------
        */

        Route::get('/etiqueta2/{codigo}', [
            Etiqueta2Controller::class,
            'show',
        ])
            ->name('etiquetas2.show')
            ->middleware('can:inventario.index');

        /*
        |--------------------------------------------------------------------------
        | Exportación
        |--------------------------------------------------------------------------
        */

        Route::get('/export', [
            ExportController::class,
            'export',
        ])
            ->name('export')
            ->middleware('can:inventario.index');
    });
});