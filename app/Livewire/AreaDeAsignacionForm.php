<?php

namespace App\Livewire;

use App\Imports\AreasDeAsignacionImport;
use App\Models\AreaDeUso;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;

class AreaDeAsignacionForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    /*
    |--------------------------------------------------------------------------
    | Propiedades generales
    |--------------------------------------------------------------------------
    */

    public string $tituloModalPrincipal = 'REGISTRAR';

    public bool $showModal = false;

    public bool $showImportModal = false;

    public string $accionPrincipal = 'registrar';

    public string $search = '';

    public int $perPage = 5;

    /*
    |--------------------------------------------------------------------------
    | Propiedades del formulario
    |--------------------------------------------------------------------------
    */

    public ?int $areaId = null;

    public string $nombre = '';

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
    | Modal registrar
    |--------------------------------------------------------------------------
    */

    public function showModalNewAreaDeAsignacion(): void
    {
        $this->resetForm();

        $this->accionPrincipal = 'registrar';

        $this->tituloModalPrincipal = 'REGISTRAR';

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Modal editar
    |--------------------------------------------------------------------------
    */

    public function cambiarAccion(
        string $nuevaAccion,
        int $id
    ): void {
        if ($nuevaAccion !== 'editar') {
            return;
        }

        $this->edit($id);
    }

    public function edit(int $id): void
    {
        $this->resetForm();

        $area = AreaDeUso::findOrFail($id);

        $this->areaId = $area->id;

        $this->nombre = (string) $area->nombre;

        $this->isEditing = true;

        $this->accionPrincipal = 'editar';

        $this->tituloModalPrincipal = 'EDITAR';

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Cerrar modal
    |--------------------------------------------------------------------------
    */

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->resetForm();
    }

    /*
    |--------------------------------------------------------------------------
    | Limpiar formulario
    |--------------------------------------------------------------------------
    */

    public function resetForm(): void
    {
        $this->resetValidation();

        $this->areaId = null;

        $this->nombre = '';

        $this->isEditing = false;

        $this->accionPrincipal = 'registrar';

        $this->tituloModalPrincipal = 'REGISTRAR';
    }

    /*
    |--------------------------------------------------------------------------
    | Validaciones
    |--------------------------------------------------------------------------
    */

    protected function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:150',

                function (
                    string $attribute,
                    $value,
                    \Closure $fail
                ): void {
                    $nombreNormalizado = mb_strtoupper(
                        trim((string) $value),
                        'UTF-8'
                    );

                    $query = AreaDeUso::query()
                        ->where('nombre', $nombreNormalizado);

                    if (
                        $this->isEditing
                        && $this->areaId !== null
                    ) {
                        $query->where(
                            'id',
                            '!=',
                            $this->areaId
                        );
                    }

                    if ($query->exists()) {
                        $fail(
                            'Esta área de asignación ya está registrada.'
                        );
                    }
                },
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.required' =>
                'El nombre del área de asignación es obligatorio.',

            'nombre.string' =>
                'El nombre del área de asignación no es válido.',

            'nombre.min' =>
                'El nombre debe contener al menos 2 caracteres.',

            'nombre.max' =>
                'El nombre no puede superar los 150 caracteres.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Registrar o actualizar
    |--------------------------------------------------------------------------
    */

    public function saveArea(): void
    {
        $this->nombre = mb_strtoupper(
            trim($this->nombre),
            'UTF-8'
        );

        $this->validate();

        if (
            $this->isEditing
            && $this->areaId !== null
        ) {
            $area = AreaDeUso::findOrFail(
                $this->areaId
            );

            $area->update([
                'nombre' => $this->nombre,
            ]);

            $this->showModal = false;

            $this->resetForm();

            $this->resetPage();

            $this->dispatch(
                'alumno-updated'
            );

            return;
        }

        AreaDeUso::create([
            'nombre' => $this->nombre,
        ]);

        $this->showModal = false;

        $this->resetForm();

        $this->resetPage();

        $this->dispatch(
            'alumno-created'
        );
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

        $this->dispatch(
            'limpiar-archivo-areas'
        );
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

        $this->resetValidation(
            'archivoAreas'
        );

        $this->dispatch(
            'limpiar-archivo-areas'
        );
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
            $extension = strtolower(
                $this->archivoAreas
                    ->getClientOriginalExtension()
            );

            if (
                !in_array(
                    $extension,
                    ['xlsx', 'xls', 'csv'],
                    true
                )
            ) {
                throw new \RuntimeException(
                    'El formato del archivo no es compatible.'
                );
            }

            $nombreTemporal =
                'areas-'
                . date('YmdHis')
                . '-'
                . bin2hex(random_bytes(5))
                . '.'
                . $extension;

            $rutaGuardada =
                $this->archivoAreas->storeAs(
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
                !Storage::disk('local')
                    ->exists($rutaGuardada)
            ) {
                throw new \RuntimeException(
                    'El archivo temporal no fue encontrado.'
                );
            }

            $importacion =
                new AreasDeAsignacionImport();

            \Maatwebsite\Excel\Facades\Excel::import(
                $importacion,
                $rutaGuardada,
                'local'
            );

            $this->areasImportadas =
                $importacion->getAreasImportadas();

            $this->areasDuplicadas =
                $importacion->getAreasDuplicadas();

            $this->erroresImportacion =
                $importacion->getErrores();

            $this->search = '';

            $this->resetPage();

            $this->reset(
                'archivoAreas'
            );

            $this->dispatch(
                'limpiar-archivo-areas'
            );

            if (
                count($this->erroresImportacion) > 0
            ) {
                $this->dispatch(
                    'areas-importacion-advertencia',
                    mensaje:
                        "Se registraron {$this->areasImportadas} áreas, "
                        . "se ignoraron {$this->areasDuplicadas} duplicadas "
                        . 'y algunas filas contenían errores.'
                );

                return;
            }

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
                'No se pudo importar: '
                . $e->getMessage()
            );
        } finally {
            if (
                $rutaGuardada
                && Storage::disk('local')
                    ->exists($rutaGuardada)
            ) {
                Storage::disk('local')
                    ->delete($rutaGuardada);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Vista
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