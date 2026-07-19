<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\{
    Marca,
    EstadoUso,
    AreaDeUso,
    UbicacionFisica,
    Resguardante,
    Puesto,
    Resguardo,
    HistorialResguardo,
    User
};
use App\Services\TenantDatabaseStorage;

class CreateNewResguardo extends Component
{
    use WithFileUploads;

    /* =================== VARIABLES =================== */
    public $marcas, $estadosdeuso, $areasdeasignacion, $ubicacionesifiscas, $resguardantes, $puestos;

    public $descripcion, $cantidad, $marca_id, $modelo, $nserie, $nresguardo,
           $estado_uso_id, $area_de_uso_id, $ubicacion_fisicas_id,
           $resguardante_id, $puesto_id;

    //public string $institucion = 'IEESSPP';

    public $imagen;
    public $imagenBase64;
    public $usarCamara = true;
    public $tomadaDesdeCamara = true;
    public $resguardo_pdf;
    public $showAdditionalFields = false;

    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $imagenSeleccionada = null;

    public $mostrarBotonLoading = false;

    /* =================== CICLO DE VIDA =================== */
    public function mount()
    {
        $this->marcas = Marca::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->ubicacionesifiscas = UbicacionFisica::all();
        $this->puestos = Puesto::all();

        /*
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
        }
        */
        $this->resguardantes = Resguardante::all();
    }

    /* =================== MÉTODOS =================== */

    public function resetImagenes()
    {
        $this->imagen = null;
        $this->imagenBase64 = null;
    }

    public function updatedResguardanteId($value)
    {
        if ($value) {
            $resguardante = Resguardante::find($value);
            $this->puesto_id = $resguardante->puesto_id ?? null;
        } else {
            $this->puesto_id = null;
        }
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
    
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }

    public function updatedImagen()
    {
        $this->imagenBase64 = null; // limpiar si se sube desde PC
    }

    /* =================== GUARDADO PRINCIPAL =================== */
    public function save()
    {
        /*
        |--------------------------------------------------------------------------
        | Normalizar la cantidad
        |--------------------------------------------------------------------------
        */

        $cantidad = max(1, (int) ($this->cantidad ?: 1));
        $esCargaMultiple = $cantidad > 1;

        /*
        |--------------------------------------------------------------------------
        | Reglas para el número de serie
        |--------------------------------------------------------------------------
        |
        | Solo validamos que el número de serie sea único cuando se registra
        | un solo bien y el número no está vacío ni contiene N/A.
        |
        */

        $nserieNormalizada = trim((string) $this->nserie);

        $reglasNumeroSerie = [
            'nullable',
            'string',
            'max:255',
        ];

        if (
            !$esCargaMultiple
            && $nserieNormalizada !== ''
            && strtoupper($nserieNormalizada) !== 'N/A'
        ) {
            $reglasNumeroSerie[] = Rule::unique(
                'resguardos',
                'nserie'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validar formulario
        |--------------------------------------------------------------------------
        */

        $this->validate([
            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],

            'cantidad' => [
                'nullable',
                'integer',
                'min:1',
                'max:500',
            ],

            'marca_id' => [
                'required',
                'exists:marcas,id',
            ],

            'modelo' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nserie' => $reglasNumeroSerie,

            'estado_uso_id' => [
                'required',
                'exists:estado_uso,id',
            ],

            'area_de_uso_id' => [
                'required',
                'exists:area_de_uso,id',
            ],

            'ubicacion_fisicas_id' => [
                'required',
                'exists:ubicacion_fisicas,id',
            ],

            'resguardante_id' => [
                'required',
                'exists:resguardantes,id',
            ],

            'imagen' => [
                'nullable',
                'image',
                'max:4096',
            ],

            'resguardo_pdf' => [
                'required',
                'mimes:pdf',
                'max:8192',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Servicio de almacenamiento
        |--------------------------------------------------------------------------
        |
        | Se crea una sola vez y se reutiliza durante toda la carga.
        |
        */

        $storageService = app(TenantDatabaseStorage::class);

        /*
        * Impide comenzar si la base ya alcanzó el límite.
        */
        $storageService->assertCanWrite();

        /*
        |--------------------------------------------------------------------------
        | Preparar la imagen tomada desde cámara
        |--------------------------------------------------------------------------
        */

        if ($this->imagenBase64) {
            $partesImagen = explode(
                ',',
                $this->imagenBase64,
                2
            );

            if (count($partesImagen) !== 2) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'imagen' => 'La imagen capturada no tiene un formato válido.',
                ]);
            }

            $contenidoImagen = base64_decode(
                $partesImagen[1],
                true
            );

            if ($contenidoImagen === false) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'imagen' => 'No fue posible procesar la imagen capturada.',
                ]);
            }

