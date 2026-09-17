<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Resguardo;
use App\Models\HistorialResguardo;
use Illuminate\Support\Facades\Auth;


class InventarioForm extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $rangeFrom = null;
    public $rangeTo = null;
    public $from;
    public $to;

    public $search = '';
    public $showModal = false; // Controla el modal
    public $isEditing = false; // Determina si estamos editando o creando
    public $tituloModalPrincipal = "Registrar";
    public $accionPrincipal;
    public $data_external_component;
    public $data;
    public string $filtroInstitucion = 'ALL'; // ALL | IEESSPP | ARSPO


    public function updated($field)
    {
        if ($this->from < 1) $this->from = 1;
        if ($this->to < $this->from) $this->to = $this->from;
    }

    public function applyRange($query)
    {
        if ($this->rangeFrom && $this->rangeTo) {
            $from = max(1, (int) $this->rangeFrom);
            $to   = max($from, (int) $this->rangeTo);
            $cantidad = $to - $from + 1;
            return $query->skip($from - 1)->take($cantidad);
        }
        return $query;
    }

    public function updatingPerPage()
    {
        $this->resetPage(); // Para que no se quede en página 2, 3, etc.
    }

    public function updatedFiltroInstitucion()
    {
        $this->resetPage(); // importante con paginación
    }

    public function getResguardosProperty()
    {
        return Resguardo::query()
        ->when($this->filtroInstitucion !== 'ALL', function ($q) {
            $q->where('institucion', $this->filtroInstitucion);
        })
        ->orderByDesc('id')
        ->paginate(10);
    }

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
                $this->edit($id);           
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
        $this->showModal = true; // Abre el modal, se comento porque ya lo manda a llamar desde el metodo de arriba         
    }

    public function addNewResguardo($id)
    {        
        $this->data_external_component = $id;
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

    public function render()
    {
        $user = Auth::user();
        $resguardos = Resguardo::query();

        /* ============================================================
        🟦 ADMINISTRADOR / DIRECTOR / DELEGACIÓN
        ============================================================ */
        if ($user->hasRole('Administrador') || $user->hasRole('Director') || $user->hasRole('Delegacion')) {

            $resguardos = Resguardo::query();

            if ($this->search) {
                $busqueda = trim($this->search);
                $busquedaId = ltrim($busqueda, '0');

                $resguardos->where(function ($q) use ($busqueda, $busquedaId) {

                    // 🔢 Buscar por CÓDIGO
                    $q->where('id', $busquedaId)
                    ->orWhere('nresguardo', 'LIKE', "%{$busqueda}%")

                    // 👤 Buscar por CUALQUIER PARTE del nombre del RESGUARDANTE
                    ->orWhereHas('resguardante', function ($q2) use ($busqueda) {
                        $q2->where('nombre1', 'LIKE', "%{$busqueda}%")
                            ->orWhere('nombre2', 'LIKE', "%{$busqueda}%")
                            ->orWhere('apellido1', 'LIKE', "%{$busqueda}%")
                            ->orWhere('apellido2', 'LIKE', "%{$busqueda}%")
                            // 🔥 Nombre completo concatenado
                            ->orWhereRaw("
                                CONCAT_WS(' ',
                                    nombre1,
                                    nombre2,
                                    apellido1,
                                    apellido2
                                ) LIKE ?
                            ", ["%{$busqueda}%"]);
                    });
                });
            }

            // ✅ filtro por institución
            $resguardos->when($this->filtroInstitucion !== 'ALL', function($q){
                $q->where('institucion', $this->filtroInstitucion);
            });

            $resguardos->with(['historial', 'marca', 'resguardante']);

            $resguardos = $this->applyRange($resguardos);

            if (!$this->rangeFrom || !$this->rangeTo) {
                $resguardos = $resguardos->paginate($this->perPage);
            } else {
                $resguardos = $resguardos->get();
            }

            return view('livewire.inventario-form', compact('resguardos'));
        }



        /* ============================================================
        🟩 SUBDIRECTOR
        ============================================================ */
        if ($user->hasRole('Subdirector')) {

            $miSubdireccion = $user->subdireccion;

            $resguardos->whereHas('resguardante.user', function ($q) use ($miSubdireccion) {
                $q->where('subdireccion', 'LIKE', "%{$miSubdireccion}%");
            });

            if ($this->search) {
                $busqueda = ltrim($this->search, '0');
                $resguardos->where('id', $busqueda);
            }

            // ✅ filtro por institución
            $resguardos->when($this->filtroInstitucion !== 'ALL', function($q){
                $q->where('institucion', $this->filtroInstitucion);
            });

            $resguardos = $resguardos->with(['historial', 'marca']);
            $resguardos = $this->applyRange($resguardos);

            if (!$this->rangeFrom || !$this->rangeTo) {
                $resguardos = $resguardos->paginate($this->perPage);
            } else {
                $resguardos = $resguardos->get();
            }

            return view('livewire.inventario-form', compact('resguardos'));
        }

        /* ============================================================
        🟧 EMPLEADO
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
                            ->where('fecha_liberacion', null)
                            ->orderByDesc('id')
                            ->limit(1);
                    }
                );
            });

            if ($this->search) {
                $busqueda = ltrim($this->search, '0');
                $resguardos->where('id', $busqueda);
            }

            // ✅ filtro por institución
            $resguardos->when($this->filtroInstitucion !== 'ALL', function($q){
                $q->where('institucion', $this->filtroInstitucion);
            });

            $resguardos = $resguardos->with([
                'historial.resguardante',
                'historial.estadouso',
                'historial.areaDeUso',
                'historial.ubicacionFisica',
                'marca'
            ]);

            $resguardos = $this->applyRange($resguardos);

            if (!$this->rangeFrom || !$this->rangeTo) {
                $resguardos = $resguardos->paginate($this->perPage);
            } else {
                $resguardos = $resguardos->get();
            }

            return view('livewire.inventario-form', compact('resguardos'));
        }
    }

    #[On('updateUbicacionFromComponentResguardo')]
    public function updateResguardo($data){
        $resguardo = Resguardo::find($data['resguardo_id']);
        $resguardo->update([
            'descripcion' => $data['descripcion'],
            'marca_id' => $data['marca_id'],
            'modelo' => $data['modelo'],
            'resguardante_id' => $data['resguardante_id'],
            'puesto_id'=> $data['puesto_id'],
            'nserie' => $data['nserie'],
            //'institucion' => $data['institucion']
        ]);
        $historial = HistorialResguardo::find($data['historial_resguardo_id']);
        $historial->update([
            'resguardante_id' => $data['resguardante_id'],
            'puesto_id'=> $data['puesto_id'],
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
        app(\App\Services\TenantDatabaseStorage::class)->assertCanWrite();
        
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
            'resguardo_pdf' => $data['resguardo_pdf'],
            'updated_at' => null, 
        ]);

        $id_of_student->historial()->create([
            'resguardante_id' => $data['resguardante_id'],
            'resguardo_pdf' => $data['resguardo_pdf'] ,
            'fecha_asignacion' => now(),
            'fecha_liberacion' => null,
        ]);

        $this->showModal = false;  
        $this->dispatch('alumno-created', 1);

        $this->resetForm();
    }

    /*
    public function downloadEtiqueta($id)
    {
        $codigo = str_pad((string) $id, 8, '0', STR_PAD_LEFT);

        $url = route('etiquetas.show', $codigo);

        $this->dispatch(
            'open-etiqueta',
            url: $url
        );
    }
    */

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
