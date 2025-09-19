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
use App\Livewire\Forms\StudentCreateForm;


class CreateNewStudent extends Component
{

    public $nombre1,$nombre2,$apellido1,$apellido2,$matricula_cuip,$cuip,$municipio_procedencia,$curp,$fecha_nacimiento,$id_escolaridad,
    $id_adscripcion,$genero,$correo_electronico,$celular;
    public $cursos,$escolaridades,$municipios,$sedes,$grupos,$adscripciones,$inscripciones,$generacionesv2;
    public $showAdditionalFields = false;
    public $showModal = true; 
    //public StudentCreateForm $sudentCreates;
            
    protected $rules = [
        'nombre1' => 'required|string|max:255',
        'apellido1' => 'required|string|max:255',
        //'municipio_procedencia' => 'required|exists:municipios,id',
        'curp' => 'required|string|size:18|unique:estudiantes,curp',
        'fecha_nacimiento' => 'required',
        'id_escolaridad' => 'required|exists:escolaridad,id',
        'genero' => 'required|in:M,H',                
        //'generacion_id' => 'required|exists:generaciones,id', // Validar que exista en la tabla generaciones
        'celular' => 'required|string|size:10|unique:estudiantes,celular', // Validar que sea un número de 10 dígitos         
        'correo_electronico' => 'required',
        'matricula_cuip' => 'required|unique:estudiantes,matricula_cuip|min:20|max:20', // Aseguramos que sea único
        //'cuip' => 'required|unique:estudiantes,cuip|min:18|max:18'
        
    ];
        
    public function mount()
    {
        $this->escolaridades = Escolaridad::all();
        $this->municipios = Municipio::all();
        $this->cursos = Cursos::all();
        $this->grupos = Grupos::all();
        $this->sedes = Sedes::all();
        $this->adscripciones = Adscripciones::all();
        $this->generacionesv2 = Generaciones::all();        
    }
    
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }

    /*
    private function generateMatricula()
    {
        do {
            // Generar una clave única de 20 caracteres
            $matricula = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 20));
        } while (Estudiante::where('matricula_cuip', $matricula)->exists()); // Verificar que no se repita
        
        return $matricula;
    }
    */

    private function generateMatricula()
    {
        // Obtener los primeros 4 números del año actual
        $yearPrefix = substr(date("Y"), 0, 4);

        do {
            // Generar una clave única de 16 caracteres (descontando los 4 del año)
            $matricula = strtoupper($yearPrefix . substr(md5(uniqid(mt_rand(), true)), 0, 16));
        } while (Estudiante::where('matricula_cuip', $matricula)->exists()); // Verificar que no se repita
    
        return $matricula;
    }


    private function generateCuip()
    {
        // Definir los caracteres que se utilizarán (letras y números)
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        do {
            // Generar un CUIP de 18 caracteres aleatorios
            $cuip = '';
            for ($i = 0; $i < 18; $i++) {
                $cuip .= $characters[rand(0, strlen($characters) - 1)];
            }
    
            // Verificar si el CUIP ya existe en la base de datos
        } while (Estudiante::where('cuip', $cuip)->exists()); // Cambiar 'matricula_cuip' por el nombre correcto de la columna
    
        return $cuip;
    }
    

    


    public function save(){        
        if (!$this->matricula_cuip) {
            $this->matricula_cuip = $this->generateMatricula();
        }

        /*    
        if(!$this->cuip){
            $this->cuip = $this->generateCuip();
        }
        */

        //dd($this->cuip);

        //$this->sudentCreates->validate();
        $this->validate();// Validamos los datos

        $data = [
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'matricula_cuip' => $this->matricula_cuip,
            //'municipio_id' => $this->municipio_procedencia,
            //'municipio_id' => 1,
            'curp' => $this->curp,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'escolaridad_id' => $this->id_escolaridad,                
            'genero' => $this->genero,
            'correo_electronico' => $this->correo_electronico,
            'celular' => $this->celular,
            'cuip' => $this->cuip                            
        ];
            
        //$this->dispatch('notifyCloseModal');
        //Envia la data a StudentForm
        $this->dispatch('saveFromComponentNewStudent',$data);        
        $this->resetForm(); // Limpia las propiedades del formulario 
        //$this->showModal = false;   
    }

    public function resetForm()
    {
        $this->reset([
            'nombre1', 'nombre2', 'apellido1', 'apellido2',
            'curp', 'fecha_nacimiento', 'id_escolaridad', 'genero', 'correo_electronico','celular',
            'matricula_cuip','cuip' // Resetear matricula_cuip
            //'municipio_procedencia'
        ]);
    }

        
    public function render()
    {        
        return view('livewire.create-new-student');  
    }
    
}
