<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marca;

class UpdateMarca extends Component
{
    public $marca,$marcaBusqueda,$id_marca;
    protected $rules = [
        'marca' => 'required|min:2|max:150|unique:marcas,nombre',      
    ];

    public function mount($data){     
        $marcaBusqueda =   Marca::find($data);
        $this->marca = $marcaBusqueda->nombre; 
        $this->id_marca = $marcaBusqueda->id; 
    }

    public function save(){
        $this->validate();    
        $data = [
            'id' => $this->id_marca,
            'nombre' =>  $this->marca,
        ];                            
        $this->dispatch('saveUpdateMarcaFromAnotherComponent',$data);
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['marca','id_marca']);
    }

    public function render()
    {
        return view('livewire.update-marca');
    }
}
