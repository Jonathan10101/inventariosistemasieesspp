<?php

namespace App\Livewire;

use App\Models\UbicacionFisica;
use App\Services\ImageCompressor;
use App\Services\TenantDatabaseStorage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewUbicacionfisica extends Component
{
    use WithFileUploads;

    public $ubicacionfisica;
    public $imagen;

    protected $rules = [
        'ubicacionfisica' => [
            'required',
            'min:2',
            'max:150',
            'unique:ubicacion_fisicas,descripcion',
        ],

        'imagen' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ];

    public function save(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Comprobar espacio disponible
        |--------------------------------------------------------------------------
        */
        $incomingBytes = $this->imagen
            ? (int) $this->imagen->getSize()
            : 0;

        app(TenantDatabaseStorage::class)
            ->assertCanWrite($incomingBytes);

        /*
        |--------------------------------------------------------------------------
        | Normalizar descripción
        |--------------------------------------------------------------------------
        */
        $this->ubicacionfisica = preg_replace(
            '/\s+/',
            ' ',
            trim(
                mb_strtoupper(
                    (string) $this->ubicacionfisica,
                    'UTF-8'
                )
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Validar formulario
        |--------------------------------------------------------------------------
        */
        $this->validate();

        /*
        |--------------------------------------------------------------------------
        | Comprobar duplicados ignorando espacios
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Comprimir y guardar imagen
        |--------------------------------------------------------------------------
        |
        | La imagen se procesa aquí porque este componente es el que realmente
        | posee el archivo temporal de Livewire.
        |
        */
        $path = null;

        if ($this->imagen) {
            $imageCompressor = app(
                ImageCompressor::class
            );

            $path = $imageCompressor->store(
                file: $this->imagen,
                directory: 'ubicaciones',
                disk: 'public',
                maxWidth: 1600,
                maxHeight: 1600,
                quality: 70
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Enviar solamente la ruta
        |--------------------------------------------------------------------------
        */
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

    public function resetForm(): void
    {
        $this->reset([
            'ubicacionfisica',
            'imagen',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view(
            'livewire.create-new-ubicacionfisica'
        );
    }
}