<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\{
    MarcaController,
    ResguardanteController,
    PuestoController,
    UbicacionFisicaController,
    AreaDeAsignacionController,
    InventarioController,
    UserController,
    RolController,
    EtiquetaController,
    Etiqueta2Controller,
    DashboardController,
    ExportController
};

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('inventario', InventarioController::class)
            ->middleware(['auth:sanctum', 'can:inventario.index']);

        Route::resource('marcas', MarcaController::class)
            ->middleware(['can:marcas.index']);

        Route::resource('resguardante', ResguardanteController::class)
            ->middleware(['can:resguardante.index']);

        Route::resource('puestos', PuestoController::class)
            ->middleware(['can:puestos.create']);

        Route::resource('ubicacionfisica', UbicacionFisicaController::class)
            ->middleware(['can:ubicacionfisica.index']);

        Route::resource('areadeasignacion', AreaDeAsignacionController::class)
            ->middleware(['can:areadeasignacion.create']);

        Route::resource('usuarios', UserController::class)
            ->middleware(['can:puestos.create']);

        Route::resource('roles', RolController::class)
            ->middleware(['can:puestos.create']);

        Route::get('/etiqueta/{codigo}', [EtiquetaController::class, 'show'])
            ->name('etiquetas.show')
            ->middleware(['can:inventario.index']);

        Route::get('/etiqueta2/{codigo}', [Etiqueta2Controller::class, 'show'])
            ->name('etiquetas2.show')
            ->middleware(['can:inventario.index']);

        Route::get('/export', [ExportController::class, 'export'])
            ->name('export');
    });

});