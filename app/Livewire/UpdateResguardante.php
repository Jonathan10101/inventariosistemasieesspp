<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardante;
use App\Models\User;
use App\Models\Puesto;
use Livewire\Attributes\On;

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


    public function save(){
        $this->nombre1   = trim(mb_strtolower($this->nombre1));
        $this->nombre2   = trim(mb_strtolower($this->nombre2));
        $this->apellido1 = trim(mb_strtolower($this->apellido1));
        $this->apellido2 = trim(mb_strtolower($this->apellido2));
        $this->email = trim(mb_strtolower($this->email));
        $this->password = trim($this->password);

        $this->validate();

        // ✅ Unir TODO como una sola cadena (sin espacios extra)
        $inputNormalizado = preg_replace('/\s+/', '', 
            $this->nombre1 . $this->nombre2 . $this->apellido1 . $this->apellido2
        );

        $existe = Resguardante::where('id', '!=', $this->id_resguardante)
            ->get()
            ->contains(function ($r) use ($inputNormalizado) {
                $db = preg_replace('/\s+/', '', mb_strtolower(
                    $r->nombre1 . $r->nombre2 . $r->apellido1 . $r->apellido2
                ));
                return $db === $inputNormalizado;
            });

        if ($existe) {
            $this->addError('nombreCompleto', 'Este nombre ya parece estar registrado anteriormente. Es posible que esté guardado con otra combinación de nombre o apellidos. Por favor verifica la información ingresada.');
            return;
        }

        $data = [
            'id' => $this->id_resguardante,
            'nombre1' =>  $this->nombre1,
            'nombre2' =>  $this->nombre2,
            'apellido1' =>  $this->apellido1,
            'apellido2' =>  $this->apellido2,
            'puesto_id' => $this->puesto_id,
            'email' => $this->email,
            'password' => $this->password
        ];          
         
        $this->dispatch('UpdateResguardanteFromAnotherComponent',$data);
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
