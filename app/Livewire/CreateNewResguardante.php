<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resguardante;

class CreateNewResguardante extends Component
{
    public $nombre1,$nombre2,$apellido1,$apellido2,$email,$password,$subdireccion;
    

    protected $rules = [
        'nombre1' => 'required|min:2|max:50',
        'nombre2' => 'nullable|max:50',
        'apellido1' => 'required|min:2|max:50',
        'apellido2' => 'nullable|max:50',
        'email' => 'required|min:10|max:75|email|unique:users,email',
        'password' => 'required|min:8|max:50',
        'subdireccion' => 'required'
    ];

    public function save(){
        // Normalizamos todo
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

        $existe = Resguardante::get()->contains(function ($r) use ($inputNormalizado) {
            $db = preg_replace('/\s+/', '', strtolower(
                $r->nombre1 . $r->nombre2 . $r->apellido1 . $r->apellido2
            ));
            return $db === $inputNormalizado;
        });

        if ($existe) {
            $this->addError('nombreCompleto', 'Este nombre ya parece estar registrado anteriormente. Es posible que esté guardado con otra combinación de nombre o apellidos. Por favor verifica la información ingresada.');
            return;
        }
        //dd($this->subdireccion);
        
        $data = [
            'nombre1' => $this->nombre1,
            'nombre2' => $this->nombre2,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'email' => $this->email,
            'password' => $this->password,
            'subdireccion' => $this->subdireccion
        ];


        $this->dispatch('saveFromComponentNewResguardante',$data);        
        $this->resetForm();
    }



    public function resetForm()
    {
        $this->reset([
            'nombre1','nombre2','apellido1','apellido2'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-resguardante');
    }
}
