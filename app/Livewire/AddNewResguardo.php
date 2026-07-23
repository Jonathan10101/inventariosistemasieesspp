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
        app(TenantDatabaseStorage::class)->assertCanWrite();

        $this->validate([
            'descripcion' => 'required',
            'marca_id' => 'required',
            'modelo' => 'required',
            'nserie' => 'required',
            'estado_uso_id' => 'required',
            'area_de_uso_id' => 'required',
            'ubicacion_fisicas_id' => 'required',
            'resguardante_id' => 'required',

            'imagen' => $this->imagenBase64
                ? 'sometimes'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // 8192 KB equivalen a 8 MB
            'resguardo_pdf' => 'nullable|file|mimes:pdf|max:8192',
        ]);

        $tempImagePath = null;
        $compressedPdfTempPath = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Convertir la fotografía Base64 a UploadedFile
            |--------------------------------------------------------------------------
            */

            if ($this->imagenBase64) {
                $fileData = Str::after($this->imagenBase64, ',');

                $fileName = 'resguardo_' . Str::random(10) . '.png';

                $tempImagePath = sys_get_temp_dir()
                    . DIRECTORY_SEPARATOR
                    . $fileName;

                file_put_contents(
                    $tempImagePath,
                    base64_decode($fileData)
                );

                $this->imagen = new UploadedFile(
                    $tempImagePath,
                    $fileName,
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

            $imagenEvidencia = null;

            if ($this->imagen) {
                $imagenEvidencia = app(ImageCompressor::class)->store(
                    file: $this->imagen,
                    directory: 'resguardos',
                    disk: 'public',
                    maxWidth: 1600,
                    maxHeight: 1600,
                    quality: 75
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Comprimir y guardar PDF
            |--------------------------------------------------------------------------
            */

            $pdfPath = null;

            if ($this->resguardo_pdf) {
                $originalPdfPath = $this->resguardo_pdf->getRealPath();

                $compressedPdfTempPath = sys_get_temp_dir()
                    . DIRECTORY_SEPARATOR
                    . 'resguardo_pdf_'
                    . Str::uuid()
                    . '.pdf';

                app(PdfCompressor::class)->compress(
                    inputPath: $originalPdfPath,
                    outputPath: $compressedPdfTempPath,
                    level: 'fuerte'
                );

                /*
                * Usar el PDF comprimido solamente si:
                * 1. Se generó correctamente.
                * 2. No está vacío.
                * 3. Pesa menos que el archivo original.
                */

                $pdfToStore = $originalPdfPath;

                if (
                    file_exists($compressedPdfTempPath)
                    && filesize($compressedPdfTempPath) > 0
                    && filesize($compressedPdfTempPath) < filesize($originalPdfPath)
                ) {
                    $pdfToStore = $compressedPdfTempPath;
                }

                $pdfName = 'resguardo_' . Str::uuid() . '.pdf';

                $pdfPath = 'resguardos/pdf/' . $pdfName;

                LaravelStorage::disk('public')->put(
                    $pdfPath,
                    file_get_contents($pdfToStore)
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Registrar la nueva asignación
            |--------------------------------------------------------------------------
            */

            $this->fecha_asignacion = now();

            $resguardo = Resguardo::findOrFail($this->resguardo_id);

            $ultimoHistorial = $resguardo
                ->historial()
                ->latest('id')
                ->first();

            if ($ultimoHistorial) {
                $ultimoHistorial->update([
                    'fecha_liberacion' => now(),
                ]);
            }

            HistorialResguardo::registrarAsignacion(
                $resguardo,
                $this->resguardante_id,
                $pdfPath,
                $imagenEvidencia,
                $this->estado_uso_id,
                $this->area_de_uso_id,
                $this->ubicacion_fisicas_id
            );

            $this->dispatch(
                'saveFromComponentAddNewHistorialResguardo'
            );

            $this->resetForm();
        } finally {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivos temporales
            |--------------------------------------------------------------------------
            */

            if (
                $tempImagePath
                && file_exists($tempImagePath)
            ) {
                @unlink($tempImagePath);
            }

            if (
                $compressedPdfTempPath
                && file_exists($compressedPdfTempPath)
            ) {
                @unlink($compressedPdfTempPath);
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
