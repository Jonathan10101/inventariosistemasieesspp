<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marca;
use App\Models\EstadoUso;
use App\Models\AreaDeUso;
use App\Models\UbicacionFisica;
use App\Models\Resguardante;
use App\Models\Puesto;


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

    public $marcas,$estadosdeuso,$areasdeasignacion,$ubicacionesifiscas,$resguardantes,$puestos;
    public $showAdditionalFields = false;
    public $showModal = true; 
    public $descripcion,$marca,$modelo,$numerodeserie,$numeroderesguardo,
    $estadodeuso,$areadeasignacion,$ubicacionfisica,$resguardante,$puestodelresguardante;    
    
    
   
            
    protected $rules = [
        'descripcion' => 'required',
        'marca' => 'required',
        'modelo' => 'required',
        'numerodeserie' => 'required',
        'numeroderesguardo' => 'required',
        'estadodeuso' => 'required',
        'areadeasignacion' => 'required',
        'ubicacionfisica' => 'required',
        'resguardante' => 'required',
        'puestodelresguardante' => 'required',                               
    ];
        
    public function mount()
    {
        $this->marcas = Marca::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->ubicacionesifiscas = UbicacionFisica::all();
        $this->resguardantes = Resguardante::all();
        $this->puestos = Puesto::all();
    }
    
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }

   

    public function save(){       
        /* 
        if (!$this->matricula_cuip) {
            $this->matricula_cuip = $this->generateMatricula();
        }
        */   
        
        
        //$this->validate();// Validamos los datos
        $data = [
            'descripcion' => $this->descripcion,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'numerodeserie' => $this->numerodeserie,
            'numeroderesguardo' => $this->numeroderesguardo,
            'estadodeuso' => $this->estadodeuso,
            'areadeasignacion' => $this->areadeasignacion,
            'ubicacionfisica' => $this->ubicacionfisica,
            'resguardante' => $this->resguardante,            
            'puestodelresguardante' => $this->puestodelresguardante,            
        ];
        //dd($data);     
        
        
        $this->dispatch('saveFromComponentNewStudent',$data);        
        $this->resetForm(); // Limpia las propiedades del formulario  
    }

    public function resetForm()
    {
        $this->reset([
            'descripcion','marca', 'modelo', 'numerodeserie', 'numeroderesguardo',
            'estadodeuso', 'areadeasignacion', 'ubicacionfisica', 'resguardante', 'puestodelresguardante'
        ]);
    }

        
    public function render()
    {        
        return view('livewire.create-new-student');  
    }
    
}
