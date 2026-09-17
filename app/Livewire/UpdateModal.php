<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cursos;
use App\Models\Grupos;
use App\Models\Sedes;
use App\Models\Adscripciones;
use App\Models\Generaciones;
use App\Models\Escolaridad;
use App\Models\Municipio;
use App\Models\Estudiante;
use App\Models\Inscripciones;
use Livewire\WithPagination;

class UpdateModal extends Component
{
    use WithPagination;

    public $nombre1,$nombre2,$apellido1,$apellido2,$matricula_cuip,$estado_procedencia,$municipio_procedencia,$curp,$fecha_nacimiento,$id_escolaridad,$cuip,
    $id_adscripcion,$genero,$correo_electronico,$celular;
    public $cursos,$escolaridades,$municipios,$sedes,$grupos,$adscripciones,$inscripciones,$generacionesv2;
    public $showAdditionalFields = false;
    public $student;
    public $fecha_validacion_id_inicial, $fecha_validacion_id_final, $fecha_ejecucion_id_inicial,$fecha_ejecucion_id_final;

    
    public $id_estudiante;
    public $grupo_id,$adscripcion_id,$sede_id,$generacion_id;
    //public $formSubmitted = false;


    protected $rules = [
        'nombre1' => 'required|string|max:255',
        'apellido1' => 'required|string|max:255',
        'municipio_procedencia' => 'required|exists:municipios,id',
        'curp' => 'required|string|size:18|unique:estudiantes,curp',
        'fecha_nacimiento' => 'required',
        'id_escolaridad' => 'required|exists:escolaridad,id',
        'genero' => 'required|in:M,H',                
        //'generacion_id' => 'required|exists:generaciones,id', // Validar que exista en la tabla generaciones
        'celular' => 'nullable|digits:10|unique:estudiantes', // Validar que sea un número de 10 dígitos         
        'correo_electronico' => 'required',
        'matricula_cuip' => 'required|unique:estudiantes,matricula_cuip|min:20|max:20', // Aseguramos que sea único
        //'cuip' => 'required|unique:estudiantes,cuip|min:18|max:18', // Aseguramos que sea único
    ];



    public function mount($student)
    {
        $this->student = $student;
        $this->escolaridades = Escolaridad::all();
        $this->municipios = Municipio::all();
        $this->cursos = Cursos::all();
        $this->grupos = Grupos::all();
        $this->sedes = Sedes::all();
        $this->adscripciones = Adscripciones::all();
        $this->generacionesv2 = Generaciones::all();      
        $this->id_estudiante = $student->id;
        $this->edit($this->id_estudiante);        
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $this->isEditing = true;
        $this->id_estudiante = $estudiante->id;

        $this->nombre1 = $estudiante->nombre1;
        $this->nombre2 = $estudiante->nombre2;
        $this->apellido1 = $estudiante->apellido1;
        $this->apellido2 = $estudiante->apellido2;
        $this->matricula_cuip = $estudiante->matricula_cuip;     
        //$this->estado_procedencia = $estudiante->estado_id;
        $this->municipio_procedencia = $estudiante->municipio_id;
        $this->curp = $estudiante->curp;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;        
        
        $this->id_escolaridad = $estudiante->escolaridad_id;
        $this->genero = $estudiante->genero;
        $this->celular = $estudiante->celular;
        $this->correo_electronico = $estudiante->correo_electronico;        
        $this->cuip = $estudiante->cuip;
    }

    public function save(){                
        $this->rules['celular'] = 'required|string|size:10|unique:estudiantes,celular,' . $this->id_estudiante;
        $this->rules['curp'] = 'required|string|size:18|unique:estudiantes,curp,' . $this->id_estudiante;
        $this->rules['correo_electronico'] = 'required|email';
        $this->rules['matricula_cuip'] = 'required|unique:estudiantes,matricula_cuip,' . $this->id_estudiante . '|min:20|max:20';
        //$this->rules['cuip'] = 'required|unique:estudiantes,cuip,' . $this->id_estudiante . '|min:18|max:18';

        

        $this->validate();       
        
        $data = [
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'matricula_cuip' => $this->matricula_cuip,
            //'municipio_id' => $this->municipio_procedencia,
            'curp' => $this->curp,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'escolaridad_id' => $this->id_escolaridad,                
            'celular' => $this->celular,
            'genero' => $this->genero,
            'correo_electronico' => $this->correo_electronico,   
            'cuip' => $this->cuip     
        ];        
        
        //$this->resetForm();      
    

        $this->dispatch('saveUpdateStudentFromAnotherComponent',$data);
                  
    }

    public function updateCourse($curso_id,$grupo_id,$adscripcion_id,$sede_id,$generacion_id,$fecha_inicio,$fecha_terminacion,$id_inscripcion,$fecha_validacion_inicial,$fecha_validacion_final,$fecha_de_ejecucion_inicial,$fecha_de_ejecucion_final){
        //$this->resetForm();  
        //dd($fecha_validacion);    
        
        $data2 = [
            'id_estudiante' => $this->id_estudiante,
            'curso_id' => $curso_id,
            'grupo_id' => $grupo_id,
            'adscripcion_id' => $adscripcion_id,
            'sede_id' => $sede_id,
            'generacion_id' => $generacion_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_terminacion' => $fecha_terminacion,
            'id_inscripcion' => $id_inscripcion,
            
            'fecha_validacion_inicial' => $fecha_validacion_inicial,
            'fecha_validacion_final' => $fecha_validacion_final,
            'fecha_de_ejecucion_inicial' => $fecha_de_ejecucion_inicial,
            'fecha_de_ejecucion_final' => $fecha_de_ejecucion_final
        ];
        //dd($data2);
        $this->dispatch('actualizarcurso',$data2);
        //Envia evento a StudentForm disparando función editCourse()
    }

    public function unsubscribeStudent($idEstudiante,$verDetalles="false"){
        //dd($idEstudiante);
        $dataUnsubscribeStudent = [
            'idEstudiante' => $idEstudiante,
            'verDetalles' => $verDetalles
        ];
        $this->dispatch('dardebaja', $dataUnsubscribeStudent);
        //Envia evento a StudentForm disparando función darDeBajaAlumno()
    }
    
    public function resetForm()
    {
        $this->reset([
            'student',
            
            'id_estudiante', 'nombre1', 'nombre2', 'apellido1', 'apellido2',
            'municipio_procedencia', 'curp', 'fecha_nacimiento', 'id_escolaridad', 'genero', 'correo_electronico','celular',
            'matricula_cuip', // Resetear matricula_cuip
            
        ]);
    }

    
    public function render()
    {
                  
        return view('livewire.update-modal');
    }



}
