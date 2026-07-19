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
use App\Services\PdfCompressor;


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
        |
        | Si cantidad viene vacía, nula o con cero, se utiliza como mínimo 1.
        |
        */

        $cantidad = max(
            1,
            (int) ($this->cantidad ?: 1)
        );

        $esCargaMultiple = $cantidad > 1;

        /*
        |--------------------------------------------------------------------------
        | Reglas para el número de serie
        |--------------------------------------------------------------------------
        |
        | El número de serie solamente debe ser único cuando:
        |
        | 1. Se está registrando un solo bien.
        | 2. El número de serie no está vacío.
        | 3. El número de serie no es N/A.
        |
        | En una carga múltiple todos los bienes se crearán con serie N/A.
        |
        */

        $nserieNormalizada = trim(
            (string) $this->nserie
        );

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
        |
        | El PDF puede pesar como máximo 8192 KB, es decir, 8 MB.
        |
        | La compresión se realiza después de la validación y antes de guardarlo
        | definitivamente en storage/app/public.
        |
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
                'file',
                'mimes:pdf',
                'max:8192',
            ],
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',

            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad mínima es 1.',
            'cantidad.max' => 'La cantidad máxima permitida es 500.',

            'marca_id.required' => 'Selecciona una marca.',
            'marca_id.exists' => 'La marca seleccionada no es válida.',

            'nserie.unique' => 'El número de serie ya está registrado.',

            'estado_uso_id.required' => 'Selecciona el estado de uso.',
            'area_de_uso_id.required' => 'Selecciona el área de asignación.',
            'ubicacion_fisicas_id.required' => 'Selecciona la ubicación física.',
            'resguardante_id.required' => 'Selecciona un resguardante.',

            'imagen.image' => 'La evidencia debe ser una imagen.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',

            'resguardo_pdf.required' => 'Debes seleccionar el PDF del resguardo.',
            'resguardo_pdf.file' => 'El archivo del resguardo no es válido.',
            'resguardo_pdf.mimes' => 'El archivo del resguardo debe ser PDF.',
            'resguardo_pdf.max' => 'El PDF no puede superar los 8 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Obtener servicios
        |--------------------------------------------------------------------------
        |
        | Aquí se crean correctamente las instancias de los servicios.
        |
        | No debe utilizarse:
        |
        | $storageService = TenantDatabaseStorage::class;
        |
        | Eso solamente devuelve el nombre de la clase como texto y no permite
        | ejecutar métodos como assertCanWrite().
        |
        */

        $storageService = app(
            TenantDatabaseStorage::class
        );

        $pdfCompressor = app(
            PdfCompressor::class
        );

        /*
        |--------------------------------------------------------------------------
        | Comprobar almacenamiento antes de comenzar
        |--------------------------------------------------------------------------
        */

        $storageService->assertCanWrite();

        /*
        |--------------------------------------------------------------------------
        | Variables para archivos
        |--------------------------------------------------------------------------
        |
        | Las rutas temporales se eliminan al terminar.
        |
        | Las rutas definitivas se eliminan automáticamente si ocurre un error
        | mientras se crean los registros.
        |
        */

        $tempImagePath = null;
        $compressedPdfTempPath = null;

        $pathImagen = null;
        $pathPdf = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Preparar imagen capturada desde la cámara
            |--------------------------------------------------------------------------
            |
            | La cámara envía una imagen en Base64. Primero se separa el encabezado
            | del contenido y después se crea un archivo temporal.
            |
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

                /*
                * Se genera un nombre único para evitar colisiones.
                */
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

                /*
                * Convertir el archivo temporal en un UploadedFile para que pueda
                * guardarse de la misma manera que una imagen subida normalmente.
                */
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
            | Guardar imagen una sola vez
            |--------------------------------------------------------------------------
            |
            | Cuando se registran varios bienes, todos utilizarán la misma ruta.
            | De esta manera no se almacenan hasta 500 copias de la misma imagen.
            |
            */

            if ($this->imagen) {
                $pathImagen = $this->imagen->store(
                    'resguardos',
                    'public'
                );

                if (!$pathImagen) {
                    throw new RuntimeException(
                        'No fue posible guardar la imagen del resguardo.'
                    );
                }
            }

            $imagenEvidencia = $pathImagen;

            /*
            |--------------------------------------------------------------------------
            | Comprimir y guardar PDF
            |--------------------------------------------------------------------------
            |
            | El PDF se procesa con Ghostscript antes de almacenarlo.
            |
            | El perfil "ebook" proporciona una reducción considerable de peso sin
            | afectar demasiado la calidad visual de textos, firmas y sellos.
            |
            */

            if (
                !$this->resguardo_pdf
                instanceof TemporaryUploadedFile
            ) {
                throw ValidationException::withMessages([
                    'resguardo_pdf' => 'No se recibió correctamente el archivo PDF.',
                ]);
            }

            /*
            * Nombre definitivo y único del PDF.
            */
            $pdfFileName = 'resguardo_'
                . now()->format('Ymd_His')
                . '_'
                . Str::random(16)
                . '.pdf';

            /*
            * Directorio utilizado solamente para generar el PDF comprimido.
            */
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
            * Ruta temporal original creada por Livewire.
            */
            $originalPdfPath = $this->resguardo_pdf
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
            * Comprimir el documento.
            *
            * Puedes cambiar "ebook" por "printer" si deseas conservar todavía
            * más calidad, aunque la reducción de tamaño será menor.
            */
            $pdfCompressor->compress(
                inputPath: $originalPdfPath,
                outputPath: $compressedPdfTempPath,
                quality: 'ebook'
            );

            /*
            |--------------------------------------------------------------------------
            | Comparar tamaños
            |--------------------------------------------------------------------------
            |
            | Algunos PDFs ya vienen optimizados. En esos casos Ghostscript podría
            | generar un archivo ligeramente más grande.
            |
            | Por eso se compara el archivo original contra el comprimido y se
            | guarda automáticamente el más pequeño.
            |
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

            /*
            * Ruta relativa que se guardará en la base de datos.
            */
            $pathPdf = 'resguardos/pdf/'
                . $pdfFileName;

            /*
            * Guardar el archivo seleccionado en el disco public.
            */
            $pdfSaved = Storage::disk('public')->put(
                $pathPdf,
                File::get($pdfPathToSave)
            );

            if (!$pdfSaved) {
                throw new RuntimeException(
                    'No fue posible guardar el PDF del resguardo.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Normalizar modelo y número de serie
            |--------------------------------------------------------------------------
            */

            $modelo = trim(
                (string) $this->modelo
            );

            if ($modelo === '') {
                $modelo = 'N/A';
            }

            if ($nserieNormalizada === '') {
                $nserieNormalizada = 'N/A';
            }

            /*
            |--------------------------------------------------------------------------
            | Obtener puesto del resguardante
            |--------------------------------------------------------------------------
            */

            $resguardante = Resguardante::findOrFail(
                $this->resguardante_id
            );

            /*
            * Se utiliza el puesto 1 como respaldo si el resguardante no tiene
            * puesto asignado.
            */
            $puestoId = $resguardante->puesto_id ?: 1;

            /*
            |--------------------------------------------------------------------------
            | Crear registros dentro de una transacción
            |--------------------------------------------------------------------------
            |
            | Si ocurre un error al crear cualquiera de los registros, Laravel
            | revierte todas las inserciones realizadas durante esta operación.
            |
            */

            DB::transaction(
                function () use (
                    $storageService,
                    $cantidad,
                    $esCargaMultiple,
                    $nserieNormalizada,
                    $modelo,
                    $puestoId,
                    $pathImagen,
                    $pathPdf,
                    $imagenEvidencia
                ) {
                    $totalRegistros = $esCargaMultiple
                        ? $cantidad
                        : 1;

                    for (
                        $indice = 0;
                        $indice < $totalRegistros;
                        $indice++
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | Revisar almacenamiento cada 10 registros
                        |--------------------------------------------------------------------------
                        |
                        | Una carga de hasta 500 registros puede aumentar el tamaño
                        | de la base durante el proceso.
                        |
                        */

                        if (
                            $indice > 0
                            && $indice % 10 === 0
                        ) {
                            $storageService->assertCanWrite();
                        }

                        /*
                        * En una carga múltiple cada bien se registra por separado,
                        * con cantidad 1 y número de serie N/A.
                        */
                        $cantidadRegistro = $esCargaMultiple
                            ? 1
                            : $cantidad;

                        $numeroSerieRegistro = $esCargaMultiple
                            ? 'N/A'
                            : $nserieNormalizada;

                        /*
                        |--------------------------------------------------------------------------
                        | Crear resguardo
                        |--------------------------------------------------------------------------
                        */

                        $resguardo = Resguardo::create([
                            'descripcion' => trim(
                                (string) $this->descripcion
                            ),

                            'cantidad' => $cantidadRegistro,

                            'marca_id' => $this->marca_id,

                            'modelo' => $modelo,

                            'nserie' => $numeroSerieRegistro,

                            'resguardante_id' => $this->resguardante_id,

                            'puesto_id' => $puestoId,

                            'imagen' => $pathImagen,

                            'estado_actual' => 'asignado',
                        ]);

                        /*
                        * El número de resguardo utiliza el ID generado.
                        */
                        $resguardo->update([
                            'nresguardo' => $resguardo->id,
                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | Registrar historial inicial
                        |--------------------------------------------------------------------------
                        |
                        | Todos los bienes de la carga compartirán el mismo PDF y la
                        | misma evidencia para no duplicar archivos.
                        |
                        */

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
                    |--------------------------------------------------------------------------
                    | Revisión final de almacenamiento
                    |--------------------------------------------------------------------------
                    |
                    | Esta comprobación permanece dentro de la transacción. Si el
                    | límite se supera, se lanza una excepción y todos los registros
                    | creados durante esta operación se revierten.
                    |
                    */

                    $storageService->assertCanWrite();
                },

                /*
                * Laravel intentará repetir la transacción hasta tres veces cuando
                * ocurra un bloqueo temporal de base de datos.
                */
                3
            );

            /*
            |--------------------------------------------------------------------------
            | Finalizar correctamente
            |--------------------------------------------------------------------------
            */

            $this->resetForm();

            $this->dispatch('resguardoCreado');
        } catch (\Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivos definitivos si ocurre un error
            |--------------------------------------------------------------------------
            |
            | Los archivos se guardan antes de la transacción. Si algo falla en la
            | base de datos, se eliminan para no dejar archivos huérfanos.
            |
            */

            if (
                $pathImagen
                && Storage::disk('public')->exists($pathImagen)
            ) {
                Storage::disk('public')->delete(
                    $pathImagen
                );
            }

            if (
                $pathPdf
                && Storage::disk('public')->exists($pathPdf)
            ) {
                Storage::disk('public')->delete(
                    $pathPdf
                );
            }

            /*
            * Registrar el error real en storage/logs/laravel.log.
            */
            report($exception);

            /*
            * Conservar los mensajes de validación específicos.
            */
            if ($exception instanceof ValidationException) {
                throw $exception;
            }

            /*
            * Mostrar un mensaje controlado en el formulario y evitar que aparezca
            * una pantalla completa de error.
            */
            throw ValidationException::withMessages([
                'formulario' => 'No fue posible guardar el resguardo. Revisa el archivo PDF e inténtalo nuevamente.',
            ]);
        } finally {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivos temporales
            |--------------------------------------------------------------------------
            |
            | Este bloque se ejecuta tanto si el proceso termina correctamente como
            | si ocurre una excepción.
            |
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
