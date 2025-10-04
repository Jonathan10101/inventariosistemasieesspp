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
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;




class CreateNewStudent extends Component
{
    use WithFileUploads;
    public $marcas,$estadosdeuso,$areasdeasignacion,$ubicacionesifiscas,$resguardantes,$puestos;
    public $showAdditionalFields = false;
    public $showModal = true; 
    public $descripcion,$marca_id,$modelo,$nserie,$nresguardo,
    $estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id,$resguardante_id,$puesto_id;  
    public $imagen;  
    public $imagenBase64; // foto capturada desde JS
    public $usarCamara = true; // alternar entre cámara y PC
    public $tomadaDesdeCamara = true;
    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $resguardo_pdf;



    
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

    public function resetImagenes()
{
    $this->imagen = null;
    $this->imagenBase64 = null;
}
        
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


public function updatedImagen()
{
    // Aquí entra cada vez que se selecciona un archivo nuevo
    $this->imagenBase64 = null; // limpiar la otra opción
    $this->imagenFinal = $this->imagen; // asignar lo último cargado
}



   
    public function save()
    {
        $this->validate([
            'descripcion' => 'required',
            'marca_id' => 'required',
            'modelo' => 'required',
            'nserie' => 'required|unique:resguardo,nserie',
            'estado_uso_id' => 'required',
            'area_de_uso_id' => 'required',
            'ubicacion_fisicas_id' => 'required',
            'resguardante_id' => 'required',
            'puesto_id' => 'required',
            'imagen' => 'image|max:2048',
            'resguardo_pdf' => 'mimes:pdf|max:4096', // 4MB máx

        ]);

        // Si hay base64 (foto de cámara), convertir a UploadedFile
        if ($this->imagenBase64) {
            $fileData = explode(',', $this->imagenBase64)[1];
            $fileName = 'resguardo_' . Str::random(5) . '.png';
            $tempPath = sys_get_temp_dir() . '/' . $fileName;
            file_put_contents($tempPath, base64_decode($fileData));

            $this->imagen = new UploadedFile(
                $tempPath,
                $fileName,
                'image/png',
                null,
                true
            );
        }

        // Solo si hay imagen, la guardamos
        $path = $this->imagen 
            ? $this->imagen->store('resguardos', 'public')
            : null;

        $pdfPath = $this->resguardo_pdf 
            ? $this->resguardo_pdf->store('resguardos/pdf', 'public')
            : null;

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
            'imagen' => $path,
            'resguardo_pdf' => $pdfPath,
        ];

        $this->dispatch('saveFromComponentNewStudent',$data);        
        $this->resetForm();
    }


    public function resetForm()
    {
        $this->reset([
            'imagen','descripcion','marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id', 'resguardante_id', 'puesto_id','tomadaDesdeCamara','imagenBase64'
        ]);
    }

        
    public function render()
    {        
        return view('livewire.create-new-student');  
    }
    
}
