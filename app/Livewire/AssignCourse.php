<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;


class AssignCourse extends Component
{

    public $student;
    public $inscripciones,$cursos,$grupos,$adscripciones,$sedes,$generacionesv2,$instituciones;    
    public $student_id,$estudiante_id,$fecha_inicio_id,$fecha_final_id,$curso_id,$grupo_id,$adscripcion_id,$sede_id,$generacion_id,$promedio,$institucion_id;
    public $tipo_registro;
    public $fecha_validacion_id_inicial, $fecha_validacion_id_final, $fecha_ejecucion_id_inicial,$fecha_ejecucion_id_final,$tutor_id;
    public $instructores;
    /*
    protected $rules = [
        'curso_id' => 'required',
        'grupo_id' => 'required',
        'sede_id' => 'required',
        'adscripcion_id' => 'required',
        //'generacion_id' => 'required',
        //'fecha_inicio_id' => 'required',
        //'fecha_final_id' => 'required'                        
    ];
    */
    protected $rules = [];

    protected function setRules()
    {
        $this->rules = [
            'curso_id' => 'required',
            'institucion_id' => 'required',
            'grupo_id' => 'required',
            'sede_id' => 'required',
            'adscripcion_id' => 'required',
            'fecha_validacion_id_inicial' => 'required',
            'fecha_validacion_id_final' => 'required',
            'fecha_ejecucion_id_inicial' => 'required',
            'fecha_ejecucion_id_final' => 'required'            
        ];

        if ($this->tipo_registro == 'generacion'){
            $this->rules['generacion_id'] = 'required';
        }

        if ($this->tipo_registro == 'curso') {
            $this->rules['fecha_inicio_id'] = 'required';
            $this->rules['fecha_final_id'] = 'required';
        }
    }


    public function changeTipoRegistro(){
        if ($this->tipo_registro == 'generacion') {
            $this->tipo_registro = 'curso';
            $this->reset(['curso_id', 'grupo_id', 'adscripcion_id', 'sede_id', 'fecha_inicio_id', 'fecha_final_id','institucion_id','fecha_validacion_id_inicial','fecha_validacion_id_final','fecha_ejecucion_id_inicial','fecha_ejecucion_id_final']);
        } else {
            $this->tipo_registro = 'generacion';
            $this->reset(['generacion_id']);
        }
    }

    // Setter personalizado para 'tipo_registro'
    public function setTipoRegistro($value)
    {
        $this->tipo_registro = $value;

        if ($value === 'generacion') {
            $this->reset(['curso_id', 'grupo_id', 'adscripcion_id', 'sede_id', 'fecha_inicio_id', 'fecha_final_id','institucion_id','fecha_validacion_id_inicial','fecha_validacion_id_final','fecha_ejecucion_id_inicial','fecha_ejecucion_id_final']);
        } elseif ($value === 'curso') {
            $this->reset(['generacion_id']);
        }
    }


    public function setGeneracion()
    {
        $this->tipo_registro = 'generacion';
        $this->reset(['curso_id', 'grupo_id', 'adscripcion_id', 'sede_id', 'fecha_inicio_id', 'fecha_final_id','institucion_id','fecha_validacion_id_inicial','fecha_validacion_id_final','fecha_ejecucion_id_inicial','fecha_ejecucion_id_final']);
    }


    public function setCurso()
    {
        $this->tipo_registro = 'curso';
        $this->reset(['generacion_id']);
    }
    

    public function mount($student, $inscripciones, $cursos, $grupos, $adscripciones,$sedes, $generacionesv2,$instituciones)
    {
        // Asignamos los datos a las propiedades del componente
        $this->estudiante_id = $student->id;
        $this->student = $student;
        $this->inscripciones = $inscripciones;
        $this->cursos = $cursos;
        $this->grupos = $grupos;
        $this->adscripciones = $adscripciones;
        $this->sedes = $sedes;
        $this->generacionesv2 = $generacionesv2;
        $this->instituciones = $instituciones;
        $this->instructores = Instructor::all();
    }


    public function save(){        
        $this->setRules();
        $this->validate();

        //dd($this->institucion_id);

        if($this->tipo_registro == 'generacion'){
            $data = [
                'estudiante_id' => $this->estudiante_id,
                'curso_id' => $this->curso_id,
                'grupo_id' => $this->grupo_id,
                'adscripcion_id' => $this->adscripcion_id,
                'sede_id' => $this->sede_id,
                'generacion_id' => $this->generacion_id,
                'promedio' => 0,      
                'fecha_inicio_id' => '2000-01-01', //default
                'fecha_final_id' => '2000-01-01', //default    
                'institucion_id' => $this->institucion_id,
                'fecha_validacion_inicial' => $this->fecha_validacion_id_inicial,
                'fecha_validacion_final' => $this->fecha_validacion_id_final,
                'fecha_de_ejecucion_inicial' => $this->fecha_ejecucion_id_inicial,
                'fecha_de_ejecucion_final' => $this->fecha_ejecucion_id_final

            ];

        }else if($this->tipo_registro == 'curso'){                    
            
            $this->fecha_inicio_id = Carbon::parse($this->fecha_inicio_id)->format('Y-m-d');
            $this->fecha_final_id = Carbon::parse($this->fecha_final_id)->format('Y-m-d'); 
            $defaultGeneracion = 1;       //Se pone 1 porque al ser curso no pertenece a ninguna generacion    
            $data = [
                'estudiante_id' => $this->estudiante_id,
                'curso_id' => $this->curso_id,
                'grupo_id' => $this->grupo_id,
                'adscripcion_id' => $this->adscripcion_id,
                'sede_id' => $this->sede_id,            
                'generacion_id' => $defaultGeneracion,    
                'promedio' => 0, 
                'fecha_inicio' => $this->fecha_inicio_id,
                'fecha_fin' => $this->fecha_final_id,
                'institucion_id' => $this->institucion_id,
                'fecha_validacion_inicial' => $this->fecha_validacion_id_inicial,
                'fecha_validacion_final' => $this->fecha_validacion_id_final,
                'fecha_de_ejecucion_inicial' => $this->fecha_ejecucion_id_inicial,
                'fecha_de_ejecucion_final' => $this->fecha_ejecucion_id_final,       
            ];            
        }

        //Emite evento al StudentForm en el metodo save2()        
        $this->dispatch('saveAssignCourse',$data);        
        $this->resetForm();                        
        
    }

    public function resetForm()
    {        
        $this->reset(['curso_id', 'grupo_id', 'adscripcion_id', 'sede_id', 'fecha_inicio_id', 'fecha_final_id','institucion_id','fecha_validacion_id_inicial','fecha_validacion_id_final','fecha_ejecucion_id_inicial','fecha_ejecucion_id_final']);
    }

    public function render()
    {
        return view('livewire.assign-course');
    }


}
