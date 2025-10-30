<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardo;

class ShowResguardosModal extends Component
{   
    public $historialResguardo;
    public $historiales;

    public function mount($data){
        $resguardo = Resguardo::find($data);
        $this->historiales = $resguardo->historial;

    }
    
    public function render()
    {
        return view('livewire.show-resguardos-modal');
    }
}
