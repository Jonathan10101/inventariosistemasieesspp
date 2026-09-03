<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AreaDeUso;

class UpdateAreasDeUso extends Component
{
    public $areaDeUso,$areaDeUsoBusqueda,$id_areadeuso;
    protected $rules = [
        'nombre' => 'required|min:2|max:100|unique:area_de_uso,nombre',      
    ];

    public function mount($data){     
        $areaDeUso =   AreaDeUso::find($data);
        $this->areaDeUso = $areaDeUsoBusqueda->nombre; 
        $this->id_areadeuso = $areaDeUso->id; 
    }

    public function save(){
        $this->areaDeUso = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->areaDeUso)));
        $this->validate();  
        
        $areaDeUsoComparacion = str_replace(' ', '', $this->areaDeUso);

        $existe = AreaDeUso::whereRaw("REPLACE(nombre, ' ', '') = ?", [$areaDeUsoComparacion])->exists();

        if ($existe) {
            $this->addError('puesto', 'Esta área de uso ya existe aunque escrito diferente.');
            return;
        }

        $data = [
            'id' => $this->id_puesto,
            'nombre' =>  $this->puesto,
        ];                            
        $this->dispatch('saveUpdateAreaDeUsoFromAnotherComponent',$data);
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['areaDeUso','id_areadeuso']);
    }

    public function render()
    {
        return view('livewire.update-areas-de-uso');
    }
}
