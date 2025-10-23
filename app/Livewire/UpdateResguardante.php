<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardante;
use Livewire\Attributes\On;

class UpdateResguardante extends Component
{
    public $nombre1,$nombre2,$apellido1,$apellido2,$resguardanteBusqueda,$id_resguardante;
    protected $rules = [
        'nombre1' => 'required|min:2|max:50',
        'nombre2' => 'nullable|max:50',
        'apellido1' => 'required|min:2|max:50',
        'apellido2' => 'nullable|max:50',
    ];

    public function mount($data){   
        $resguardanteBusqueda = Resguardante::find($data);
        $this->nombre1 = $resguardanteBusqueda->nombre1; 
        $this->nombre2 = $resguardanteBusqueda->nombre2; 
        $this->apellido1 = $resguardanteBusqueda->apellido1; 
        $this->apellido2 = $resguardanteBusqueda->apellido2; 

        $this->id_resguardante = $resguardanteBusqueda->id; 
    }

#[On('resetUpdateResguardante')]
public function resetUpdateResguardante()
{
    dd("x");
    $this->resetForm();
}


    public function save(){
        $this->validate();    
        
        // Validar combinación única
        $existe = Resguardante::where('nombre1', $this->nombre1)
            ->where('nombre2', $this->nombre2)
            ->where('apellido1', $this->apellido1)
            ->where('apellido2', $this->apellido2)
            ->exists();

        if ($existe) {
            $this->addError('nombreCompleto', 'El nombre completo ya está registrado.');
            return;
        }

        $data = [
            'id' => $this->id_resguardante,
            'nombre1' =>  $this->nombre1,
            'nombre2' =>  $this->nombre2,
            'apellido1' =>  $this->apellido1,
            'apellido2' =>  $this->apellido2,
        ];          
         
        $this->dispatch('UpdateResguardanteFromAnotherComponent',$data);
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nombre1','nombre2','apellido1','apellido2','resguardanteBusqueda','id_resguardante']);
    }

    public function render()
    {
        return view('livewire.update-resguardante');
    }

}
