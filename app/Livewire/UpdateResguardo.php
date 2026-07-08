<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Marca;
use App\Models\EstadoUso;
use App\Models\AreaDeUso;
use App\Models\UbicacionFisica;
use App\Models\Resguardante;
use App\Models\Puesto;
use Illuminate\Validation\Rule;

use App\Models\Cursos;
use App\Models\Grupos;
use App\Models\Sedes;
use App\Models\Adscripciones;
use App\Models\Generaciones;
use App\Models\Escolaridad;
use App\Models\Municipio;
use App\Models\Estudiante;
use App\Livewire\Forms\StudentCreateForm;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Models\Resguardo;
use Illuminate\Support\Facades\Storage;


class UpdateResguardo extends Component
{
    use WithFileUploads;
    public $marcas,$estadosdeuso,$areasdeasignacion,$ubicacionesifiscas,$resguardantes,$puestos;
   
    public $descripcion,$marca_id,$modelo,$nserie,$nresguardo,
    $estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id,$resguardante_id,$puesto_id;  

    public $showAdditionalFields = false;
    public $showModal = true; 
    public $imagen;  
    public $imagenBase64; // foto capturada desde JS
    public $usarCamara = true; // alternar entre cámara y PC
    public $tomadaDesdeCamara = true;
    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $resguardo_pdf;
    public $resguardo_id;
    public $historial_resguardo_id;
    //public $institucion;

    public $edit_password = '';
    public $canEditResguardante = false;

    public $ubicacion_img_url = null;



    public function mount($data){
        
     
        $resguardo = Resguardo::find($data);
        $this->historial_resguardo_id = $resguardo->historial->last()->id;
        $this->resguardo_id = $resguardo->id;
        if ($resguardo) {
            $this->imagenGuardada = $resguardo->imagen; // Ruta guardada
        }
        $this->descripcion = $resguardo->descripcion;
        $this->marca_id = $resguardo->marca_id;
        $this->modelo = $resguardo->modelo;
        $this->nserie = $resguardo->nserie;
        $this->estado_uso_id = $resguardo->estado_uso_id;
        $this->area_de_uso_id = $resguardo->historial->last()->area_de_uso_id;
        $this->ubicacion_fisicas_id = $resguardo->historial->last()->ubicacion_fisicas_id;
        $this->resguardante_id = $resguardo->resguardante_id;
        $this->puesto_id = $resguardo->puesto_id;
        $this->resguardo_pdf = $resguardo->resguardo_pdf;


        $this->ubicacionesifiscas  = UbicacionFisica::all();
        $this->resguardantes = Resguardante::all();
        $this->puestos = Puesto::all();
        $this->marcas = Marca::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->areasdeasignacion = AreaDeUso::all();
        //$this->institucion = $resguardo->institucion;
    }

    /*
    public function updatedUbicacionFisicasId($value)
    {
        $this->ubicacion_img_url = null;

        if (!$value) return;

        $u = UbicacionFisica::find($value);
        //dd($u);

        // Cambia "imagen" por el nombre real de tu campo en la tabla
        if ($u && $u->imagen) {
            $this->ubicacion_img_url = Storage::url($u->imagen);
        }
    }
    */
    
    public function resetImagenes()
    {
        $this->imagen = null;
        $this->imagenBase64 = null;
    }
    
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }


    public function updatedImagen()
    {
        // Aquí entra cada vez que se selecciona un archivo nuevo
        $this->imagenBase64 = null; // limpiar la otra opción
        $this->imagenFinal = $this->imagen; // asignar lo último cargado
    }

    public function updatedEditPassword($value)
    {
        // Cambia esto por tu contraseña o mejor por config/env
        $this->canEditResguardante = ($value === 'adminJBH$');
    }

    public function save()
    {
        $this->validate([
            'descripcion' => 'required',
            'marca_id' => 'required',
            'modelo' => 'required',
            'area_de_uso_id' => 'required',
            'ubicacion_fisicas_id' => 'required',
            'nserie' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (strtoupper(trim($value)) === 'N/A') return;

                    $existe = \App\Models\Resguardo::where('nserie', $value)
                        ->where('id', '!=', $this->resguardo_id) // ID del que estás editando
                        ->exists();

                    if ($existe) {
                        $fail('El número de serie ya existe.');
                    }
                },
            ],
            //'institucion' => 'required',
        ]);
        
        $resguardante = Resguardante::find($this->resguardante_id);
        $puesto_id = $resguardante->puesto_id;
        if($resguardante->puesto_id == null){
            $puesto_id = 1;
        }

        $data = [
            'descripcion' => $this->descripcion,
            'marca_id' => $this->marca_id,
            'modelo' => $this->modelo,
            'area_de_uso_id' => $this->area_de_uso_id,
            'ubicacion_fisicas_id' => $this->ubicacion_fisicas_id,
            'resguardo_id' => $this->resguardo_id,
            'resguardante_id' => $this->resguardante_id,
            'puesto_id' => $puesto_id,
            'historial_resguardo_id' => $this->historial_resguardo_id,
            'nserie' => $this->nserie,
            //'institucion' => $this->institucion,
        ];
               //dd($data);
        //dd($data);
        $this->dispatch('updateUbicacionFromComponentResguardo',$data);        
        $this->resetForm();
    }


    public function resetForm()
    {
        $this->reset([
            'imagen','descripcion','marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id', 'resguardante_id', 'puesto_id','tomadaDesdeCamara','imagenBase64',
        ]);
    }

    public function render()
    {
        return view('livewire.update-resguardo');
    }
}
