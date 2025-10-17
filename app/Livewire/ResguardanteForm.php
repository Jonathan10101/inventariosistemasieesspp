<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Resguardante;


class ResguardanteForm extends Component
{
    use WithPagination;
    //public $marcas;
    public $tituloModalPrincipal = "REGISTRAR";
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;
    public $data_external_component;
    public $resguardante;

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchResguardantes()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    public function showModalNewResguardante(){
        $this->showModal = true;// Abre el modal
    }

    // Cerrar el modal y resetear formulario    
    public function closeModal()
    {
        $this->resetForm(); 
        $this->showModal = false; // Cerrar el modal
    }
    
    public function resetForm()
    {        
        $this->reset(['resguardante','data_external_component','accionPrincipal']);        
    }

    #[On('saveFromComponentNewPuesto')]
    public function saveNewResguardante($data){
        Resguardante::create($data);
        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);
    }

    #[On('saveUpdatePuestoFromAnotherComponent')]
    public function saveUpdateResguardante($data){
        //dd($data);
        $updateResguardante = Resguardante::find($data['id']);
        $updateResguardante->update([
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
        $this->resguardante = Resguardante::findOrFail($id);
        $this->isEditing = true;
        $this->data_external_component = $this->puesto->id;
        //$this->id_estudiante = $marca->id;
    }

    public function render()
    {
        $query = Resguardante::query();
        
        if ($this->search) {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                // Buscar cada palabra por separado en todos los campos
                $words = explode(' ', $search);

                foreach ($words as $word) {
                    $q->where(function ($sub) use ($word) {
                        $sub->where('nombre1', 'like', "%{$word}%")
                            ->orWhere('nombre2', 'like', "%{$word}%")
                            ->orWhere('apellido1', 'like', "%{$word}%")
                            ->orWhere('apellido2', 'like', "%{$word}%");
                    });
                }

                // Buscar combinaciones de campos
                $q->orWhereRaw("CONCAT(nombre1, ' ', apellido1) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(nombre1, ' ', apellido2) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(nombre2, ' ', apellido1) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(nombre2, ' ', apellido2) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(apellido1, ' ', apellido2) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(nombre1, ' ', nombre2, ' ', apellido1, ' ', apellido2) LIKE ?", ["%{$search}%"]);
            });
        }

        return view('livewire.resguardante-form', [
            'resguardantes' => $query->paginate($this->perPage),
        ]);
    }
}
