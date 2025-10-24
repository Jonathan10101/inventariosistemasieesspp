<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puesto;

class CreateNewPuesto extends Component
{
    public $puesto;

    protected $rules = [
        'puesto' => 'required|min:2|max:100|unique:puestos,nombre'
    ];

    public function save(){
        // Normalizar antes de validar o buscar duplicados
        $this->puesto = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->puesto)));
        $this->validate();

        $puestoComparacion = str_replace(' ', '', $this->puesto);

        $existe = Puesto::whereRaw("REPLACE(nombre, ' ', '') = ?", [$puestoComparacion])->exists();

        if ($existe) {
            $this->addError('puesto', 'Este puesto ya existe aunque escrito diferente.');
            return;
        }

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
