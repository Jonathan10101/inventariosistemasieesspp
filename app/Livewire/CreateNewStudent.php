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
    public $descripcion,$marca_id,$modelo,$nserie,$nresguardo,
    $estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id,$resguardante_id,$puesto_id;    
    
    /*
    protected $rules = [
        'descripcion' => 'required',
        'marca_id' => 'required',
        'modelo' => 'required',
        'nserie' => 'required',
        'nresguardo' => 'required',
        'estado_uso_id' => 'required',
        'area_de_uso_id' => 'required',
        'ubicacion_fisicas_id' => 'required',
        'resguardante_id' => 'required',
        'puesto_id' => 'required'                               
    ];
    */
        
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

        
        $this->validate([
        'descripcion' => 'required',
        'marca_id' => 'required',
        'modelo' => 'required',
    'nserie' => 'required|unique:resguardo,nserie',
        'estado_uso_id' => 'required',
        'area_de_uso_id' => 'required',
        'ubicacion_fisicas_id' => 'required',
        'resguardante_id' => 'required',
        'puesto_id' => 'required' 

        ]);// Validamos los datos
        $data = [
            'descripcion' => $this->descripcion,
            'marca_id' => $this->marca_id,
            'modelo' => $this->modelo,
            'nserie' => $this->nserie,
            'nresguardo' => null,
            'estado_uso_id' => $this->estado_uso_id,
            'area_de_uso_id' => $this->area_de_uso_id,
            'ubicacion_fisicas_id' => $this->ubicacion_fisicas_id,
            'resguardante_id' => $this->resguardante_id,            
            'puesto_id' => $this->puesto_id,
        ];
        //dd($data);     
        
        
        $this->dispatch('saveFromComponentNewStudent',$data);        
        $this->resetForm(); // Limpia las propiedades del formulario  
    }

    public function resetForm()
    {
        $this->reset([
            'descripcion','marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id', 'resguardante_id', 'puesto_id'
        ]);
    }

        
    public function render()
    {        
        return view('livewire.create-new-student');  
    }
    
}
