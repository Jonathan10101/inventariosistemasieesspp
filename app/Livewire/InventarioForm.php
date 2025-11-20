<?php

namespace App\Livewire;

use DNS1D;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Resguardo;
use Illuminate\Support\Carbon;
use App\Models\HistorialResguardo;
use Illuminate\Support\Facades\Auth;



class InventarioForm extends Component
{
    use WithPagination;
    public $perPage = 2;
    public $search = '';
    public $showModal = false; // Controla el modal
    public $isEditing = false; // Determina si estamos editando o creando
    public $tituloModalPrincipal = "Registrar";
    public $accionPrincipal;
    public $data_external_component;
    public $data;

    public function mount()
    {
        
        $this->search = request()->query('search', '');
        if ($this->search) {
            $this->searchResguardos(); // o el método que uses
        }
    }

    public function changeModalTitle($accion){
        switch ($accion) {
            case "editar":                
                $this->tituloModalPrincipal = "Editar resguardo";                
            break;
            case "addNewResguardo":                
                $this->tituloModalPrincipal = "Agregar nuevo resguardo";                
            break;
            case 'showHistorialResguardo':
                $this->tituloModalPrincipal = "Historial de Resguardos";                
            break;
        }
    }

    public function accionEjecutada($accion,$id){
        switch ($accion) {
            case "editar":
                //dd($id);
                $this->edit($id);   
                /*
                //Estas lineas se agregan porque se le envian en el componente                             
                $this->student = Estudiante::findOrFail($id);
                if(isset($this->student->inscripciones[0]) && $this->student->inscripciones[0]->cursos){
                    $this->inscripciones =  $this->student->inscripciones;            
                    $this->tieneCursosAsignados = true;
                }       
                */         
            break;
            case "addNewResguardo":
                $this->addNewResguardo($id);
            break;
            case 'showHistorialResguardo':
                $this->showHistorialResguardo($id);
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

    // Método para editar Resguardo
    public function edit($id)
    {      

        $this->data_external_component = $id;
        //$this->data = "xd";
        /*
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
        */

        //$this->showModalNewResguardo();
        $this->showModal = true; // Abre el modal, se comento porque ya lo manda a llamar desde el metodo de arriba         
    }

    public function addNewResguardo($id)
    {        
        $this->data_external_component = $id;


        /*
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
        */
        $this->showModal = true; // Abre el modal
    }

    public function showHistorialResguardo($id){
        $this->data_external_component = $id;
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
        $this->search = "";
                
        $this->id_estudiante = 0;
        $this->id_curso = 0;

        $this->tituloModalPrincipal = "Registrar";
        $this->dispatch('refresh-page'); 
    }
        public function cambiarAccion($nuevaAccion,$id)
    {       
        $this->accionPrincipal = $nuevaAccion;// Cambia el valor de la propiedad
        $this->changeModalTitle($this->accionPrincipal);
        $this->accionEjecutada($this->accionPrincipal,$id);
    }
    
    public function showmodalselectedit(){
        $this->dispatch('update-modal');        
    }

    public function showModalNewResguardo(){               

        $this->showModal = true;// Abre el modal
    }

    //Renderiza el componente
    /*
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
    */

    public function render()
    {
        $user = Auth::user();
        $resguardos = Resguardo::query();

        /* ============================================================
        🟦 ADMINISTRADOR — ve y busca TODO
        ============================================================ */
        if ($user->hasRole('Administrador')) {

            if ($this->search) {
                $busqueda = ltrim($this->search, '0');
                $resguardos = Resguardo::where('id', $busqueda);
            } else {
                $resguardos = Resguardo::query();
            }

            $resguardos = $resguardos
                ->with(['historial', 'marca'])
                ->paginate(10);

            return view('livewire.inventario-form', compact('resguardos'));
        }


        /* ============================================================
        🟧 EMPLEADO — solo puede ver/buscar resguardos donde
        el ÚLTIMO historial diga que él es el resguardante
        ============================================================ */
        if ($user->hasRole('Empleado')) {

            $resguardos = Resguardo::where(function ($q) use ($user) {

                $q->where(
                    'id',
                    function ($sub) use ($user) {
                        $sub->select('resguardo_id')
                            ->from('historial_resguardos')
                            ->whereColumn('resguardo_id', 'resguardos.id')
                            ->where('resguardante_id', $user->id)
                            ->where('fecha_liberacion', null)//Comentar esto para quitarlo
                            ->orderByDesc('id') // último historial
                            ->limit(1);
                    }
                );

            });

            /* 🔍 BUSCADOR RESTRINGIDO (Empleado solo busca sus propios resguardos) */
            if ($this->search) {
                $busqueda = ltrim($this->search, '0');

                $resguardos->where('id', $busqueda);
            }

            $resguardos = $resguardos->with([
                    'historial.resguardante',
                    'historial.estadouso',
                    'historial.areaDeUso',
                    'historial.ubicacionFisica',
                    'marca'
                ])
                ->paginate(10);

            return view('livewire.inventario-form', compact('resguardos'));
        }
    }

    #[On('updateUbicacionFromComponentResguardo')]
    public function updateResguardo($data){
        //dd($data['resguardo_id']);
        $resguardo = Resguardo::find($data['resguardo_id']);
        $resguardo->update([
            'descripcion' => $data['descripcion'],
            'marca_id' => $data['marca_id'],
            'modelo' => $data['modelo'],
            'resguardante_id' => $data['resguardante_id'],
            'puesto_id'=> $data['puesto_id']
        ]);
        $historial = HistorialResguardo::find($data['historial_resguardo_id']);
        //dd($data['historial_resguardo_id']);
        $historial->update([
            'area_de_uso_id' => $data['area_de_uso_id'],
            'ubicacion_fisicas_id' => $data['ubicacion_fisicas_id'],
        ]);
        $this->dispatch('alumno-updated', 1);

    }

    #[On('saveFromComponentAddNewHistorialResguardo')]
    public function emitirAddNewResguardoAlert(){
        $this->dispatch('alumno-created2', 1);
    }

    #[On('resguardoCreado')]
    public function emitirNewResguardoAlert(){
        $this->dispatch('alumno-created', 1);
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

        $id_of_student->historial()->create([
            'resguardante_id' => $data['resguardante_id'],
            'resguardo_pdf' => $data['resguardo_pdf'] ,
            'fecha_asignacion' => now(),
            'fecha_liberacion' => null,
        ]);

        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);

        /*
        $idStudent = (string) $id_of_student->id;
        // Genera un código de 10 dígitos, con ceros a la izquierda
        $codigo = str_pad($idStudent, 8, '0', STR_PAD_LEFT);
        
        $this->dispatch('alumno-created', $idStudent);
        //$this->assignCourse($id);
        
        return redirect()->route('etiquetas.show',$codigo);

        //$this->assignCourse(3);
        */


        $this->resetForm();
        //$this->showModal = false;  
    }

    public function downloadEtiqueta($id){
       
        $codigo = str_pad($id, 8, '0', STR_PAD_LEFT);
        //dd($codigo);

        return redirect()->route('etiquetas.show',$codigo);
    }

    #[On('saveFromComponentNewHistorialResguardo')]
    public function guardarHistorialResguardo($data){
        HistorialResguardo::create([
            'resguardo_id' => $data['resguardo_id'],
            'resguardante_id' => $data['resguardante_id'],
            'resguardo_pdf' => $data['resguardo_pdf'],
            'fecha_asignacion' => now(),
            'fecha_liberacion' => null
        ]);
        $resguardoUpdate = Resguardo::find($data['resguardo_id']);
        $resguardoUpdate->update([
            'imagen' => $data['imagen'],
            'estado_uso_id' => $data['estado_uso_id'],
            'area_de_uso_id' => $data['area_de_uso_id'],
            'ubicacion_fisicas_id' => $data['ubicacion_fisicas_id'],
            'resguardante_id' => $data['resguardante_id'],
            'puesto_id' => $data['puesto_id']
        ]);
    }
    
    #[On('notifyCloseModal')]
    public function closeModalFromOtherComponent(){
        $this->showModal = false; // Cerrar el modal
    }

}
