<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing page central de INTEVI
|--------------------------------------------------------------------------
|
| Esta ruta únicamente se mostrará en los dominios centrales definidos
| dentro de config/tenancy.php.
|
*/

foreach (config('tenancy.central_domains') as $index => $domain) {
    Route::domain($domain)
        ->middleware(['web'])
        ->group(function () use ($index) {
            Route::view('/', 'central.home')
                ->name(
                    $index === 0
                        ? 'central.home2'
                        : "central.home2.{$index}"
                );
        });
}

/*
use Illuminate\Support\Facades\{Route, Auth, Redirect};

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

Route::get('/', function () {
    if (!Auth::check()) {
        return Redirect::route('login');
    }

    return Redirect::route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::resource("inventario", InventarioController::class)->middleware(['auth:sanctum', 'can:inventario.index']);
Route::resource("marcas", MarcaController::class)->middleware(['auth:sanctum', 'can:marcas.index']);
Route::resource('resguardante', ResguardanteController::class)->middleware(['auth:sanctum', 'can:resguardante.index']);
Route::resource('puestos', PuestoController::class)->middleware(['auth:sanctum', 'can:puestos.create']);
Route::resource("ubicacionfisica", UbicacionFisicaController::class)->middleware(['auth:sanctum', 'can:ubicacionfisica.index']);
Route::resource("areadeasignacion", AreaDeAsignacionController::class)->middleware(['auth:sanctum', 'can:areadeasignacion.create']);
Route::resource('usuarios', UserController::class)->middleware(['auth:sanctum', 'can:puestos.create']);
Route::resource('roles', RolController::class)->middleware(['auth:sanctum', 'can:puestos.create']);

Route::get('/etiqueta/{codigo}', [EtiquetaController::class, 'show'])
    ->name('etiquetas.show')
    ->middleware(['auth:sanctum', 'can:inventario.index']);

Route::get('/etiqueta2/{codigo}', [Etiqueta2Controller::class, 'show'])
    ->name('etiquetas2.show')
    ->middleware(['auth:sanctum', 'can:inventario.index']);

Route::get('/export', [ExportController::class, 'export'])->name('export');
*/
