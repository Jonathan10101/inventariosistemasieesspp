<?php

namespace App\Livewire;

use App\Imports\AreasDeAsignacionImport;
use App\Models\AreaDeUso;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;

class AreaDeAsignacionForm extends Component
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

    public int $perPage = 5;

    public $data_external_component = null;

    public $areadeasignacion = null;

    public bool $isEditing = false;

    /*
    |--------------------------------------------------------------------------
    | Propiedades de importación
    |--------------------------------------------------------------------------
    */

    public $archivoAreas = null;

    public int $areasImportadas = 0;

    public int $areasDuplicadas = 0;

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

    public function searchAreasDeAsignacion(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Modal registrar y editar
    |--------------------------------------------------------------------------
    */

    public function showModalNewAreaDeAsignacion(): void
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
            'areadeasignacion',
            'data_external_component',
            'accionPrincipal',
            'isEditing',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Modal de importación
    |--------------------------------------------------------------------------
    */

    public function showModalImportAreas(): void
    {
        $this->resetValidation();

        $this->archivoAreas = null;
        $this->areasImportadas = 0;
        $this->areasDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->showImportModal = true;

        $this->dispatch('limpiar-archivo-areas');
    }

    public function closeImportModal(): void
    {
        $this->showImportModal = false;

        $this->reset([
            'archivoAreas',
            'areasImportadas',
            'areasDuplicadas',
            'erroresImportacion',
        ]);

        $this->resetValidation('archivoAreas');

        $this->dispatch('limpiar-archivo-areas');
    }

    /*
    |--------------------------------------------------------------------------
    | Importar Excel
    |--------------------------------------------------------------------------
    */

    public function importarAreas(): void
    {
        $this->resetValidation();

        $this->areasImportadas = 0;
        $this->areasDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->validate(
            [
                'archivoAreas' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'archivoAreas.required' =>
                    'Selecciona el archivo que deseas importar.',

                'archivoAreas.file' =>
                    'El archivo seleccionado no es válido.',

                'archivoAreas.mimes' =>
                    'Solamente se permiten archivos XLSX, XLS o CSV.',

                'archivoAreas.max' =>
                    'El archivo no puede superar los 10 MB.',
            ]
        );

        $rutaGuardada = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Verificar extensión
            |--------------------------------------------------------------------------
            */

            $extension = strtolower(
                $this->archivoAreas->getClientOriginalExtension()
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
                'areas-'
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

            $rutaGuardada = $this->archivoAreas->storeAs(
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

            $importacion = new AreasDeAsignacionImport();

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

            $this->areasImportadas =
                $importacion->getAreasImportadas();

            $this->areasDuplicadas =
                $importacion->getAreasDuplicadas();

            $this->erroresImportacion =
                $importacion->getErrores();

            /*
            |--------------------------------------------------------------------------
            | Actualizar tabla
            |--------------------------------------------------------------------------
            */

            $this->search = '';

            $this->resetPage();

            $this->reset('archivoAreas');

            $this->dispatch('limpiar-archivo-areas');

            /*
            |--------------------------------------------------------------------------
            | Importación con errores parciales
            |--------------------------------------------------------------------------
            */

            if (count($this->erroresImportacion) > 0) {
                $this->dispatch(
                    'areas-importacion-advertencia',
                    mensaje:
                        "Se registraron {$this->areasImportadas} áreas, "
                        . "se ignoraron {$this->areasDuplicadas} duplicadas "
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
                'areas-importadas',
                mensaje:
                    "Se registraron {$this->areasImportadas} áreas nuevas "
                    . "y se ignoraron {$this->areasDuplicadas} duplicadas."
            );
        } catch (Throwable $e) {
            report($e);

            $this->addError(
                'archivoAreas',
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
    | Registrar área desde componente hijo
    |--------------------------------------------------------------------------
    */

    #[On('saveFromComponentNewAreaDeAsignacion')]
    public function saveNewAreaDeAsignacion($data): void
    {
        AreaDeUso::create([
            'nombre' => mb_strtoupper(
                trim((string) $data['nombre']),
                'UTF-8'
            ),
        ]);

        $this->showModal = false;

        $this->dispatch('alumno-created', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Actualizar área desde componente hijo
    |--------------------------------------------------------------------------
    */

    #[On('saveUpdateAreaDeUsoFromAnotherComponent')]
    public function saveUpdateAreaDeAsignacion($data): void
    {
        $area = AreaDeUso::findOrFail($data['id']);

        $area->update([
            'nombre' => mb_strtoupper(
                trim((string) $data['nombre']),
                'UTF-8'
            ),
        ]);

        $this->showModal = false;

        $this->dispatch('alumno-updated', 1);
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

    public function edit($id): void
    {
        $this->areadeasignacion =
            AreaDeUso::findOrFail($id);

        $this->showModal = true;

        $this->isEditing = true;

        $this->data_external_component =
            $this->areadeasignacion->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Vista principal
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = AreaDeUso::query();

        if ($this->search !== '') {
            $query->where(
                'nombre',
                'like',
                "%{$this->search}%"
            );
        }

        return view(
            'livewire.area-de-asignacion-form',
            [
                'areasdeasignacion' => $query
                    ->orderBy('nombre')
                    ->paginate($this->perPage),
            ]
        );
    }
}