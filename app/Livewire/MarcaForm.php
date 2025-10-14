<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Marca;

class MarcaForm extends Component
{
    use WithPagination;
    //public $marcas;
    public $tituloModalPrincipal = "REGISTRAR";
    public $searchResguardos;
    public $showModal = false;
    public $accionPrincipal = "";
    public $search;
    public $perPage = 3;


    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchMarcas()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    public function render()
    {
        $query = Marca::query();
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%");
            });
        }  

        return view('livewire.marca-form', [
            'marcas' => $query->paginate($this->perPage),
        ]);
    }
    
}
