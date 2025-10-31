<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Models\{
    Marca,
    EstadoUso,
    AreaDeUso,
    UbicacionFisica,
    Resguardante,
    Puesto,
    Resguardo,
    HistorialResguardo
};

class CreateNewResguardo extends Component
{
    use WithFileUploads;

    /* =================== VARIABLES =================== */
    public $marcas, $estadosdeuso, $areasdeasignacion, $ubicacionesifiscas, $resguardantes, $puestos;

    public $descripcion, $marca_id, $modelo, $nserie, $nresguardo,
           $estado_uso_id, $area_de_uso_id, $ubicacion_fisicas_id,
           $resguardante_id, $puesto_id;

    public $imagen;
    public $imagenBase64;
    public $usarCamara = true;
    public $tomadaDesdeCamara = true;
    public $resguardo_pdf;
    public $showAdditionalFields = false;

    protected $listeners = ['resetImagenes' => 'resetImagenes'];

    /* =================== CICLO DE VIDA =================== */
    public function mount()
    {
        $this->marcas = Marca::all();
        $this->areasdeasignacion = AreaDeUso::all();
        $this->estadosdeuso = EstadoUso::all();
        $this->ubicacionesifiscas = UbicacionFisica::all();
        $this->resguardantes = Resguardante::all();
        $this->puestos = Puesto::all();
    }

    /* =================== MÉTODOS =================== */

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
        $this->imagenBase64 = null; // limpiar si se sube desde PC
    }

    /* =================== GUARDADO PRINCIPAL =================== */
    public function save()
    {
        $this->validate([
            'descripcion' => 'required|string|max:255',
            'marca_id' => 'required|exists:marcas,id',
            'modelo' => 'required|string|max:255',
            'nserie' => 'required|string|unique:resguardos,nserie',
            'estado_uso_id' => 'required|exists:estado_uso,id',
            'area_de_uso_id' => 'required|exists:area_de_uso,id',
            'ubicacion_fisicas_id' => 'required|exists:ubicacion_fisicas,id',
            'resguardante_id' => 'required|exists:resguardantes,id',
            'puesto_id' => 'required|exists:puestos,id',
            'imagen' => $this->imagenBase64 ? 'nullable' : 'required|image|max:4096',
            //'resguardo_pdf' => 'nullable|mimes:pdf|max:8192',
            'resguardo_pdf' => 'mimes:pdf|max:8192',
        ]);

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

        /* === Crear Resguardo === */
        $resguardo = Resguardo::create([
            'descripcion' => $this->descripcion,
            'marca_id' => $this->marca_id,
            'modelo' => $this->modelo,
            'nserie' => $this->nserie,
            'resguardante_id' => $this->resguardante_id,
            'puesto_id' => $this->puesto_id,
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
        session()->flash('message', 'Resguardo creado correctamente.');
    }

    /* =================== RESETEAR FORMULARIO =================== */
    public function resetForm()
    {
        $this->reset([
            'descripcion', 'marca_id', 'modelo', 'nserie', 'nresguardo',
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
