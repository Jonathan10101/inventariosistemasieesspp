<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AreaDeAsignacionController,
    DashboardController,
    Etiqueta2Controller,
    EtiquetaController,
    InventarioController,
    MarcaController,
    PuestoController,
    ResguardanteController,
    RolController,
    UbicacionFisicaController
};

use App\Http\Middleware\EnsureSingleUserSession;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Rutas de los tenants
|--------------------------------------------------------------------------
|
| Estas rutas funcionan únicamente dentro de los dominios de los tenants:
|
| https://ieesspp.intevi.app
| https://demo.intevi.app
|
| Primero se identifica el tenant mediante el dominio y posteriormente
| se ejecutan las rutas correspondientes.
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Comprobación de conexión
    |--------------------------------------------------------------------------
    |
    | Esta ruta es utilizada por public/js/intevi-offline.js para verificar
    | que realmente exista conexión con el servidor de INTEVI.
    |
    | Debe permanecer fuera del middleware de autenticación.
    |
    */

    Route::get('/conexion-intevi', function () {
        return response()
            ->noContent()
            ->header(
                'Cache-Control',
                'no-store, no-cache, must-revalidate, max-age=0'
            )
            ->header('Pragma', 'no-cache');
    })->name('tenant.connection');



    /*
     * Esta ruta debe seguir disponible aunque la prueba haya vencido.
     */
    Route::middleware(['auth'])->group(function (): void {
        Route::view(
            '/suscripcion-vencida',
            'tenant.subscription-expired'
        )->name('subscription.expired');
    });

    /*
     * Aquí van todas las rutas protegidas de INTEVI.
     */
    Route::middleware([
        'auth',
        'tenant.subscription',
        EnsureSingleUserSession::class,
    ])->group(function (): void {

        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');






    /*
    |--------------------------------------------------------------------------
    | Página principal del tenant
    |--------------------------------------------------------------------------
    |
    | Si el usuario tiene una sesión iniciada, se envía al dashboard.
    | Si no tiene sesión, se envía al formulario de inicio de sesión.
    |
    | Debe permanecer fuera del grupo protegido.
    |
    */

    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('dashboard')
            : redirect()->route('login');
    })->name('tenant.home');

    /*
    |--------------------------------------------------------------------------
    | Rutas protegidas del tenant
    |--------------------------------------------------------------------------
    |
    | Todas las rutas de los módulos requieren:
    |
    | 1. Usuario autenticado.
    | 2. Sesión válida de Jetstream.
    | 3. Correo electrónico verificado.
    | 4. Que sea la única sesión activa de ese usuario.
    |
    */

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        EnsureSingleUserSession::class,
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
        )->middleware('can:marcas.create');

        /*
        |--------------------------------------------------------------------------
        | Resguardantes
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'resguardante',
            ResguardanteController::class
        )->middleware('can:resguardante.create');

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
        | Actualmente se conservan las rutas resource completas.
        |
        | Si el controlador solamente contiene index() y show(), puedes
        | agregar ->only(['index', 'show']) al final.
        |
        */

        Route::resource(
            'ubicacionfisica',
            UbicacionFisicaController::class
        )->middleware('can:ubicacionfisica.create');

        /*
        |--------------------------------------------------------------------------
        | Áreas de asignación
        |--------------------------------------------------------------------------
        |
        | El controlador utiliza únicamente:
        |
        | index()
        | store()
        |
        */
        Route::controller(AreaDeAsignacionController::class)
            ->prefix('areadeasignacion')
            ->name('areadeasignacion.')
            ->group(function (): void {

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
        |
        | Descomenta esta sección cuando vuelvas a activar el módulo.
        |
        */

        /*
        Route::resource(
            'usuarios',
            UserController::class
        )->middleware('can:puestos.create');
        */

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
        |
        | Descomenta esta sección cuando vuelvas a activar la exportación.
        |
        */

        /*
        Route::get('/export', [
            ExportController::class,
            'export',
        ])
            ->name('export')
            ->middleware('can:inventario.index');
        */
    });
});