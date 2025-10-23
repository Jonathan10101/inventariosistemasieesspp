<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardante;

class CreateNewResguardante extends Component
{
    public $nombre1,$nombre2,$apellido1,$apellido2;

    protected $rules = [
        'nombre1' => 'required|min:2|max:50',
        'nombre2' => 'nullable|max:50',
        'apellido1' => 'required|min:2|max:50',
        'apellido2' => 'nullable|max:50'
    ];

    public function save(){
        $this->validate();

        $data = [
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
        ];

        // Validar combinación única
        $existe = Resguardante::where('nombre1', $this->nombre1)
            ->where('nombre2', $this->nombre2)
            ->where('apellido1', $this->apellido1)
            ->where('apellido2', $this->apellido2)
            ->exists();

        if ($existe) {
            $this->addError('nombreCompleto', 'Este resguardante ya fue registrado. Intenta con uno distinto.');
            return;
        }

        $this->dispatch('saveFromComponentNewResguardante',$data);        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'nombre1','nombre2','apellido1','apellido2'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-resguardante');
    }
}
