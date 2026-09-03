<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Puesto;
use App\Imports\PuestosImport;
use Livewire\WithFileUploads;
use Throwable;


class PuestoForm extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $tituloModalPrincipal = "REGISTRAR";
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;
    public $data_external_component;
    public $puesto;

    public bool $showImportModal = false;

    public $archivoPuestos = null;

    public int $puestosImportados = 0;

    public int $puestosDuplicados = 0;

    public array $erroresImportacion = [];

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchPuestos()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    public function showModalNewPuesto(){
        $this->showModal = true;// Abre el modal
    }

    // Cerrar el modal y resetear formulario    
    public function closeModal()
    {
        $this->resetForm(); 
        $this->showModal = false; // Cerrar el modal
        $this->dispatch('refresh-page'); 
    }
    
    public function resetForm()
    {        
        $this->reset(['puesto','data_external_component','accionPrincipal']);        
    }

    #[On('saveFromComponentNewPuesto')]
    public function saveNewPuesto($data){
        Puesto::create($data);
        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);
    }

    #[On('saveUpdatePuestoFromAnotherComponent')]
    public function saveUpdatePuesto($data){
        //dd($data);
        $updatePuesto = Puesto::find($data['id']);
        $updatePuesto->update([
            'nombre' => $data['nombre']
        ]);
        $this->dispatch('alumno-updated',1);
        $this->showModal = false;  
    }

    public function cambiarAccion($nuevaAccion,$id)
    {       
        $this->accionPrincipal = $nuevaAccion;// Cambia el valor de la propiedad
        $this->changeModalTitle($this->accionPrincipal);
        $this->accionEjecutada($this->accionPrincipal,$id);
    }

    public function changeModalTitle($accion){
        switch ($accion) {
            case "editar":
                $this->tituloModalPrincipal = "Editar";            
            break;
            default:
                $this->tituloModalPrincipal = "Registrar";            
            break;
        }
    }

     public function accionEjecutada($accion,$id){
        switch ($accion) {
            case "inscripcion_a_curso":                
                //$this->assignCourse($id);
            break;
            case "editar":
                $this->edit($id);   
            break;                 
        }  
    }

    // Método para editar marca
    public function edit($id)
    {      
        $this->showModal = true;  
        $this->puesto = Puesto::findOrFail($id);
        $this->isEditing = true;
        $this->data_external_component = $this->puesto->id;
        //$this->id_estudiante = $marca->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showModalImportPuestos(): void
    {
        $this->resetValidation();

        $this->archivoPuestos = null;
        $this->puestosImportados = 0;
        $this->puestosDuplicados = 0;
        $this->erroresImportacion = [];

        $this->showImportModal = true;

        $this->dispatch('limpiar-archivo-puestos');
    }

    public function closeImportModal(): void
    {
        $this->showImportModal = false;

        $this->reset([
            'archivoPuestos',
            'puestosImportados',
            'puestosDuplicados',
            'erroresImportacion',
        ]);

        $this->resetValidation('archivoPuestos');

        $this->dispatch('limpiar-archivo-puestos');
    }

    public function importarPuestos(): void
    {
        $this->resetValidation();

        $this->puestosImportados = 0;
        $this->puestosDuplicados = 0;
        $this->erroresImportacion = [];

        $this->validate(
            [
                'archivoPuestos' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'archivoPuestos.required' =>
                    'Selecciona el archivo que deseas importar.',

                'archivoPuestos.file' =>
                    'El archivo seleccionado no es válido.',

                'archivoPuestos.mimes' =>
                    'Solamente se permiten archivos XLSX, XLS o CSV.',

                'archivoPuestos.max' =>
                    'El archivo no puede superar los 10 MB.',
            ]
        );

        $rutaGuardada = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Validar extensión
            |--------------------------------------------------------------------------
            */

            $extension = strtolower(
                $this->archivoPuestos->getClientOriginalExtension()
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
                'puestos-'
                . date('YmdHis')
                . '-'
                . bin2hex(random_bytes(5))
                . '.'
                . $extension;

            /*
            |--------------------------------------------------------------------------
            | Guardar temporalmente
            |--------------------------------------------------------------------------
            */

            $rutaGuardada = $this->archivoPuestos->storeAs(
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
            | Importar puestos
            |--------------------------------------------------------------------------
            */

            $importacion = new PuestosImport();

            \Maatwebsite\Excel\Facades\Excel::import(
                $importacion,
                $rutaGuardada,
                'local'
            );

            /*
            |--------------------------------------------------------------------------
            | Resultados
            |--------------------------------------------------------------------------
            */

            $this->puestosImportados =
                $importacion->getPuestosImportados();

            $this->puestosDuplicados =
                $importacion->getPuestosDuplicados();

            $this->erroresImportacion =
                $importacion->getErrores();

            /*
            |--------------------------------------------------------------------------
            | Actualizar listado
            |--------------------------------------------------------------------------
            */

            $this->search = '';

            $this->resetPage();

            $this->reset('archivoPuestos');

            $this->dispatch('limpiar-archivo-puestos');

            if (count($this->erroresImportacion) > 0) {
                $this->dispatch(
                    'puestos-importacion-advertencia',
                    mensaje:
                        "Se registraron {$this->puestosImportados} puestos, "
                        . "se ignoraron {$this->puestosDuplicados} duplicados "
                        . 'y algunas filas contenían errores.'
                );

                return;
            }

            $this->showImportModal = false;

            $this->dispatch(
                'puestos-importados',
                mensaje:
                    "Se registraron {$this->puestosImportados} puestos nuevos "
                    . "y se ignoraron {$this->puestosDuplicados} duplicados."
            );
        } catch (Throwable $e) {
            report($e);

            $this->addError(
                'archivoPuestos',
                'No se pudo importar: ' . $e->getMessage()
            );
        } finally {
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

    public function render()
    {
        $query = Puesto::query();        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'LIKE', "%{$this->search}%");
            });
        }  
        return view('livewire.puesto-form', [
            'puestos' => $query->paginate($this->perPage),
        ]);
    }
    
}
