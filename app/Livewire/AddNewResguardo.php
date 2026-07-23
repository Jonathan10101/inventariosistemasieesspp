<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marca;
use App\Models\EstadoUso;
use App\Models\AreaDeUso;
use App\Models\UbicacionFisica;
use App\Models\Resguardante;
use App\Models\Puesto;


use App\Models\Cursos;
use App\Models\Grupos;
use App\Models\Sedes;
use App\Models\Adscripciones;
use App\Models\Generaciones;
use App\Models\Escolaridad;
use App\Models\Municipio;
use App\Models\Estudiante;
use App\Livewire\Forms\StudentCreateForm;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Livewire\TemporaryUploadedFile;

use App\Models\Resguardo;
use App\Models\User;
use Carbon\Carbon;

use App\Models\HistorialResguardo;
use App\Services\TenantDatabaseStorage;
use App\Services\ImageCompressor;
use App\Services\PdfCompressor;
use Illuminate\Support\Facades\Storage as LaravelStorage;



class AddNewResguardo extends Component
{
    use WithFileUploads;
    public $marcas,$estadosdeuso,$areasdeasignacion,$ubicacionesifiscas,$resguardantes,$puestos;
   
    public $descripcion,$marca_id,$modelo,$nserie,$nresguardo,
    $estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id,$resguardante_id,$puesto_id,$resguardante;

    public $resguardo_id,$resguardo_pdf,$fecha_asignacion,$fecha_liberacion;

     public $showAdditionalFields = false;
    public $showModal = true; 
    public $imagen;  
    public $imagenBase64; // foto capturada desde JS
    public $usarCamara = true; // alternar entre cámara y PC
    public $tomadaDesdeCamara = true;
    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $resguardo;
    public $imagenSeleccionada = null;


    
    public function mount($data){
        $this->resguardo = Resguardo::find($data);

        
        if ($this->resguardo) {
            $this->imagenGuardada = $this->resguardo->imagen; // Ruta guardada
            $this->descripcion = $this->resguardo->descripcion;
            $this->modelo = $this->resguardo->modelo;
            $this->marca_id = $this->resguardo->marca_id;
            $this->nserie = $this->resguardo->nserie;
            $this->area_de_uso_id = $this->resguardo->area_de_uso_id;
            $this->ubicacion_fisicas_id = $this->resguardo->ubicacion_fisicas_id;
            $this->resguardante = $this->resguardo->resguardante;
            
            $this->resguardo_id = $this->resguardo->id;
            //$this->resguardante_id = $this->resguardante->id;
        }



        $this->ubicacionesifiscas  = UbicacionFisica::all();
        //$this->resguardantes = Resguardante::where('id', '!=',$this->resguardante_id)->get();
        if (auth()->user()->email == "subdesarrollopolicial@ieesspp.com") {
            $userIds = User::where("subdireccion", "LIKE", "SUBDIRECCIÓN DE DESARROLLO POLICIAL")
                        ->pluck('id');
            $this->resguardantes = Resguardante::whereIn('user_id', $userIds)->get();
        }else if (auth()->user()->email == "subcoordinacion@ieesspp.com") {
            $userIds = User::where("subdireccion", "LIKE", "SUBDIRECCIÓN DE COORDINACIÓN E INFRAESTRUCTURA INSTITUCIONAL")
                        ->pluck('id');
            $this->resguardantes = Resguardante::whereIn('user_id', $userIds)->get();
        }else{
            $this->resguardantes = Resguardante::all();
            //$this->resguardantes = Resguardante::where('id', '!=',$this->resguardante_id)->get();

        }

        //dd($x);
        $this->puestos = Puesto::all();
        $this->marcas = Marca::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->ubicacionesfisicas = UbicacionFisica::all();

    }

    public function updatedUbicacionFisicasId($value)
    {
        if (!$value) {
            $this->imagenSeleccionada = null;
            return;
        }

        $ubicacion = UbicacionFisica::find($value);
        $this->imagenSeleccionada = $ubicacion?->imagen;
    }
    
