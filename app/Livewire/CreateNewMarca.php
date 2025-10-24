<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marca;

class CreateNewMarca extends Component
{
    public $marca;

    protected $rules = [
        'marca' => 'required|min:2|max:150|unique:marcas,nombre'
    ];

    public function save(){
        $this->marca = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->marca)));
        $this->validate();

        $marcaComparacion = str_replace(' ', '', $this->marca);

        $existe = Marca::whereRaw("REPLACE(nombre, ' ', '') = ?", [$marcaComparacion])->exists();

        if ($existe) {
            $this->addError('marca', 'Esta marca ya existe aunque escrito diferente.');
            return;
        }


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
