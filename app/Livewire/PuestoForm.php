<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Puesto;


class PuestoForm extends Component
{
    use WithPagination;
    //public $marcas;
    public $tituloModalPrincipal = "REGISTRAR";
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;
    public $data_external_component;
    public $puesto;

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

    public function render()
    {
        $query = Puesto::query();
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%");
            });
        }  
        return view('livewire.puesto-form', [
            'puestos' => $query->paginate($this->perPage),
        ]);
    }
}
