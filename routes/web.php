<?php

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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    if (!Auth::check()) {
        return Redirect::route('login');  // Redirige si no está logueado
    }
    //return view('admin.index');
    return view('dashboard');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {Route::apiResource('dashboard', DashboardController::class);});
Route::resource("inventario",InventarioController::class)->middleware(['auth:sanctum','can:inventario.index']);
Route::resource("marcas",MarcaController::class)->middleware(['auth:sanctum','can:marcas.index']);
Route::resource('resguardante', ResguardanteController::class)->middleware(['auth:sanctum','can:resguardante.index']);
Route::resource('puestos', PuestoController::class)->middleware(['auth:sanctum','can:puestos.create']);
Route::resource("ubicacionfisica",UbicacionFisicaController::class)->middleware(['auth:sanctum','can:ubicacionfisica.index']);
Route::resource("areadeasignacion",AreaDeAsignacionController::class)->middleware(['auth:sanctum','can:areadeasignacion.create']);
Route::resource('usuarios', UserController::class)->middleware(['auth:sanctum','can:puestos.create']);
Route::resource('roles', RolController::class)->middleware(['auth:sanctum','can:puestos.create']);

Route::get('/etiqueta/{codigo}', [EtiquetaController::class, 'show'])->name('etiquetas.show')->middleware(['auth:sanctum','can:inventario.index']);
Route::get('/etiqueta2/{codigo}', [Etiqueta2Controller::class, 'show'])->name('etiquetas2.show')->middleware(['auth:sanctum','can:inventario.index']);
Route::get('/export',[ExportController::class,'export'])->name('export');


Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});