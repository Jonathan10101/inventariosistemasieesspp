<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Municipio;
use Livewire\Attributes\On;

class MunicipioForm extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $tituloModalPrincipal = "Registrar";    
    public $showModal = false; // Controla el modal
    public $accionPrincipal;
    public $course;
    public $nombre_municipio,$estado_id;

    protected $listeners = ['borrar']; // Escucha el evento 'borrar'

    protected $rules = [
        'nombre_municipio' => 'required|string|max:250|unique:municipios,nombre_municipio',
        'estado_id' => 'required|integer|max:2050|min:1', 
    ];

    public function searchMunicipios(){
        
    }

    
    public function showModalNewMunicipio(){
        $this->showModal = true;// Abre el modal
    }

    // Cerrar el modal y resetear formulario    
    public function closeModal()
    {             
        $this->resetForm(); // Limpiar los datos del formulario        
        $this->accionPrincipal = "";
        $this->showModal = false; // Cerrar el modal
        $this->isEditing = false;        
        $this->tituloModalPrincipal = "Registrar";
    }

    public function resetForm()
    {
        $this->reset([
            'nombre_municipio', 'estado_id'
        ]);
    }

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }


    public function render()
    {
        // Inicia la consulta para los cursos
        $query = Municipio::query();

        // Filtra solo aquellos cursos cuyo atributo "activo" esté en 1
        //$query->where('activo', 1);  // Filtrar cursos activos

        // Si hay una búsqueda, agrega el filtro de búsqueda adicional
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre_municipio', 'like', "%{$this->search}%");
            });
        }

        // Retorna la vista con los cursos filtrados
        return view('livewire.municipio-form', [            
            'municipios' => $query->paginate($this->perPage)
        ]); 
        return view('livewire.municipio-form');
    }
}