    public function resetImagenes()
    {
        $this->imagen = null;
        $this->imagenBase64 = null;
    }
    
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }


    public function updatedImagen()
    {
        // Aquí entra cada vez que se selecciona un archivo nuevo
        $this->imagenBase64 = null; // limpiar la otra opción
        $this->imagenFinal = $this->imagen; // asignar lo último cargado
    }


    public function save()
    {
        /*
        |--------------------------------------------------------------------------
        | Validar formulario
        |--------------------------------------------------------------------------
        */

        $this->validate([
            'descripcion' => [
                'required',
            ],

            'marca_id' => [
                'required',
            ],

            'modelo' => [
                'required',
            ],

            'nserie' => [
                'required',
            ],

            'estado_uso_id' => [
                'required',
            ],

            'area_de_uso_id' => [
                'required',
            ],

            'ubicacion_fisicas_id' => [
                'required',
            ],

            'resguardante_id' => [
                'required',
            ],

            /*
            |--------------------------------------------------------------------------
            | Imagen opcional
            |--------------------------------------------------------------------------
            |
            | Cuando existe imagenBase64, la imagen todavía no es un archivo de
            | Livewire, por eso no se aplica la regla image en ese momento.
            |
            */

            'imagen' => !empty($this->imagenBase64)
                ? [
                    'nullable',
                ]
                : [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:8192',
                ],

            /*
            |--------------------------------------------------------------------------
            | PDF opcional
            |--------------------------------------------------------------------------
            */

            'resguardo_pdf' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:8192',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Obtener los servicios existentes
        |--------------------------------------------------------------------------
        */

        $storageService = app(
            TenantDatabaseStorage::class
        );

        $imageCompressor = app(
            ImageCompressor::class
        );

        $pdfCompressor = app(
            PdfCompressor::class
        );

        /*
        |--------------------------------------------------------------------------
        | Comprobar almacenamiento
        |--------------------------------------------------------------------------
        */

        $storageService->assertCanWrite();

        /*
        |--------------------------------------------------------------------------
        | Variables de archivos
        |--------------------------------------------------------------------------
        */

        $tempImagePath = null;
        $compressedPdfTempPath = null;

        $imagenEvidencia = null;
        $pdfPath = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Convertir imagen Base64 a UploadedFile
            |--------------------------------------------------------------------------
            */

            if (!empty($this->imagenBase64)) {
                $partesImagen = explode(
                    ',',
                    $this->imagenBase64,
                    2
                );

                if (count($partesImagen) !== 2) {
                    throw ValidationException::withMessages([
                        'imagen' => 'La imagen capturada no tiene un formato válido.',
                    ]);
                }

                $contenidoImagen = base64_decode(
                    $partesImagen[1],
                    true
                );

                if ($contenidoImagen === false) {
                    throw ValidationException::withMessages([
                        'imagen' => 'No fue posible procesar la imagen capturada.',
                    ]);
                }

                $imageFileName = 'resguardo_'
                    . Str::random(16)
                    . '.png';

                $tempImagePath = sys_get_temp_dir()
                    . DIRECTORY_SEPARATOR
                    . $imageFileName;

                $bytesWritten = file_put_contents(
                    $tempImagePath,
                    $contenidoImagen
                );

                if ($bytesWritten === false) {
                    throw ValidationException::withMessages([
                        'imagen' => 'No fue posible guardar temporalmente la imagen.',
                    ]);
                }

                $this->imagen = new UploadedFile(
                    $tempImagePath,
                    $imageFileName,
                    'image/png',
                    null,
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Comprimir y guardar imagen
            |--------------------------------------------------------------------------
            */

            if ($this->imagen) {
                $imagenEvidencia = $imageCompressor->store(
                    file: $this->imagen,
                    directory: 'resguardos',
                    disk: 'public',
                    maxWidth: 1600,
                    maxHeight: 1600,
                    quality: 70
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Comprimir y guardar PDF
            |--------------------------------------------------------------------------
            */

            if ($this->resguardo_pdf) {
                if (
                    !$this->resguardo_pdf
                    instanceof TemporaryUploadedFile
                ) {
                    throw ValidationException::withMessages([
                        'resguardo_pdf' => 'No se recibió correctamente el archivo PDF.',
                    ]);
                }

                $pdfFileName = 'resguardo_'
                    . now()->format('Ymd_His')
                    . '_'
                    . Str::random(16)
                    . '.pdf';

                $pdfTempDirectory = storage_path(
                    'app/pdf-temp'
                );

                File::ensureDirectoryExists(
                    $pdfTempDirectory
                );

                $compressedPdfTempPath = $pdfTempDirectory
                    . DIRECTORY_SEPARATOR
                    . $pdfFileName;

                /*
                * Ruta temporal creada por Livewire.
                */
                $originalPdfPath = $this
                    ->resguardo_pdf
                    ->getRealPath();

                if (
                    !$originalPdfPath
                    || !File::exists($originalPdfPath)
                ) {
                    throw ValidationException::withMessages([
                        'resguardo_pdf' => 'No fue posible localizar el PDF temporal.',
                    ]);
                }

                /*
                * Utilizar el mismo compresor que funciona en el otro componente.
                */
                $pdfCompressor->compress(
                    inputPath: $originalPdfPath,
                    outputPath: $compressedPdfTempPath,
                    level: 'fuerte'
                );

                /*
                * Comparar el original con el comprimido y guardar el menor.
                */
                $originalPdfSize = File::size(
                    $originalPdfPath
                );

                $compressedPdfSize = File::size(
                    $compressedPdfTempPath
                );

                $pdfPathToSave = $compressedPdfSize < $originalPdfSize
                    ? $compressedPdfTempPath
                    : $originalPdfPath;

                $pdfPath = 'resguardos/pdf/'
                    . $pdfFileName;

                $pdfSaved = LaravelStorage::disk('public')->put(
                    $pdfPath,
                    File::get($pdfPathToSave)
                );

                if (!$pdfSaved) {
                    throw new \RuntimeException(
                        'No fue posible guardar el PDF del resguardo.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Actualizar el historial dentro de una transacción
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                $imagenEvidencia,
                $pdfPath
            ) {
                $resguardo = Resguardo::findOrFail(
                    $this->resguardo_id
                );

                /*
                * Buscar solamente el historial que sigue activo.
                */
                $ultimoHistorial = $resguardo
                    ->historial()
                    ->whereNull('fecha_liberacion')
                    ->latest('id')
                    ->first();

                if ($ultimoHistorial) {
                    $ultimoHistorial->update([
                        'fecha_liberacion' => now(),
                    ]);
                }

                $this->fecha_asignacion = now();

                HistorialResguardo::registrarAsignacion(
                    $resguardo,
                    $this->resguardante_id,
                    $pdfPath,
                    $imagenEvidencia,
                    $this->estado_uso_id,
                    $this->area_de_uso_id,
                    $this->ubicacion_fisicas_id
                );
            });

            /*
            |--------------------------------------------------------------------------
            | Terminar correctamente
            |--------------------------------------------------------------------------
            */

            $this->dispatch(
                'saveFromComponentAddNewHistorialResguardo'
            );

            $this->resetForm();
        } catch (\Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivos si falla la base de datos
            |--------------------------------------------------------------------------
            */

            if (
                $imagenEvidencia
                && LaravelStorage::disk('public')->exists(
                    $imagenEvidencia
                )
            ) {
                LaravelStorage::disk('public')->delete(
                    $imagenEvidencia
                );
            }

            if (
                $pdfPath
                && LaravelStorage::disk('public')->exists(
                    $pdfPath
                )
            ) {
                LaravelStorage::disk('public')->delete(
                    $pdfPath
                );
            }

            report($exception);

            if ($exception instanceof ValidationException) {
                throw $exception;
            }

            throw ValidationException::withMessages([
                'formulario' => 'No fue posible guardar la nueva asignación. Revisa la imagen y el PDF e inténtalo nuevamente.',
            ]);
        } finally {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivos temporales
            |--------------------------------------------------------------------------
            */

            if (
                $compressedPdfTempPath
                && File::exists($compressedPdfTempPath)
            ) {
                File::delete(
                    $compressedPdfTempPath
                );
            }

            if (
                $tempImagePath
                && File::exists($tempImagePath)
            ) {
                File::delete(
                    $tempImagePath
                );
            }
        }
    }

    public function resetForm()
    {
        $this->reset([
            'imagen','descripcion','marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id', 'resguardante_id', 'puesto_id','tomadaDesdeCamara','imagenBase64'
        ]);
    }


    public function render()
    {
        return view('livewire.add-new-resguardo');
    }
}
