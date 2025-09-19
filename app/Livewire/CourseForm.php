<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cursos;
use Livewire\Attributes\On;

class CourseForm extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $tituloModalPrincipal = "Registrar";    
    public $showModal = false; // Controla el modal
    public $accionPrincipal;
    public $course;
    public $name_of_course,$duration_of_course,$type_of_course;

    protected $listeners = ['borrar']; // Escucha el evento 'borrar'

    protected $rules = [
        'nombre_curso' => 'required|string|max:250|unique:cursos,nombre_curso',
        'duration_of_course' => 'required|integer|max:2050|min:5',
        'type_of_course' => 'required'        
    ];

 

    public function searchCourses(){
        
    }

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    public function cambiarAccion($nuevaAccion,$id)
    {       
        $this->accionPrincipal = $nuevaAccion;// Cambia el valor de la propiedad
        $this->changeModalTitle($this->accionPrincipal);
        $this->accionEjecutada($this->accionPrincipal,$id);
    }

    public function changeModalTitle($accion){
        switch ($accion) {            
            case "editar":                
                $this->tituloModalPrincipal = "Editar";                
            break;
        }
    }

    public function accionEjecutada($accion,$id){
        switch ($accion) {            
            case "editar":
                $this->edit($id);                                
                $this->course = Cursos::findOrFail($id);                               
            break;     
            case 'borrarAlert':
                //$courseToDestroy = Cursos::find($id);
                //$courseToDestroy->delete();
                $this->dispatch('course-destroy-alert', $id);
            break;     
            case 'borrar':
                $courseToDestroy = Cursos::find($id);
                if ($courseToDestroy) {
                    //dd($courseToDestroy);
                    //$courseToDestroy->delete();
                    $courseToDestroy->update(['activo' => 0]);

                    $this->dispatch('course-destroy', 'Curso eliminado correctamente!');
                }
                //$this->dispatch('$refresh'); // Refresca el componente

            break;     
        }  
    }

    public function edit($id)
    {      
        $cursoedit = Cursos::findOrFail($id);
        $this->isEditing = true;
        $this->name_of_course = $cursoedit->nombre_curso;
        $this->duration_of_course = $cursoedit->duracion_en_horas;
        $this->type_of_course = $cursoedit->type_of_course;             
        $this->showModalNewCourse();        
    }

    public function showModalNewCourse(){
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
            'name_of_course', 'duration_of_course', 'type_of_course'
        ]);
    }

        
    #[On('saveFromComponentNewCourse')] 
    public function saveNewCourse($data){        
        Cursos::create([
            'nombre_curso' => $data['nombre_curso'],
            'duracion_en_horas' => $data['duracion_en_horas'],
            'type_of_course' => $data['type_of_course'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],     
        ]);        
        $this->dispatch('course-created', 'Curso registrado correctamente!');
    }

    #[On('saveUpdateCourseFromAnotherComponent')]
    public function saveUpdateCourse($data){        
        $dataFinalUpdate = [
            'nombre_curso' => $data['name_of_course'],
            'duracion_en_horas' => $data['duration_of_course'],
            'type_of_course' => $data['type_of_course']                               
        ];
        
        
        $cursoDB = Cursos::findOrFail($data['id_curso']);
        $cursoDB->update($dataFinalUpdate);
        //$this->showModal = false;
        //$this->resetForm();

        $this->showModal = false; // Cierra el modal
        $this->closeModal();
        
        $this->dispatch('course-created', 'Curso actualizado correctamente!');                
    }
    
    public function render()
    {                                 
        // Inicia la consulta para los cursos
        $query = Cursos::query();

        // Filtra solo aquellos cursos cuyo atributo "activo" esté en 1
        $query->where('activo', 1);  // Filtrar cursos activos

        // Si hay una búsqueda, agrega el filtro de búsqueda adicional
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre_curso', 'like', "%{$this->search}%")
                ->orWhere('type_of_course', 'like', "%{$this->search}%");
            });
        }

        // Retorna la vista con los cursos filtrados
        return view('livewire.course-form', [            
            'cursos' => $query->paginate($this->perPage)
        ]);                          
    }


}
