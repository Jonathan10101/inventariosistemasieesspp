<?php

namespace App\Livewire;

use Livewire\Component;

class UnsubscribeStudent extends Component
{
    public $fechaBaja;
    public $motivoBaja;
    public $idStudent;
    public $motivo_baja_mount;
    public $fecha_baja_mount;

    protected $rules = [
        'fecha_baja_mount' => 'required',
        'motivo_baja_mount' => 'required',
    ];

    
    public function mount($student,$motivo_baja,$fecha_baja)
    {
        $this->idStudent = $student->id;
        $this->motivo_baja_mount = $motivo_baja;
        $this->fecha_baja_mount = $fecha_baja;
    }

    public function save(){

        $this->validate();       
        
        $data = [
            'fechaBaja' => $this->fecha_baja_mount,
            'motivoBaja' => $this->motivo_baja_mount,
            'idStudent' => $this->idStudent
        ];

        //dd($data);
        $this->dispatch('saveUnsubscribetFromAnotherComponent',$data);
        //Manda a llamar a StudentForm en su función saveUnsubscribeStudent
    }

    
    public function render()
    {
        return view('livewire.unsubscribe-student');
    }


}
