<?php

namespace App\Livewire;

use Livewire\Component;

class CreateNewMarca extends Component
{
    public $marca;

    protected $rules = [
        'marca' => 'required|min:2|max:150|unique:marcas,nombre'
    ];

    public function save(){
        $this->validate();

        $data = [
            'nombre' => $this->marca,
        ];

        $this->dispatch('saveFromComponentNewMarca',$data);        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'marca'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-marca');
    }
}
