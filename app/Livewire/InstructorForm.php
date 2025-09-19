<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instructor;



class InstructorForm extends Component
{
    use WithPagination;

    public $search = '';
    public $accionPrincipal;
    public $showModal = false; // Controla el modal
    public $isEditing = false; // Determina si estamos editando o creando
    public $tituloModalPrincipal = "Registrar";
    public $perPage = 5;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Función para realizar la búsqueda
    public function searchInstructores()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    //Renderiza el componente
    public function render()
    {
        $query = Instructor::query();
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre1', 'like', "%{$this->search}%")
                    ->orWhere('nombre2', 'like', "%{$this->search}%")
                    ->orWhere('apellido1', 'like', "%{$this->search}%")
                    ->orWhere('apellido2', 'like', "%{$this->search}%");
            });
        }    
        return view('livewire.instructor-form', [
            'instructores' => $query->paginate($this->perPage)
        ]);
    }


}
