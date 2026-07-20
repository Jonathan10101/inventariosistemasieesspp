<?php

namespace App\Livewire;


use Livewire\WithFileUploads;


use App\Imports\MarcasImport;
use App\Models\Marca;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class MarcaForm extends Component
{
    use WithPagination;
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | Propiedades del módulo
    |--------------------------------------------------------------------------
    */

    public string $tituloModalPrincipal = 'REGISTRAR';

    public bool $showModal = false;

    public bool $showImportModal = false;

    public string $accionPrincipal = '';

    public string $search = '';

    public int $perPage = 3;

    public $data_external_component = null;

    public $marca = null;

    public bool $isEditing = false;

    /*
    |--------------------------------------------------------------------------
    | Propiedades de importación
    |--------------------------------------------------------------------------
    */

    public $archivoMarcas = null;

    public int $marcasImportadas = 0;

    public int $marcasDuplicadas = 0;

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

    public function searchMarcas(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Modal para registrar y editar
    |--------------------------------------------------------------------------
    */

    public function showModalNewMarca(): void
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
            'marca',
            'data_external_component',
            'accionPrincipal',
            'isEditing',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Modal para importar Excel
    |--------------------------------------------------------------------------
    */

    public function showModalImportMarcas(): void
    {
        $this->resetValidation();

        $this->archivoMarcas = null;
        $this->marcasImportadas = 0;
        $this->marcasDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->showImportModal = true;

        $this->dispatch('limpiar-archivo-marcas');
    }

    public function closeImportModal(): void
    {
        $this->showImportModal = false;

        $this->reset([
            'archivoMarcas',
            'marcasImportadas',
            'marcasDuplicadas',
            'erroresImportacion',
        ]);

        $this->resetValidation('archivoMarcas');

        $this->dispatch('limpiar-archivo-marcas');
    }

    /*
    |--------------------------------------------------------------------------
    | Importar marcas
    |--------------------------------------------------------------------------
    */

    public function importarMarcas(): void
    {
        $this->resetValidation();

        $this->marcasImportadas = 0;
        $this->marcasDuplicadas = 0;
        $this->erroresImportacion = [];

        $this->validate(
            [
                'archivoMarcas' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'archivoMarcas.required' =>
                    'Selecciona el archivo que deseas importar.',

                'archivoMarcas.file' =>
                    'El archivo seleccionado no es válido.',

                'archivoMarcas.mimes' =>
                    'Solamente se permiten archivos XLSX, XLS o CSV.',

                'archivoMarcas.max' =>
                    'El archivo no puede superar los 10 MB.',
            ]
        );

        try {
            $totalAntes = Marca::count();

            $importacion = new MarcasImport();

            Excel::import(
                $importacion,
                $this->archivoMarcas
            );

            $totalDespues = Marca::count();

            /*
             * Nuevas marcas insertadas.
             */
            $this->marcasImportadas = max(
                0,
                $totalDespues - $totalAntes
            );

            /*
             * Marcas válidas que no se insertaron
             * porque ya existían.
             */
            $this->marcasDuplicadas = max(
                0,
                $importacion->getFilasProcesadas()
                    - $this->marcasImportadas
            );

            /*
             * Filas rechazadas por validación.
             */
            foreach ($importacion->failures() as $failure) {
                $this->erroresImportacion[] = [
                    'fila' => $failure->row(),

                    'campo' => $failure->attribute(),

                    'valor' =>
                        $failure->values()['nombre'] ?? '',

                    'mensajes' => $failure->errors(),
                ];
            }

            /*
             * Limpiamos la búsqueda para que se vean
             * inmediatamente las marcas importadas.
             */
            $this->search = '';

            $this->resetPage();

            $this->reset('archivoMarcas');

            $this->dispatch('limpiar-archivo-marcas');

            if (count($this->erroresImportacion) > 0) {
                $this->dispatch(
                    'marcas-importacion-advertencia',
                    mensaje:
                        "Se importaron {$this->marcasImportadas} marcas. "
                        . "Se ignoraron {$this->marcasDuplicadas} duplicadas "
                        . 'y algunas filas contenían errores.'
                );

                return;
            }

            $this->showImportModal = false;

            $this->dispatch(
                'marcas-importadas',
                mensaje:
                    "Se importaron {$this->marcasImportadas} marcas nuevas. "
                    . "Se ignoraron {$this->marcasDuplicadas} duplicadas."
            );
        } catch (Throwable $e) {
            report($e);

            $this->addError(
                'archivoMarcas',
                'No fue posible importar el archivo. '
                . 'Verifica que la primera columna se llame nombre.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Registrar y actualizar marca
    |--------------------------------------------------------------------------
    */

    #[On('saveFromComponentNewMarca')]
    public function saveNewMarca($data): void
    {
        Marca::create($data);

        $this->showModal = false;

        $this->dispatch('alumno-created', 1);
    }

    #[On('saveUpdateMarcaFromAnotherComponent')]
    public function saveUpdateMarca($data): void
    {
        $updateMarca = Marca::findOrFail($data['id']);

        $updateMarca->update([
            'nombre' => $data['nombre'],
        ]);

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

    public function edit($id): void
    {
        $this->marca = Marca::findOrFail($id);

        $this->showModal = true;
        $this->isEditing = true;
        $this->data_external_component = $this->marca->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Vista
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = Marca::query();

        if ($this->search !== '') {
            $query->where(
                'nombre',
                'like',
                "%{$this->search}%"
            );
        }

        return view('livewire.marca-form', [
            'marcas' => $query
                ->orderBy('nombre')
                ->paginate($this->perPage),
        ]);
    }
}