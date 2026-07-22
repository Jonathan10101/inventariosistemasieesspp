<?php

namespace App\Livewire;

use App\Imports\UbicacionesFisicasImport;
use App\Models\UbicacionFisica;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;
use App\Services\ImageCompressor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage as LaravelStorage;


class UbicacionfisicaForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | Propiedades generales
    |--------------------------------------------------------------------------
    */

    public string $tituloModalPrincipal = 'REGISTRAR';

    public bool $showModal = false;

    public bool $showImportModal = false;

    public string $accionPrincipal = '';

    public string $search = '';

    public int $perPage = 3;

    public $data_external_component = null;

    public $ubicacion_fisica = null;

    public bool $isEditing = false;

    /*
    |--------------------------------------------------------------------------
    | Propiedades para importar
    |--------------------------------------------------------------------------
    */

    public $archivoUbicaciones = null;

    public int $ubicacionesImportadas = 0;

    public int $ubicacionesDuplicadas = 0;

    public array $erroresImportacion = [];

    /*
    |--------------------------------------------------------------------------
    | Búsqueda
    |--------------------------------------------------------------------------
    */

    public function clearSearch(): void
    {
        $this->search = '';

        $this->resetPage();
    }

    public function searchUbicacionesFisicas(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Modal para registrar o editar
    |--------------------------------------------------------------------------
    */

    public function showModalNewUbicacionFisica(): void
    {
        $this->resetForm();

        $this->tituloModalPrincipal = 'REGISTRAR';
        $this->accionPrincipal = '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->resetForm();

        $this->showModal = false;

        $this->dispatch('refresh-page');
    }

    public function resetForm(): void
    {
        $this->reset([
            'ubicacion_fisica',
            'data_external_component',
            'accionPrincipal',
            'isEditing',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Modal para importar
    |--------------------------------------------------------------------------
    */

    public function showModalImportUbicaciones(): void
    {
        $this->resetValidation();

        $this->archivoUbicaciones = null;
        $this->ubicacionesImportadas = 0;
        $this->ubicacionesDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->showImportModal = true;

        $this->dispatch('limpiar-archivo-ubicaciones');
    }

    public function closeImportModal(): void
    {
        $this->showImportModal = false;

        $this->reset([
            'archivoUbicaciones',
            'ubicacionesImportadas',
            'ubicacionesDuplicadas',
            'erroresImportacion',
        ]);

        $this->resetValidation('archivoUbicaciones');

        $this->dispatch('limpiar-archivo-ubicaciones');
    }

    /*
    |--------------------------------------------------------------------------
    | Importar ubicaciones físicas
    |--------------------------------------------------------------------------
    */

    public function importarUbicacionesFisicas(): void
    {
        $this->resetValidation();

        $this->ubicacionesImportadas = 0;
        $this->ubicacionesDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->validate(
            [
                'archivoUbicaciones' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'archivoUbicaciones.required' =>
                    'Selecciona el archivo que deseas importar.',

                'archivoUbicaciones.file' =>
                    'El archivo seleccionado no es válido.',

                'archivoUbicaciones.mimes' =>
                    'Solamente se permiten archivos XLSX, XLS o CSV.',

                'archivoUbicaciones.max' =>
                    'El archivo no puede superar los 10 MB.',
            ]
        );

        $rutaGuardada = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Obtener extensión original
            |--------------------------------------------------------------------------
            */

            $extension = strtolower(
                $this->archivoUbicaciones
                    ->getClientOriginalExtension()
            );

            if (!in_array($extension, ['xlsx', 'xls', 'csv'], true)) {
                throw new \RuntimeException(
                    'El formato del archivo no es compatible.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Crear nombre temporal
            |--------------------------------------------------------------------------
            */

            $nombreTemporal =
                'ubicaciones-'
                . date('YmdHis')
                . '-'
                . bin2hex(random_bytes(5))
                . '.'
                . $extension;

            /*
            |--------------------------------------------------------------------------
            | Guardar archivo temporal
            |--------------------------------------------------------------------------
            */

            $rutaGuardada = $this->archivoUbicaciones->storeAs(
                'imports',
                $nombreTemporal,
                'local'
            );

            if (!$rutaGuardada) {
                throw new \RuntimeException(
                    'No fue posible guardar temporalmente el archivo.'
                );
            }

            if (
                !\Illuminate\Support\Facades\Storage::disk('local')
                    ->exists($rutaGuardada)
            ) {
                throw new \RuntimeException(
                    'El archivo temporal no fue encontrado.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Ejecutar importación
            |--------------------------------------------------------------------------
            */

            $importacion = new UbicacionesFisicasImport();

            \Maatwebsite\Excel\Facades\Excel::import(
                $importacion,
                $rutaGuardada,
                'local'
            );

            /*
            |--------------------------------------------------------------------------
            | Recuperar resultados
            |--------------------------------------------------------------------------
            */

            $this->ubicacionesImportadas =
                $importacion->getUbicacionesImportadas();

            $this->ubicacionesDuplicadas =
                $importacion->getUbicacionesDuplicadas();

            $this->erroresImportacion =
                $importacion->getErrores();

            /*
            |--------------------------------------------------------------------------
            | Actualizar listado
            |--------------------------------------------------------------------------
            */

            $this->search = '';

            $this->resetPage();

            $this->reset('archivoUbicaciones');

            $this->dispatch('limpiar-archivo-ubicaciones');

            /*
            |--------------------------------------------------------------------------
            | Importación con errores parciales
            |--------------------------------------------------------------------------
            */

            if (count($this->erroresImportacion) > 0) {
                $this->dispatch(
                    'ubicaciones-importacion-advertencia',
                    mensaje:
                        "Se registraron {$this->ubicacionesImportadas} "
                        . "ubicaciones, se ignoraron "
                        . "{$this->ubicacionesDuplicadas} duplicadas "
                        . 'y algunas filas contenían errores.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Importación correcta
            |--------------------------------------------------------------------------
            */

            $this->showImportModal = false;

            $this->dispatch(
                'ubicaciones-importadas',
                mensaje:
                    "Se registraron {$this->ubicacionesImportadas} "
                    . "ubicaciones nuevas y se ignoraron "
                    . "{$this->ubicacionesDuplicadas} duplicadas."
            );
        } catch (Throwable $e) {
            report($e);

            $this->addError(
                'archivoUbicaciones',
                'No se pudo importar: ' . $e->getMessage()
            );
        } finally {
            /*
            |--------------------------------------------------------------------------
            | Eliminar archivo temporal
            |--------------------------------------------------------------------------
            */

            if (
                $rutaGuardada
                && \Illuminate\Support\Facades\Storage::disk('local')
                    ->exists($rutaGuardada)
            ) {
                \Illuminate\Support\Facades\Storage::disk('local')
                    ->delete($rutaGuardada);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Registrar ubicación
    |--------------------------------------------------------------------------
    */

    #[On('saveFromComponentNewUbicacionFisica')]
    public function saveNewUbicacionFisica(array $data): void
    {
        $descripcion = mb_strtoupper(
            trim((string) ($data['descripcion'] ?? '')),
            'UTF-8'
        );

        $rutaImagen = null;

        /*
        |--------------------------------------------------------------------------
        | Comprimir imagen
        |--------------------------------------------------------------------------
        |
        | Solo se procesa cuando realmente llega un archivo temporal de Livewire.
        |
        */
        if (
            isset($data['imagen'])
            && $data['imagen'] instanceof TemporaryUploadedFile
        ) {
            $imageCompressor = app(ImageCompressor::class);

            $rutaImagen = $imageCompressor->store(
                file: $data['imagen'],
                directory: 'ubicaciones',
                disk: 'public',
                maxWidth: 1600,
                maxHeight: 1600,
                quality: 75
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Registrar ubicación
        |--------------------------------------------------------------------------
        */
        UbicacionFisica::create([
            'descripcion' => $descripcion,
            'imagen' => $rutaImagen,
        ]);

        $this->showModal = false;

        $this->dispatch('alumno-created', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar ubicación
    |--------------------------------------------------------------------------
    */

    #[On('saveUpdateUbicacionFisicaFromAnotherComponent')]
    public function saveUpdateUbicacionFisica(array $data): void
    {
        $ubicacion = UbicacionFisica::findOrFail($data['id']);

        $imagenAnterior = $ubicacion->imagen;
        $nuevaRutaImagen = null;

        $datosActualizar = [
            'descripcion' => mb_strtoupper(
                trim((string) ($data['descripcion'] ?? '')),
                'UTF-8'
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | Comprimir nueva imagen
        |--------------------------------------------------------------------------
        |
        | Solo reemplaza la imagen cuando realmente llega un archivo nuevo.
        | Si no llega una imagen, conserva la anterior.
        |
        */
        if (
            isset($data['imagen'])
            && $data['imagen'] instanceof TemporaryUploadedFile
        ) {
            $imageCompressor = app(ImageCompressor::class);

            $nuevaRutaImagen = $imageCompressor->store(
                file: $data['imagen'],
                directory: 'ubicaciones',
                disk: 'public',
                maxWidth: 1600,
                maxHeight: 1600,
                quality: 75
            );

            $datosActualizar['imagen'] = $nuevaRutaImagen;
        }

        /*
        |--------------------------------------------------------------------------
        | Actualizar primero la base de datos
        |--------------------------------------------------------------------------
        */
        $ubicacion->update($datosActualizar);

        /*
        |--------------------------------------------------------------------------
        | Eliminar imagen anterior
        |--------------------------------------------------------------------------
        |
        | Se elimina únicamente después de guardar correctamente la nueva ruta.
        |
        */
        if (
            $nuevaRutaImagen !== null
            && !empty($imagenAnterior)
            && $imagenAnterior !== $nuevaRutaImagen
            && LaravelStorage::disk('public')->exists($imagenAnterior)
        ) {
            LaravelStorage::disk('public')->delete($imagenAnterior);
        }

        $this->dispatch('alumno-updated', 1);

        $this->showModal = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Acciones
    |--------------------------------------------------------------------------
    */

    public function cambiarAccion(
        $nuevaAccion,
        $id
    ): void {
        $this->accionPrincipal = $nuevaAccion;

        $this->changeModalTitle(
            $this->accionPrincipal
        );

        $this->accionEjecutada(
            $this->accionPrincipal,
            $id
        );
    }

    public function changeModalTitle($accion): void
    {
        switch ($accion) {
            case 'editar':
                $this->tituloModalPrincipal = 'Editar';
                break;

            default:
                $this->tituloModalPrincipal = 'Registrar';
                break;
        }
    }

    public function accionEjecutada(
        $accion,
        $id
    ): void {
        switch ($accion) {
            case 'editar':
                $this->edit($id);
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Editar ubicación
    |--------------------------------------------------------------------------
    */

    public function edit($id): void
    {
        /*
         * Antes usabas $this->marca, pero esa propiedad
         * no existe en este componente.
         */
        $this->ubicacion_fisica =
            UbicacionFisica::findOrFail($id);

        $this->showModal = true;

        $this->isEditing = true;

        $this->data_external_component =
            $this->ubicacion_fisica->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Descargar etiqueta
    |--------------------------------------------------------------------------
    */

    public function downloadEtiqueta($id)
    {
        $codigo = str_pad(
            $id,
            8,
            '0',
            STR_PAD_LEFT
        );

        return redirect()->route(
            'etiquetas2.show',
            $codigo
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Vista
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = UbicacionFisica::query();

        if ($this->search !== '') {
            $busqueda = trim($this->search);

            $busquedaSinCeros = ltrim(
                $busqueda,
                '0'
            );

            $query->where(
                function ($q) use (
                    $busqueda,
                    $busquedaSinCeros
                ) {
                    $q->where(
                        'descripcion',
                        'like',
                        "%{$busqueda}%"
                    );

                    if (
                        $busquedaSinCeros !== ''
                        && ctype_digit($busquedaSinCeros)
                    ) {
                        $q->orWhere(
                            'id',
                            (int) $busquedaSinCeros
                        );
                    }
                }
            );
        }

        return view(
            'livewire.ubicacionfisica-form',
            [
                'ubicacionesfisicas' => $query
                    ->orderBy('descripcion')
                    ->paginate($this->perPage),
            ]
        );
    }
}