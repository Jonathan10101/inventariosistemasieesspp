<?php

namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf; 
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Estudiante;
use App\Models\Inscripciones;

class ShowCertificates extends Component
{
    public $student;
    public $inscripciones = [];
    public $model;
    
    public function mount($student, $inscripciones)
    {
        $this->student = $student;
        $this->inscripciones = $inscripciones;
    }

    public function save($id,$idCurso,$nameOfCourse=""){
        
        $this->dispatch('downloadCertificateCall',$id,$idCurso,$nameOfCourse);
        $this->dispatch('loading');    
    }

    public function render()
    {        
        return view('livewire.show-certificates');
    }
}

