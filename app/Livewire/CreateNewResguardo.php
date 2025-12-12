<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\{
    Marca,
    EstadoUso,
    AreaDeUso,
    UbicacionFisica,
    Resguardante,
    Puesto,
    Resguardo,
    HistorialResguardo,
    User
};

class CreateNewResguardo extends Component
{
    use WithFileUploads;

    /* =================== VARIABLES =================== */
    public $marcas, $estadosdeuso, $areasdeasignacion, $ubicacionesifiscas, $resguardantes, $puestos;

    public $descripcion, $cantidad, $marca_id, $modelo, $nserie, $nresguardo,
           $estado_uso_id, $area_de_uso_id, $ubicacion_fisicas_id,
           $resguardante_id, $puesto_id;

    public $imagen;
    public $imagenBase64;
    public $usarCamara = true;
    public $tomadaDesdeCamara = true;
    public $resguardo_pdf;
    public $showAdditionalFields = false;

    protected $listeners = ['resetImagenes' => 'resetImagenes'];
    public $imagenSeleccionada = null;


    /* =================== CICLO DE VIDA =================== */
    public function mount()
    {
        $this->marcas = Marca::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->ubicacionesifiscas = UbicacionFisica::all();
        $this->puestos = Puesto::all();


        if (auth()->user()->email == "subdesarrollopolicial@ieesspp.com") {
            $userIds = User::where("subdireccion", "LIKE", "SUBDIRECCIÓN DE DESARROLLO POLICIAL")
                        ->pluck('id');
            $this->resguardantes = Resguardante::whereIn('user_id', $userIds)->get();
        }else if (auth()->user()->email == "subcoordinacion@ieesspp.com") {
            $userIds = User::where("subdireccion", "LIKE", "SUBDIRECCIÓN DE COORDINACIÓN E INFRAESTRUCTURA INSTITUCIONAL")
                        ->pluck('id');
            $this->resguardantes = Resguardante::whereIn('user_id', $userIds)->get();
        }else{
            $this->resguardantes = Resguardante::all();
        }

    }

    /* =================== MÉTODOS =================== */

    public function resetImagenes()
    {
        $this->imagen = null;
        $this->imagenBase64 = null;
    }

public function updatedResguardanteId($value)
{
    if ($value) {
        $resguardante = Resguardante::find($value);
        $this->puesto_id = $resguardante->puesto_id ?? null;
    } else {
        $this->puesto_id = null;
    }
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
    

    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }

    public function updatedImagen()
    {
        $this->imagenBase64 = null; // limpiar si se sube desde PC
    }

    /* =================== GUARDADO PRINCIPAL =================== */
    public function save()
    {
        $this->validate([
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'nullable|integer|min:1|max:500',
            'marca_id' => 'required|exists:marcas,id',
            'modelo' => 'nullable|string|max:255',
            'nserie' => [
                'nullable',
                'string',
                Rule::unique('resguardos', 'nserie')
                    ->where(function ($query) {
                        return $this->nserie !== 'N/A';
                    })
            ],
            'estado_uso_id' => 'required|exists:estado_uso,id',
            'area_de_uso_id' => 'required|exists:area_de_uso,id',
            'ubicacion_fisicas_id' => 'required|exists:ubicacion_fisicas,id',
            'resguardante_id' => 'required|exists:resguardantes,id',
            //'imagen' => $this->imagenBase64 ? 'nullable' : 'required|image|max:4096',
            'imagen' => 'nullable|image|max:4096',
            //'resguardo_pdf' => 'nullable|mimes:pdf|max:8192',
            'resguardo_pdf' => 'required|mimes:pdf|max:8192',
        ]);

        $this->cantidad = (int)$this->cantidad;
        if($this->cantidad == null){
            $this->cantidad = 1;
        }
        
        /* === Procesar imagen base64 (foto tomada desde cámara) === */
        if ($this->imagenBase64) {
            $fileData = explode(',', $this->imagenBase64)[1];
            $fileName = 'resguardo_' . Str::random(8) . '.png';
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

        /* === Guardar archivos === */
        $pathImagen = $this->imagen ? $this->imagen->store('resguardos', 'public') : null;
        $imagenEvidencia = $pathImagen;
        $pathPdf = $this->resguardo_pdf ? $this->resguardo_pdf->store('resguardos/pdf', 'public') : null;

        // si el usuario deja vacío el número de serie → poner "N/A"
        $nserie = trim($this->nserie);
        if ($nserie === '' || $nserie === null) {
            $nserie = 'N/A';
        }

        $modelo = trim($this->modelo);
        if ($modelo === '' || $modelo === null) {
            $modelo = 'N/A';
        }

        $resguardante = Resguardante::find($this->resguardante_id);
        $puesto_id = $resguardante->puesto_id;
        if($resguardante->puesto_id == null){
            $puesto_id = 1;
        }

        //dd($puesto_id);

        //dd((int)$this->cantidad);

        /* === Crear Resguardo === */
        $resguardo = Resguardo::create([
            'descripcion' => $this->descripcion,
            'cantidad' => $this->cantidad,
            'marca_id' => $this->marca_id,
            'modelo' => $modelo,
            'nserie' => $nserie,   // ← aquí ya va "N/A" si estaba vacío
            'resguardante_id' => $this->resguardante_id,
            'puesto_id' => $puesto_id,
            'imagen' => $pathImagen,
            'estado_actual' => 'asignado', // nuevo resguardo siempre inicia asignado
        ]);

        /* === Generar número de resguardo === */
        $resguardo->update(['nresguardo' => $resguardo->id]);

        //dd($resguardo);

        /* === Registrar historial de asignación === */
        HistorialResguardo::registrarAsignacion($resguardo, $this->resguardante_id, $pathPdf,$imagenEvidencia,$this->estado_uso_id,$this->area_de_uso_id,$this->ubicacion_fisicas_id);

        /* === Reset del formulario === */
        $this->resetForm();

        /* === Emitir evento al padre === */
        $this->dispatch('resguardoCreado');
        //session()->flash('message', 'Resguardo creado correctamente.');
    }

    /* =================== RESETEAR FORMULARIO =================== */
    public function resetForm()
    {
        $this->reset([
            'descripcion', 'cantidad', 'marca_id', 'modelo', 'nserie', 'nresguardo',
            'estado_uso_id', 'area_de_uso_id', 'ubicacion_fisicas_id',
            'resguardante_id', 'puesto_id', 'imagen', 'imagenBase64',
            'resguardo_pdf', 'tomadaDesdeCamara'
        ]);
    }

    /* =================== VISTA =================== */
    public function render()
    {
        return view('livewire.create-new-resguardo');
    }
}
