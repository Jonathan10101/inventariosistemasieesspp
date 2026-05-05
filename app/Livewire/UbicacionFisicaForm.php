<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\UbicacionFisica;

class UbicacionfisicaForm extends Component
{
    use WithPagination;
    //public $marcas;
    public $tituloModalPrincipal = "REGISTRAR";
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;
    public $data_external_component;
    public $ubicacion_fisica;

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchUbicacionesFisicas()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    public function showModalNewUbicacionFisica(){
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
        $this->reset(['ubicacion_fisica','data_external_component','accionPrincipal']);        
    }

    #[On('saveFromComponentNewUbicacionFisica')]
    public function saveNewMarca($data){
        UbicacionFisica::create($data);
        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);
    }

    #[On('saveUpdateUbicacionFisicaFromAnotherComponent')]
    public function saveUpdateUbicacionFisica($data){
        //dd($data);
        $updateMarca = UbicacionFisica::find($data['id']);
        if($data['imagen']!=null){
            $updateMarca->update([
                'descripcion' => $data['descripcion'],
                'imagen' => $data['imagen']
            ]);
        }else{
            $updateMarca->update([
                'descripcion' => $data['descripcion']
            ]);
        }
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

    // Método para editar ubicación fisica
    public function edit($id)
    {      
        $this->showModal = true;  
        $this->marca = UbicacionFisica::findOrFail($id);
        $this->isEditing = true;
        $this->data_external_component = $this->marca->id;
        //$this->id_estudiante = $marca->id;
    }

    public function downloadEtiqueta($id)
    {       
        $codigo = str_pad($id, 8, '0', STR_PAD_LEFT);
        return redirect()->route('etiquetas2.show',$codigo);
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = UbicacionFisica::query();
        if ($this->search) {
            $busqueda = trim($this->search);
            $busquedaSinCeros = ltrim($this->search, '0');

            $query->where(function ($q) use ($busqueda, $busquedaSinCeros) {
                $q->where('descripcion', 'like', "%{$this->search}%")
                ->orWhere('id', $busqueda);
            });
        }
        return view('livewire.ubicacionfisica-form', [
            'ubicacionesfisicas' => $query->paginate($this->perPage),
        ]);
    }
}
