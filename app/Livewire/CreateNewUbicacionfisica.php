<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UbicacionFisica;
use Livewire\WithFileUploads;


class CreateNewUbicacionfisica extends Component
{
    use WithFileUploads;
    public $ubicacionfisica,$imagen;

    protected $rules = [
        'ubicacionfisica' => 'required|min:2|max:150|unique:ubicacion_fisicas,descripcion',
        'imagen' => 'nullable|image|max:2048', // máximo 2MB
    ];

    public function save(): void
    {
        app(\App\Services\TenantDatabaseStorage::class)->assertCanWrite();

        $this->ubicacionfisica = preg_replace(
            '/\s+/',
            ' ',
            trim(mb_strtoupper($this->ubicacionfisica, 'UTF-8'))
        );

        $this->validate();

        $ubicacionfisicaComparacion = str_replace(
            ' ',
            '',
            $this->ubicacionfisica
        );

        $existe = UbicacionFisica::whereRaw(
            "REPLACE(descripcion, ' ', '') = ?",
            [$ubicacionfisicaComparacion]
        )->exists();

        if ($existe) {
            $this->addError(
                'ubicacionfisica',
                'Esta ubicación física ya existe aunque esté escrita diferente.'
            );

            return;
        }

        $path = null;

        if ($this->imagen) {
            // No convertir esta ruta a mayúsculas.
            $path = $this->imagen->store('ubicaciones', 'public');
        }

        $data = [
            'descripcion' => $this->ubicacionfisica,
            'imagen' => $path,
        ];

        $this->dispatch(
            'saveFromComponentNewUbicacionFisica',
            data: $data
        );

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'ubicacionfisica'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-ubicacionfisica');
    }
}
