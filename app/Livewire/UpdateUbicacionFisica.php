<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use App\Models\UbicacionFisica;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;


class UpdateUbicacionFisica extends Component
{
    
    use WithFileUploads;
    public $ubicacionfisica,$imagen,$id_ubicacion_fisica;

    protected function rules()
    {
        return [
    'ubicacionfisica' => [
            'required',
            'min:2',
            'max:150',
            Rule::unique('ubicacion_fisicas', 'descripcion')->ignore($this->id_ubicacion_fisica),
        ],
        'imagen' => $this->imagen instanceof TemporaryUploadedFile
            ? 'image|mimes:jpg,jpeg,png|max:4096'
            : 'nullable',
        ];
    }

    public function mount($data){     
        $ubicacionFisicaBusqueda =   UbicacionFisica::find($data);
        $this->ubicacionfisica = $ubicacionFisicaBusqueda->descripcion; 
        $this->id_ubicacion_fisica = $ubicacionFisicaBusqueda->id; 
        $this->imagen = $ubicacionFisicaBusqueda->imagen;
    }

    public function save()
    {
        // Normalizar texto
        $this->ubicacionfisica = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->ubicacionfisica)));
        $this->validate();

        // Verificar duplicados
        $ubicacionFisicaComparacion = str_replace(' ', '', $this->ubicacionfisica);
        $existe = UbicacionFisica::whereRaw("REPLACE(descripcion, ' ', '') = ?", [$ubicacionFisicaComparacion])
            ->where('id', '!=', $this->id_ubicacion_fisica)
            ->exists();

        if ($existe) {
            $this->addError('ubicacionfisica', 'Esta ubicación física ya existe aunque escrito diferente.');
            return;
        }

        // Imagen actual (la que estaba antes)
        $imagenAnterior = $this->imagen_actual ?? null; // Puedes tener esta propiedad si guardas la ruta anterior
        $path = $imagenAnterior;

        // Si se sube una nueva imagen, la reemplazamos
        if ($this->imagen instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            // Borrar la imagen anterior si existe
            if ($imagenAnterior && \Storage::disk('public')->exists($imagenAnterior)) {
                \Storage::disk('public')->delete($imagenAnterior);
            }

            // Guardar la nueva imagen
            $path = $this->imagen->store('ubicaciones', 'public');
        }

        // Si no se sube nada y no había imagen anterior, queda null
        if (!$path) {
            $path = null;
        }

        // Datos finales
        $data = [
            'id' => $this->id_ubicacion_fisica,
            'descripcion' => $this->ubicacionfisica,
            'imagen' => $path,
        ];

        // dd($data); // Para revisar

        $this->dispatch('saveUpdateUbicacionFisicaFromAnotherComponent', $data);
        $this->resetForm();
    }




    public function resetForm()
    {
        $this->reset(['ubicacionfisica','imagen','id_ubicacion_fisica']);
    }

    public function render()
    {
        return view('livewire.update-ubicacion-fisica');
    }
}