            $fileName = 'resguardo_' . Str::random(16) . '.png';

            $tempPath = sys_get_temp_dir()
                . DIRECTORY_SEPARATOR
                . $fileName;

            file_put_contents(
                $tempPath,
                $contenidoImagen
            );

            $this->imagen = new UploadedFile(
                $tempPath,
                $fileName,
                'image/png',
                null,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Guardar archivos una sola vez
        |--------------------------------------------------------------------------
        |
        | Todos los registros creados en esta operación utilizarán las mismas
        | rutas. Esto evita guardar 500 copias idénticas de la imagen y el PDF.
        |
        */

        $pathImagen = null;

        if ($this->imagen) {
            $pathImagen = $this->imagen->store(
                'resguardos',
                'public'
            );
        }

        $imagenEvidencia = $pathImagen;

        $pathPdf = null;

        if ($this->resguardo_pdf instanceof TemporaryUploadedFile) {
            $pathPdf = $this->resguardo_pdf->store(
                'resguardos/pdf',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Normalizar modelo y número de serie
        |--------------------------------------------------------------------------
        */

        $modelo = trim((string) $this->modelo);

        if ($modelo === '') {
            $modelo = 'N/A';
        }

        if ($nserieNormalizada === '') {
            $nserieNormalizada = 'N/A';
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener el puesto del resguardante
        |--------------------------------------------------------------------------
        */

        $resguardante = Resguardante::findOrFail(
            $this->resguardante_id
        );

        $puestoId = $resguardante->puesto_id ?: 1;

        /*
        |--------------------------------------------------------------------------
        | Crear los resguardos
        |--------------------------------------------------------------------------
        */

        $totalRegistros = $esCargaMultiple
            ? $cantidad
            : 1;

        for ($indice = 0; $indice < $totalRegistros; $indice++) {

            /*
            * Verifica nuevamente el almacenamiento cada 10 registros.
            *
            * No se hace únicamente al comienzo porque una carga de 500
            * registros podría superar el límite durante el proceso.
            */
            if ($indice > 0 && $indice % 10 === 0) {
                $storageService->assertCanWrite();
            }

            /*
            * Cuando la cantidad es mayor a uno, cada bien se registra
            * individualmente con cantidad 1 y número de serie N/A.
            */
            $cantidadRegistro = $esCargaMultiple
                ? 1
                : $cantidad;

            $numeroSerieRegistro = $esCargaMultiple
                ? 'N/A'
                : $nserieNormalizada;

            $resguardo = Resguardo::create([
                'descripcion' => $this->descripcion,
                'cantidad' => $cantidadRegistro,
                'marca_id' => $this->marca_id,
                'modelo' => $modelo,
                'nserie' => $numeroSerieRegistro,
                'resguardante_id' => $this->resguardante_id,
                'puesto_id' => $puestoId,
                'imagen' => $pathImagen,
                'estado_actual' => 'asignado',
            ]);

            $resguardo->update([
                'nresguardo' => $resguardo->id,
            ]);

            HistorialResguardo::registrarAsignacion(
                $resguardo,
                $this->resguardante_id,
                $pathPdf,
                $imagenEvidencia,
                $this->estado_uso_id,
                $this->area_de_uso_id,
                $this->ubicacion_fisicas_id
            );
        }

        /*
        * Revisión final después de terminar la carga.
        */
        $storageService->assertCanWrite();

        /*
        |--------------------------------------------------------------------------
        | Finalizar
        |--------------------------------------------------------------------------
        */

        $this->resetForm();

        $this->dispatch('resguardoCreado');
    }

    /* =================== RESETEAR FORMULARIO =================== */
    public function resetForm()
    {
        $this->reset([
            'descripcion', 'cantidad', 'marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id',
            'resguardante_id', 'puesto_id', 'imagen', 'imagenBase64',
            'resguardo_pdf', 'tomadaDesdeCamara'
        ]);
        $this->mostrarBotonLoading = false;
    }

    /* =================== VISTA =================== */
    public function render()
    {
        return view('livewire.create-new-resguardo', [
            'mostrarBotonLoading' => $this->mostrarBotonLoading,
        ]);    
    }
}
