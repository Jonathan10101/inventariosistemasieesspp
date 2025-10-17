<?php

namespace App\Livewire;

use Livewire\Component;

class CreateNewPuesto extends Component
{
    public $puesto;

    protected $rules = [
        'puesto' => 'required|min:2|max:100|unique:puestos,nombre'
    ];

    public function save(){
        $this->validate();

        $data = [
            'nombre' => $this->puesto,
        ];

        $this->dispatch('saveFromComponentNewPuesto',$data);        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'puesto'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-puesto');
    }
}
