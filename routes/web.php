<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\EstadoDeUsoController;
use App\Http\Controllers\ResguardanteController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\UbicacionFisicaController;
use App\Http\Controllers\AreaDeAsignacionController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\DashboardController;

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
    return view('admin.index');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {Route::apiResource('dashboard', DashboardController::class);});
Route::resource("inventario",InventarioController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("marcas",MarcaController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("modelo",ModeloController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("estadouso",EstadoDeUsoController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource('resguardante', ResguardanteController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource('puestos', PuestoController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("ubicacionfisica",UbicacionFisicaController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("areadeasignacion",AreaDeAsignacionController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("cursos",CursosController::class)->middleware(['auth:sanctum','can:cursos.index']);
Route::resource("inscripciones",InscripcionesController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::get('/etiqueta/{codigo}', [EtiquetaController::class, 'show'])->name('etiquetas.show');
