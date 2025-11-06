<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UbicacionFisica;

class CreateNewUbicacionfisica extends Component
{
    public $ubicacionfisica;

    protected $rules = [
        'ubicacionfisica' => 'required|min:2|max:150|unique:ubicacion_fisicas,descripcion'
    ];

    public function save(){
        $this->ubicacionfisica = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->ubicacionfisica)));
        $this->validate();

        $ubicacionfisicaComparacion = str_replace(' ', '', $this->ubicacionfisica);

        $existe = UbicacionFisica::whereRaw("REPLACE(descripcion, ' ', '') = ?", [$ubicacionfisicaComparacion])->exists();

        if ($existe) {
            $this->addError('ubicacionfisica', 'Esta ubicación física ya existe aunque escrito diferente.');
            return;
        }


        $data = [
            'ubicacionfisica' => $this->ubicacionfisica,
        ];

        $this->dispatch('saveFromComponentNewUbicacionFisica',$data);        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'ubicacionfisica'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-ubicacionfisica');
    }
}
