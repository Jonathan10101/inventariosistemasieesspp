<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\User;

class UserForm extends Component
{
    use WithPagination;
    //public $marcas;
    public $tituloModalPrincipal = "REGISTRAR";
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;
    public $data_external_component;
    public $user;

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchUsers()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    public function showModalNewUser(){
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
        $this->reset(['user','data_external_component','accionPrincipal']);        
    }

    #[On('saveFromComponentNewUser')]
    public function saveNewUser($data){
        User::create($data);
        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);
    }

    #[On('saveUpdateUserFromAnotherComponent')]
    public function saveUpdateUser($data){
        //dd($data);
        $updateMarca = User::find($data['id']);
        $updateMarca->update([
            'name' => $data['nombre']
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

    // Método para editar usuario
    public function edit($id)
    {      
        $this->showModal = true;  
        $this->user = User::findOrFail($id);
        $this->isEditing = true;
        $this->data_external_component = $this->user->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            });
        }  
        return view('livewire.user-form', [
            'usuarios' => $query->paginate($this->perPage),
        ]);
    }
}
