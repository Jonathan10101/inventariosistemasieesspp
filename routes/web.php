<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\EstadoDeUsoController;
use App\Http\Controllers\ResguardanteController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\UbicacionFisicaController;


use App\Http\Controllers\CocinaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Cocina\RequisicionCocinaController;
use App\Http\Controllers\Cocina\AlmacenCocinaController;
use App\Http\Controllers\Papeleria\RequisicionPapeleriaController;
use App\Http\Controllers\Papeleria\AlmacenPapeleriaController;
use App\Http\Controllers\Alumnos\AlumnosController;
use App\Http\Controllers\Instructores\InstructoresController;
//use App\Http\Controllers\Instructores\InstructoresController;
use App\Http\Controllers\Inscripciones\InscripcionesController;
use App\Http\Controllers\Profesores\ProfesoresController;
use App\Http\Controllers\Administrativos\AdministrativosController;
use App\Http\Controllers\Cursos\CursosController;
use App\Http\Controllers\Grupos\GruposController;
use App\Http\Controllers\Informativos\InformativosCalendarioController;
use App\Http\Controllers\Informativos\InformativosNoticiasController;
use App\Http\Controllers\Informativos\InformativosBibliotecaController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Calendario\CalendarioController;
use App\Http\Controllers\Noticias\NoticiasController;
use App\Http\Controllers\Biblioteca\BibliotecaController;
use App\Livewire\UpdateAssigmentCourse;





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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::apiResource('dashboard', DashboardController::class);
});
/*
});
Route::get('/editar-curso', UpdateAssigmentCourse::class)->name('editar.curso');
Route::get('/certificate/verify', [UpdateAssigmentCourse::class, 'verify'])->name('certificate.verify');
Route::get('qrcode',function(){
return QrCode::size(300)->generate("https://diarioprogramador.com/limpiando-la-cache-de-laravel/");
});
*/






Route::apiResource("inventario",AlumnosController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource("marcas",MarcaController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::apiResource("modelo",ModeloController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::apiResource("estadouso",EstadoDeUsoController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource('resguardante', ResguardanteController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::resource('puestos', PuestoController::class)->middleware(['auth:sanctum','can:alumnos.index']);

Route::apiResource("ubicacionfisica",UbicacionFisicaController::class)->middleware(['auth:sanctum','can:alumnos.index']);

 





//Route::apiResource("instructores",InstructoresController::class)->middleware(['auth:sanctum','can:alumnos.index']);
Route::apiResource("cursos",CursosController::class)->middleware(['auth:sanctum','can:cursos.index']);
//Route::apiResource("municipios",MunicipioController::class)->middleware(['auth:sanctum','can:cursos.index']);
Route::apiResource("inscripciones",InscripcionesController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
























/*
Route::apiResource("profesores",ProfesoresController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("administrativos",AdministrativosController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("cursos",CursosController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("grupos",GruposController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("informativoscalendario",InformativosCalendarioController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("informativosnoticias",InformativosNoticiasController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("informativosbiblioteca",InformativosBibliotecaController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("chat",ChatController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("calendario",CalendarioController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("noticias",NoticiasController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
Route::apiResource("biblioteca",BibliotecaController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
*/

//Route::apiResource("cocina/requisiciones",RequisicionCocinaController::class)->middleware(['auth:sanctum','can:requisicionesCocina.index']);
//Route::apiResource("cocina/almacen",AlmacenCocinaController::class)->middleware(['auth:sanctum','can:almacenCocina.index']);
//Route::apiResource("papeleria/requisiciones",RequisicionPapeleriaController::class)->middleware(['auth:sanctum','can:requisicionesPapeleria.index']);
//Route::apiResource("papeleria/almacen",AlmacenPapeleriaController::class)->middleware(['auth:sanctum','can:almacenPapeleria.index']);






























/*
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
*/
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
