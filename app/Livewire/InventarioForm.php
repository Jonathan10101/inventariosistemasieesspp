<?php

namespace App\Livewire;

use DNS1D;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Resguardo;

class InventarioForm extends Component
{
    use WithPagination;
    public $search = '';
    public $showModal = false; // Controla el modal
    public $isEditing = false; // Determina si estamos editando o creando
    public $tituloModalPrincipal = "Registrar";
    public $accionPrincipal;
    public $perPage = 1;
    
    public function changeModalTitle($accion){
        switch ($accion) {
            case "mostrar_certificados":
                $this->tituloModalPrincipal = "Certificados";            
            break;
            case "inscripcion_a_curso":
                $this->tituloModalPrincipal = "Inscripción a curso";            
            break;
            case "editar":                
                $this->tituloModalPrincipal = "Editar";                
            break;
        }
    }

    public function accionEjecutada($accion,$id){
        switch ($accion) {
            case "inscripcion_a_curso":                
                $this->assignCourse($id);
            break;
            case "editar":
                $this->edit($id);   
                //Estas lineas se agregan porque se le envian en el componente                             
                $this->student = Estudiante::findOrFail($id);
                if(isset($this->student->inscripciones[0]) && $this->student->inscripciones[0]->cursos){
                    $this->inscripciones =  $this->student->inscripciones;            
                    $this->tieneCursosAsignados = true;
                }                
            break;
            case "mostrar_certificados":
                $this->showModalAllCertificados();
                $this->student = Estudiante::findOrFail($id);
                if(isset($this->student->inscripciones[0]) && $this->student->inscripciones[0]->cursos){
                    $this->inscripciones =  $this->student->inscripciones;            
                    $this->tieneCursosAsignados = true;
                }            
            break;                   
        }  
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reiniciar los valores del formulario
    public function resetForm()
    {
        $this->reset(['tituloModalPrincipal','accionPrincipal']);
    }

    // Función para limpiar la búsqueda
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage(); // Reinicia la paginación
    }

    // Función para realizar la búsqueda
    public function searchResguardos()
    {
        // No es necesario hacer nada más, ya que Livewire maneja automáticamente el filtrado con `wire:model="search"`
    }

    // Método para editar estudiante
    public function edit($id)
    {      
        $estudiante = Estudiante::findOrFail($id);
        $this->isEditing = true;
        $this->id_estudiante = $estudiante->id;

        $this->nombre1 = $estudiante->nombre1;
        $this->nombre2 = $estudiante->nombre2;
        $this->apellido1 = $estudiante->apellido1;
        $this->apellido2 = $estudiante->apellido2;
        $this->matricula_cuip = $estudiante->matricula_cuip;
        $this->municipio_procedencia = $estudiante->municipio_id;
        $this->curp = $estudiante->curp;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        
        $this->id_escolaridad = $estudiante->escolaridad_id;
        $this->genero = $estudiante->genero;
        $this->celular = $estudiante->celular;
        $this->correo_electronico = $estudiante->correo_electronico;

        $this->showModalNewStudent();
        //$this->showModal = true; // Abre el modal, se comento porque ya lo manda a llamar desde el metodo de arriba         
    }

    public function assignCourse($id)
    {        
        $this->student = Estudiante::findOrFail($id);
        $this->id_estudiante = $this->student->id;
        $this->cursos = Cursos::where('activo', 1)->get();
        $this->grupos = Grupos::all();
        $this->sedes = Sedes::all();
        $this->adscripciones = Adscripciones::all();
        $this->generacionesv2 = Generaciones::all();
        $this->instituciones = Instituciones::all();

        //dd($this->instituciones);
        $this->isAnInscription = true;
        $estudiante = $this->student;        
        if(isset($estudiante->inscripciones[0]) && $estudiante->inscripciones[0]->cursos){
            $this->inscripciones = $estudiante->inscripciones;            
            $this->tieneCursosAsignados = true;
        }        
        $this->showModal = true; // Abre el modal
    }

    // Método para iniciar creación de un nuevo estudiante (esto es importante para limpiar todo)
    public function createNewStudent()
    {
        $this->resetForm(); // Resetear formulario al crear un nuevo estudiante
        $this->showModal = true; // Abrir el modal
    }

    // Cerrar el modal y resetear formulario    
    public function closeModal()
    {
        $this->resetForm(); // Limpiar los datos del formulario
        $this->celular = "";
        $this->accionPrincipal = "";
        $this->showModal = false; // Cerrar el modal
        $this->isEditing = false;
        $this->isAnInscription = false;
        $this->inscripciones = "";     
        $isAnInscription = false;   
                
        $this->id_estudiante = 0;
        $this->id_curso = 0;

        $this->tituloModalPrincipal = "Registrar";
        $this->dispatch('refresh-page'); 
    }
    
    public function showmodalselectedit(){
        $this->dispatch('update-modal');        
    }

    public function showModalNewStudent(){               

        $this->showModal = true;// Abre el modal
    }

    //Renderiza el componente
    public function render()
    {
        $query = Resguardo::query();

        if ($this->search) {
            $busqueda = ltrim($this->search, '0'); // quitar ceros de la izquierda
            $query->where('id', $busqueda);
        }

        return view('livewire.inventario-form', [
            'resguardos' => $query->paginate($this->perPage),
        ]);
    }

    #[On('saveFromComponentNewResguardo')] 
    public function saveNewResguardo($data){ 
        
        $id_of_student = Resguardo::create([
            'descripcion' => $data['descripcion'],
            'marca_id' => $data['marca_id'],
            'modelo' => $data['modelo'],
            'nserie' => $data['nserie'],
            // no mandamos nresguardo aquí
            'estado_uso_id' => $data['estado_uso_id'],            
            'area_de_uso_id' => $data['area_de_uso_id'],  
            'ubicacion_fisicas_id' => $data['ubicacion_fisicas_id'],  
            'resguardante_id' => $data['resguardante_id'], 
            'puesto_id' => $data['puesto_id'],
            'imagen' => $data['imagen'],
            'resguardo_pdf' => $data['resguardo_pdf'] 
        ]);


        
        $idStudent = (string) $id_of_student->id;
        // Genera un código de 10 dígitos, con ceros a la izquierda
        $codigo = str_pad($idStudent, 8, '0', STR_PAD_LEFT);
        
        $this->dispatch('alumno-created', $idStudent);
        //$this->assignCourse($id);
        
        return redirect()->route('etiquetas.show',$codigo);

        //$this->assignCourse(3);


        $this->resetForm();
        $this->showModal = false;  
    }
    
    #[On('notifyCloseModal')]
    public function closeModalFromOtherComponent(){
        $this->showModal = false; // Cerrar el modal
    }

}
