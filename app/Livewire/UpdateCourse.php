<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateCourse extends Component
{
    public $name_of_course,$duration_of_course,$type_of_course,$id_curso;

    protected $rules = [
        'name_of_course' => 'required|string|max:255',
        'duration_of_course' => 'required|integer|max:2050|min:5',
        'type_of_course' => 'required'        
    ];

    public function mount($course){       
        $this->id_curso = $course->id; 
        $this->name_of_course = $course->nombre_curso;
        $this->duration_of_course = $course->duracion_en_horas;
        $this->type_of_course = $course->type_of_course;        
    }

    public function save(){
        //$this->resetForm();
        $this->validate();       
        
        $data = [
            'id_curso' =>  $this->id_curso,
            'name_of_course' => $this->name_of_course,
            'duration_of_course' => $this->duration_of_course,
            'type_of_course' => $this->type_of_course            
        ];                            
        $this->dispatch('saveUpdateCourseFromAnotherComponent',$data);
    }


    public function resetForm()
    {
        $this->reset([
            'name_of_course','duration_of_course','type_of_course'            
        ]);
    }

    public function render()
    {
        return view('livewire.update-course');
    }
}
