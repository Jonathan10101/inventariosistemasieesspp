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
            ? 'image|mimes:jpg,jpeg,png|max:2048'
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
        $this->ubicacionfisica = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->ubicacionfisica)));
        $this->validate();

        $ubicacionFisicaComparacion = str_replace(' ', '', $this->ubicacionfisica);

        $existe = UbicacionFisica::whereRaw("REPLACE(descripcion, ' ', '') = ?", [$ubicacionFisicaComparacion])
            ->where('id', '!=', $this->id_ubicacion_fisica)
            ->exists();

        if ($existe) {
            $this->addError('ubicacionfisica', 'Esta ubicación física ya existe aunque escrito diferente.');
            return;
        }

        $path = null;
        if ($this->imagen instanceof TemporaryUploadedFile) {
            $path = $this->imagen->store('ubicaciones', 'public');
        }

        $data = [
            'id' => $this->id_ubicacion_fisica,
            'descripcion' => $this->ubicacionfisica,
            'imagen' => $path
        ];

        //dd($data);

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
