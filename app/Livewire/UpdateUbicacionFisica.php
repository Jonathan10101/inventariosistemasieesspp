<?php

namespace App\Livewire;

use App\Models\UbicacionFisica;
use App\Services\ImageCompressor;
use App\Services\TenantDatabaseStorage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateUbicacionFisica extends Component
{
    use WithFileUploads;

    public $ubicacionfisica;

    /*
    |--------------------------------------------------------------------------
    | Nueva imagen
    |--------------------------------------------------------------------------
    |
    | Esta propiedad solamente contiene el archivo nuevo seleccionado.
    |
    */
    public $imagen = null;

    /*
    |--------------------------------------------------------------------------
    | Imagen actualmente guardada
    |--------------------------------------------------------------------------
    |
    | Esta propiedad contiene únicamente la ruta existente en la base.
    |
    */
    public ?string $imagenActual = null;

    public $id_ubicacion_fisica;

    protected function rules(): array
    {
        return [
            'ubicacionfisica' => [
                'required',
                'string',
                'min:2',
                'max:150',

                Rule::unique(
                    'ubicacion_fisicas',
                    'descripcion'
                )->ignore(
                    $this->id_ubicacion_fisica
                ),
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
        ];
    }

    public function mount($data): void
    {
        $ubicacionFisica = UbicacionFisica::findOrFail(
            $data
        );

        $this->ubicacionfisica =
            $ubicacionFisica->descripcion;

        $this->id_ubicacion_fisica =
            $ubicacionFisica->id;

        /*
        |--------------------------------------------------------------------------
        | Conservar la ruta anterior
        |--------------------------------------------------------------------------
        |
        | No debes colocar esta ruta en $this->imagen porque esa propiedad se
        | utiliza para el archivo temporal nuevo.
        |
        */
        $this->imagenActual =
            $ubicacionFisica->imagen;

        $this->imagen = null;
    }

    public function save(): void
    {
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
        | Validar datos
        |--------------------------------------------------------------------------
        */
        $this->validate();

        /*
        |--------------------------------------------------------------------------
        | Verificar duplicados ignorando espacios
        |--------------------------------------------------------------------------
        */
        $ubicacionFisicaComparacion = str_replace(
            ' ',
            '',
            $this->ubicacionfisica
        );

        $existe = UbicacionFisica::whereRaw(
            "REPLACE(descripcion, ' ', '') = ?",
            [$ubicacionFisicaComparacion]
        )
            ->where(
                'id',
                '!=',
                $this->id_ubicacion_fisica
            )
            ->exists();

        if ($existe) {
            $this->addError(
                'ubicacionfisica',
                'Esta ubicación física ya existe aunque esté escrita diferente.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Comprobar almacenamiento
        |--------------------------------------------------------------------------
        */
        $incomingBytes = $this->imagen
            ? (int) $this->imagen->getSize()
            : 0;

        app(TenantDatabaseStorage::class)
            ->assertCanWrite($incomingBytes);
        /*
        |--------------------------------------------------------------------------
        | Mantener imagen anterior
        |--------------------------------------------------------------------------
        |
        | Si el usuario no selecciona otra imagen, se enviará la ruta existente.
        |
        */
        $path = $this->imagenActual;

        /*
        |--------------------------------------------------------------------------
        | Comprimir imagen nueva
        |--------------------------------------------------------------------------
        |
        | Este componente posee el archivo temporal, por eso la compresión debe
        | realizarse aquí y no en el componente receptor.
        |
        */
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
        | Enviar solamente datos y ruta
        |--------------------------------------------------------------------------
        */
        $data = [
            'id' => $this->id_ubicacion_fisica,
            'descripcion' => $this->ubicacionfisica,
            'imagen' => $path,
        ];

        $this->dispatch(
            'saveUpdateUbicacionFisicaFromAnotherComponent',
            data: $data
        );

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset([
            'ubicacionfisica',
            'imagen',
            'imagenActual',
            'id_ubicacion_fisica',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view(
            'livewire.update-ubicacion-fisica'
        );
    }
}