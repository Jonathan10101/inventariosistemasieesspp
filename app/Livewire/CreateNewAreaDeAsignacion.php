<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AreaDeUso;
use App\Services\TenantDatabaseStorage;


class CreateNewAreaDeAsignacion extends Component
{
    public $area_de_uso;

    protected $rules = [
        'area_de_uso' => 'required|min:2|max:100|unique:area_de_uso,nombre'
    ];

    public function save(){
        app(\App\Services\TenantDatabaseStorage::class)->assertCanWrite();

        $this->area_de_uso = preg_replace('/\s+/', ' ', trim(mb_strtoupper($this->area_de_uso)));
        $this->validate();

        $area_de_uso_comparacion = str_replace(' ', '', $this->area_de_uso);

        $existe = AreaDeUso::whereRaw("REPLACE(nombre, ' ', '') = ?", [$area_de_uso_comparacion])->exists();

        if ($existe) {
            $this->addError('areadeuso', 'Esta área de uso ya existe aunque escrito diferente.');
            return;
        }


        $data = [
            'nombre' => $this->area_de_uso,
        ];

        $this->dispatch('saveFromComponentNewAreaDeUso',$data);        
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'area_de_uso'
        ]);
    }

    public function render()
    {
        return view('livewire.create-new-area-de-asignacion');
    }
}
