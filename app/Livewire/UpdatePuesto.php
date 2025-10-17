<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puesto;

class UpdatePuesto extends Component
{
    public $puesto,$puestoBusqueda,$id_puesto;
    protected $rules = [
        'puesto' => 'required|min:2|max:100|unique:puestos,nombre',      
    ];

    public function mount($data){     
        $puestoBusqueda =   Puesto::find($data);
        $this->puesto = $puestoBusqueda->nombre; 
        $this->id_puesto = $puestoBusqueda->id; 
    }

    public function save(){
        $this->validate();    
        $data = [
            'id' => $this->id_puesto,
            'nombre' =>  $this->puesto,
        ];                            
        $this->dispatch('saveUpdatePuestoFromAnotherComponent',$data);
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['puesto','id_puesto']);
    }

    public function render()
    {
        return view('livewire.update-puesto');
    }
}
