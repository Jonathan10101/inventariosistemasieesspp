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
use Illuminate\Support\Number;

use App\Models\Resguardo;
use Carbon\Carbon;

use App\Models\HistorialResguardo;



class AddNewResguardo extends Component
{
    use WithFileUploads;
    public $marcas,$estadosdeuso,$areasdeasignacion,$ubicacionesifiscas,$resguardantes,$puestos;
   
    public $descripcion,$marca_id,$modelo,$nserie,$nresguardo,
    $estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id,$resguardante_id,$puesto_id,$resguardante;

    public $resguardo_id,$resguardo_pdf,$fecha_asignacion,$fecha_liberacion;

     public $showAdditionalFields = false;
    public $showModal = true; 
    public $imagen;  
    public $imagenBase64; // foto capturada desde JS
    public $usarCamara = true; // alternar entre cámara y PC
    public $tomadaDesdeCamara = true;
    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $resguardo;
    public $imagenSeleccionada = null;


    
    public function mount($data){
        $this->resguardo = Resguardo::find($data);

        
        if ($this->resguardo) {
            $this->imagenGuardada = $this->resguardo->imagen; // Ruta guardada
            $this->descripcion = $this->resguardo->descripcion;
            $this->modelo = $this->resguardo->modelo;
            $this->marca_id = $this->resguardo->marca_id;
            $this->nserie = $this->resguardo->nserie;
            $this->area_de_uso_id = $this->resguardo->area_de_uso_id;
            $this->ubicacion_fisicas_id = $this->resguardo->ubicacion_fisicas_id;
            $this->resguardante = $this->resguardo->resguardante;
            
            $this->resguardo_id = $this->resguardo->id;
            //$this->resguardante_id = $this->resguardante->id;

        }



        $this->ubicacionesifiscas  = UbicacionFisica::all();
        $this->resguardantes = Resguardante::where('id', '!=',$this->resguardante_id)->get();

        //dd($x);
        $this->puestos = Puesto::all();
        $this->marcas = Marca::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->ubicacionesfisicas = UbicacionFisica::all();

    }

    public function updatedUbicacionFisicasId($value)
    {
        if (!$value) {
            $this->imagenSeleccionada = null;
            return;
        }

        $ubicacion = UbicacionFisica::find($value);
        $this->imagenSeleccionada = $ubicacion?->imagen;
    }
    
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



   
    public function save()
    {
        $this->validate([
            'descripcion' => 'required',
            'marca_id' => 'required',
            'modelo' => 'required',
            'nserie' => 'required',
            'estado_uso_id' => 'required',
            'area_de_uso_id' => 'required',
            'ubicacion_fisicas_id' => 'required',
            'resguardante_id' => 'required',
            'puesto_id' => 'required',
            //'imagen' => 'image|max:6144',
            'imagen' => $this->imagenBase64 ? 'nullable' : 'required|image|max:2048',
            'resguardo_pdf' => 'mimes:pdf|max:8192', // 4MB máx
            //'resguardo_pdf' => 'nullable|mimes:pdf|max:1080', // 4MB máx
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
        $imagenEvidencia = $this->imagen 
            ? $this->imagen->store('resguardos', 'public')
            : null;

        $pdfPath = $this->resguardo_pdf 
            ? $this->resguardo_pdf->store('resguardos/pdf', 'public')
            : null;


        $this->fecha_asignacion = now();


        
        $resguardo = Resguardo::find($this->resguardo_id);

        $ultimoHistorial = $resguardo->historial()->get()->last();

        if ($ultimoHistorial) {
            $ultimoHistorial->update([
                'fecha_liberacion' => now()
            ]);
        }



        $resguardo->historial()->create([
            'resguardo_id'=> $this->resguardo_id,
            'resguardante_id' => $this->resguardante_id,
            'resguardo_pdf' => $this->resguardo_pdf ,
            'fecha_asignacion' => now(),
            'fecha_liberacion' => null,
            'imagen_evidencia' => $imagenEvidencia, // ← aquí guardas la foto o evidencia
            'tipo_evento'       => 'asignacion',
            'descripcion_evento'=> 'Equipo asignado al resguardante.',
            'estado_uso_id' => $this->estado_uso_id,
            'area_de_uso_id' => $this->area_de_uso_id,
            'ubicacion_fisicas_id' => $this->ubicacion_fisicas_id,
        ]);







        //HistorialResguardo::registrarAsignacion($this->resguardo, $this->resguardante_id, $pdfPath,$imagenEvidencia);
        //HistorialResguardo::registrarAsignacion($this->resguardo, $this->resguardante_id, $pdfPath,$imagenEvidencia,$this->estado_uso_id,$this->area_de_uso_id,$this->ubicacion_fisicas_id);


        //$this->dispatch('saveFromComponentNewHistorialResguardo',$data);        
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
        return view('livewire.add-new-resguardo');
    }
}
