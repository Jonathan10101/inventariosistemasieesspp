<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cursos;
use App\Models\Grupos;
use App\Models\Sedes;
use App\Models\Adscripciones;
use App\Models\Generaciones;
use App\Models\Escolaridad;
use App\Models\Inscripciones;
use App\Models\Municipio;
use App\Models\Estudiante;
use Carbon\Carbon;



class UpdateAssigmentCourse extends Component
{
    public $id_curso,$id_grupo,$id_adscripcion,$id_sede,$id_generacion,$id_inscripcion,$id_estudiante;        
    public $cursos,$escolaridades,$municipios,$sedes,$grupos,$adscripciones,$inscripciones,$generacionesv2,$inscripcion;
    public $generacion_id,$fecha_inicio_id,$fecha_final_id;            
    public $showModal = false;
    public $fecha_validacion_id,$fecha_ejecucion_id;
    public $fecha_validacion_id_inicial, $fecha_validacion_id_final, $fecha_ejecucion_id_inicial,$fecha_ejecucion_id_final;

    
    protected $rules = [];

    protected function setRules()
    {
        $this->rules = [
        'id_curso' => 'required',
        'id_grupo' => 'required',
        'id_sede' => 'required',
        'id_adscripcion' => 'required'
        ];

        if ($this->id_generacion == 1){
            $this->rules['fecha_inicio_id'] = 'required';
            $this->rules['fecha_final_id'] = 'required';
            
        }else{
            $this->rules['id_generacion'] = 'required';
        }
    }


    public function mount($data)
    {
        $this->id_estudiante = $data['id_estudiante'];
        $this->id_curso = $data['curso_id'];
        $this->id_grupo = $data['grupo_id'];
        $this->id_adscripcion = $data['adscripcion_id'];
        $this->id_sede = $data['sede_id'];
        $this->id_generacion = $data['generacion_id'];
        $this->id_inscripcion = $data['id_inscripcion'];
        $fechainicio = $data['fecha_inicio'];
        $fechafinal = $data['fecha_terminacion'];
        //dd("updateassigment",$data);
        $this->fecha_validacion_id_inicial = $data['fecha_validacion_inicial'];
        $this->fecha_validacion_id_final = $data['fecha_validacion_final'];
        $this->fecha_ejecucion_id_inicial = $data['fecha_de_ejecucion_inicial'];
        $this->fecha_ejecucion_id_final = $data['fecha_de_ejecucion_final'];
        //$this->fecha_validacion_id =  $this->inscripcion->fecha_validacion;
        //dd($this->fecha_validacion_id); 

        $id_of_inscription = $this->id_inscripcion;
        $this->inscripcion = Inscripciones::find($id_of_inscription);

        if($this->id_generacion == 1){
            $this->fecha_inicio_id = $this->inscripcion->fecha_inicio;
            $this->fecha_final_id = $this->inscripcion->fecha_fin;
        }else{
            $this->fecha_inicio_id = $data['fecha_inicio'];
            $this->fecha_final_id = $data['fecha_terminacion'];
        }        
        
        $this->escolaridades = Escolaridad::all();
        $this->municipios = Municipio::all();
        $this->cursos = Cursos::all();
        $this->grupos = Grupos::all();
        $this->sedes = Sedes::all();
        $this->adscripciones = Adscripciones::all();
        $this->generacionesv2 = Generaciones::all();        
    }


    public function save(){
        
        $this->setRules();
        $this->validate();

        //dd($this->fecha_inicio_id);


        $id_del_curso = $this->id_curso;
        $typeofcourse = Cursos::find($id_del_curso)->type_of_course;

        
        //$this->validate();
        //dd($typeofcourse);        
        $data = [
            'id_inscripcion' => $this->id_inscripcion,
            'type_of_course' => $typeofcourse,
            'id_estudiante' => $this->id_estudiante,
            'id_curso' => $this->id_curso,
            'id_grupo' => $this->id_grupo,
            'id_sede' => $this->id_sede,
            'id_adscripcion' => $this->id_adscripcion,            
            'id_generacion' => $this->id_generacion,
            'fecha_inicio' => $this->fecha_inicio_id,
            'fecha_final' => $this->fecha_final_id, 
            'fecha_validacion_id_inicial' => $this->fecha_validacion_id_inicial,
            'fecha_validacion_id_final' => $this->fecha_validacion_id_final,
            'fecha_ejecucion_id_inicial' => $this->fecha_ejecucion_id_inicial,
            'fecha_ejecucion_id_final' => $this->fecha_ejecucion_id_final,
        ];        
                
        //Envia evento a StudentForm disparando función saveUpdateCourseOfStudent()
        $this->dispatch('saveUpdateCourseOfStudentFromAnotherComponent',$data);
    }

    public function resetForm()
    {        
        $this->reset(['id_curso','id_grupo','id_sede','id_adscripcion','id_generacion','fecha_inicio_id','fecha_final_id','fecha_validacion_id_inicial','fecha_validacion_id_final','fecha_ejecucion_id_inicial','fecha_ejecucion_id_final']);        
    }

    public function render()
    {
        return view('livewire.update-assigment-course');
    }
    
}

