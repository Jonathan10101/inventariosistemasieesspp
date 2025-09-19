<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cursos;
use Carbon\Carbon;

class CreateNewCourse extends Component
{
    public $name_of_course,$duration_of_course,$type_of_course;

    protected $rules = [
        'name_of_course' => 'required|string|max:250|unique:cursos,nombre_curso',
        'duration_of_course' => 'required|integer|max:2050|min:5',
        'type_of_course' => 'required'        
    ];

    public function save(){        
        $this->validate();     
        $data = [
            'nombre_curso' => $this->name_of_course,
            'duracion_en_horas' => $this->duration_of_course,
            'type_of_course' => $this->type_of_course,
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now()       
        ];
        
        //$this->dispatch('notifyCloseModal');
        $this->dispatch('saveFromComponentNewCourse',$data); 
        $this->resetForm(); // Limpia las propiedades del formulario        
    }

    public function resetForm()
    {
        $this->reset([
            'name_of_course', 'duration_of_course', 'type_of_course'
        ]);
    }


    public function render()
    {
        return view('livewire.create-new-course');
    }
}
