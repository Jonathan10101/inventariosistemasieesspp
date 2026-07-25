<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardante;
use App\Models\User;
use App\Models\Puesto;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class UpdateResguardante extends Component
{
    public $nombre1,$nombre2,$apellido1,$apellido2,$puesto_id,$resguardanteBusqueda,$id_resguardante,$email,$password;
    public $emailOriginal;
    public $passwordOriginal;
    public $puestos;
    protected $rules = [
        'nombre1' => 'required|min:2|max:50',
        'nombre2' => 'nullable|max:50',
        'apellido1' => 'required|min:2|max:50',
        'apellido2' => 'nullable|max:50',
        'email' => 'required|min:10|max:75',
        'password' => 'required|min:8|max:50',
    ];

    public function mount($data){   
        $resguardanteBusqueda = Resguardante::find($data);
        $resguardanteUserBusqueda = User::find($data);
        $this->nombre1 = $resguardanteBusqueda->nombre1; 
        $this->nombre2 = $resguardanteBusqueda->nombre2; 
        $this->apellido1 = $resguardanteBusqueda->apellido1; 
        $this->apellido2 = $resguardanteBusqueda->apellido2; 
        //dd($resguardanteBusqueda);
        $this->email = $resguardanteUserBusqueda->email;
        $this->id_resguardante = $resguardanteBusqueda->id;
        $this->puesto_id = $resguardanteBusqueda->puesto_id; 
        $this->puestos = Puesto::all();
    }


    public function save()
    {
        $this->nombre1 = trim(mb_strtolower((string) $this->nombre1));
        $this->nombre2 = trim(mb_strtolower((string) $this->nombre2));
        $this->apellido1 = trim(mb_strtolower((string) $this->apellido1));
        $this->apellido2 = trim(mb_strtolower((string) $this->apellido2));

        /*
        |--------------------------------------------------------------------------
        | Obtener el tenant actual
        |--------------------------------------------------------------------------
        |
        | ieesspp.intevi.app          -> ieesspp
        | ofertascreativas.intevi.app -> ofertascreativas
        |
        | También funciona localmente:
        | ieesspp.intevi.test -> ieesspp
        |
        */
        $host = request()->getHost();

        $nombreTenant = Str::before($host, '.');

        $nombreTenant = Str::lower(
            Str::slug($nombreTenant, '')
        );

        /*
        |--------------------------------------------------------------------------
        | Conservar solamente lo anterior al @
        |--------------------------------------------------------------------------
        |
        | juan.perez@correoanterior.com -> juan.perez
        | juan.perez                    -> juan.perez
        |
        */
        $nombreCorreo = Str::before(
            trim(mb_strtolower((string) $this->email)),
            '@'
        );

        /*
        * Si por alguna razón el correo llega vacío,
        * se genera utilizando el nombre completo.
        */
        if (empty($nombreCorreo)) {
            $nombreCorreo =
                $this->nombre1 .
                $this->nombre2 .
                $this->apellido1 .
                $this->apellido2;
        }

        /*
        * Eliminar acentos y caracteres no permitidos.
        * Conserva puntos, guiones y guiones bajos.
        */
        $nombreCorreo = Str::lower(
            Str::ascii($nombreCorreo)
        );

        $nombreCorreo = preg_replace(
            '/[^a-z0-9._-]/',
            '',
            $nombreCorreo
        );

        if (empty($nombreCorreo)) {
            $this->addError(
                'email',
                'No fue posible generar un correo electrónico válido.'
            );

            return;
        }

        /*
        * Reconstruir siempre con el tenant actual.
        */
        $this->email = $nombreCorreo
            . '@'
            . $nombreTenant
            . '.com';

        /*
        * La contraseña puede quedar vacía al editar.
        */
        $this->password = trim((string) $this->password);

        $this->validate();

        /*
        |--------------------------------------------------------------------------
        | Evitar nombres duplicados
        |--------------------------------------------------------------------------
        */

        $inputNormalizado = preg_replace(
            '/\s+/',
            '',
            $this->nombre1 .
            $this->nombre2 .
            $this->apellido1 .
            $this->apellido2
        );

        $existe = Resguardante::where(
            'id',
            '!=',
            $this->id_resguardante
        )
            ->get()
            ->contains(function ($resguardante) use ($inputNormalizado) {
                $nombreRegistrado = preg_replace(
                    '/\s+/',
                    '',
                    mb_strtolower(
                        $resguardante->nombre1 .
                        $resguardante->nombre2 .
                        $resguardante->apellido1 .
                        $resguardante->apellido2
                    )
                );

                return $nombreRegistrado === $inputNormalizado;
            });

        if ($existe) {
            $this->addError(
                'nombreCompleto',
                'Este nombre ya parece estar registrado anteriormente. '
                . 'Es posible que esté guardado con otra combinación de '
                . 'nombre o apellidos. Por favor verifica la información ingresada.'
            );

            return;
        }

        $data = [
            'id' => $this->id_resguardante,
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'puesto_id' => $this->puesto_id,
            'email' => $this->email,

            /*
            * Puede enviarse vacío.
            * El componente padre decidirá si cambia la contraseña.
            */
            'password' => $this->password,
        ];

        $this->dispatch(
            'UpdateResguardanteFromAnotherComponent',
            $data
        );

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nombre1','nombre2','apellido1','apellido2','resguardanteBusqueda','id_resguardante']);
    }

    public function render()
    {
        return view('livewire.update-resguardante');
    }

}
