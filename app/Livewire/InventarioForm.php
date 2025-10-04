<?php

namespace App\Livewire;

use DNS1D;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Municipio;
use App\Models\Escolaridad;
use App\Models\Estudiante;
use App\Models\Generaciones;
use App\Models\Cursos;
use App\Models\Grupos;
use App\Models\Sedes;
use App\Models\Inscripciones;
use App\Models\Adscripciones;
use App\Models\Instituciones;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleQrcode\Writer\Writer;
use Endroid\QrCode\ErrorCorrectionLevel;
use Livewire\Attributes\On;
use App\Livewire\Forms\StudentCreateForm;
use NumberToWords\NumberToWords;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\EstatusEstudiante;
use App\Models\Resguardo;

class InventarioForm extends Component
{
    use WithPagination;
    
    public $search = '';
    public $id,$id_inscripcion,$id_estudiante,$id_curso,$id_grupo,$id_sede,$id_adscripcion,$id_generacion,$id_fecha_inicio,$id_fecha_final,$id_escolaridad;
    public $cursos,$sedes,$grupos,$adscripciones,$inscripciones,$generacionesv2,$instituciones;
    public $nombreCurso,$accionPrincipal,$sizeInscripciones,$data_external_component,$fecha_inicio,$fecha_terminacion;        
    public $generacion_id;
    public $student;            
    public $nombre1, $nombre2, $apellido1, $apellido2,$municipio_procedencia, $curp, $edad,$fecha_nacimiento, $genero, $correo_electronico,$matricula_cuip,$celular,$cuip,$lugar;    
    public $showCertificados = false; 
    public $showAdditionalFields = false;
    public $showModal = false; // Controla el modal
    public $isEditing = false; // Determina si estamos editando o creando
    public $isAnInscription = false;
    public $tieneCursosAsignados = false;
    public $formSubmitted = false;    
    public $tituloModalPrincipal = "Registrar";
    public $perPage = 3;
    public $idEstudianteADarDeBaja;
    public $fecha_baja;
    public $motivo_baja;
    //public $fecha_validacion,$fecha_de_ejecucion;
    public $fecha_validacion_inicial,$fecha_validacion_final,$fecha_ejecucion_inicial,$fecha_ejecucion_final;


    protected $listeners = ['cambiarAccion'];



    public StudentCreateForm $sudentCreate;
    /*
    protected $rules = [
        'nombre1' => 'required|string|max:255',
        'apellido1' => 'required|min:3',
        'municipio_procedencia' => 'required',
        'curp' => 'required|string|size:18|unique:estudiantes,curp',
        'fecha_nacimiento' => 'required',
        'id_escolaridad' => 'required|exists:escolaridad,id',
        'genero' => 'required|in:M,H',                
        'generacion_id' => 'required|exists:generaciones,id', // Validar que exista en la tabla generaciones
        'celular' => 'nullable|digits:10|unique:estudiantes', // Validar que sea un número de 10 dígitos         
        'correo_electronico' => 'required|email|unique:estudiantes,correo_electronico',
        'matricula_cuip' => 'required|unique:estudiantes,matricula_cuip|min:20|max:20', // Aseguramos que sea único
    ];
    */
    
    //Sirve para mostrar los demas campos al momento de querer registrar un nuevo alumno si se presiona el boton correspondiente
    public function toggleAdditionalFields()
    {
        $this->showAdditionalFields = !$this->showAdditionalFields;
    }
   
    //Actualiza y reinicia la paginación al cambiar el valor de búsqueda
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('assign-course2')]
    public function cambiarAccion($nuevaAccion,$id)
    {       
        $this->accionPrincipal = $nuevaAccion;// Cambia el valor de la propiedad
        $this->changeModalTitle($this->accionPrincipal);
        $this->accionEjecutada($this->accionPrincipal,$id);
        /*
        //Cambiar el titulo del modal
        switch ($this->accionPrincipal) {
            case "mostrar_certificados":
                $this->tituloModalPrincipal = "Certificados";            
            break;
            case "inscripcion_a_curso":
                $this->tituloModalPrincipal = "Inscripción a Curso";            
            break;
            case "editar":                
                $this->tituloModalPrincipal = "Editar";                
            break;
        }
        */
        /*        
        switch ($this->accionPrincipal) {
            case "inscripcion_a_curso":
                $this->assignCourse($id);
            break;
            case "editar":
                $this->edit($id);                                
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
        */
    }
    
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





    /*
    // Generación automática de matrícula
    private function generateMatricula()
    {
        do {
            // Generar una clave única de 20 caracteres
            $matricula = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 20));
        } while (Estudiante::where('matricula_cuip', $matricula)->exists()); // Verificar que no se repita        
        return $matricula;
    }
    */

function generarEtiquetaBarcode($codigo, $texto = true)
{
    $barcode = DNS1D::getBarcodeHTML($codigo, 'C39', 2, 60);

    if ($texto) {
        $barcode .= "<div style='text-align:center; font-size:14px; margin-top:5px;'>$codigo</div>";
    }

    return $barcode;
}
        
    // Reiniciar los valores del formulario
    public function resetForm()
    {
        $this->reset([
            'id_estudiante', 'nombre1', 'nombre2', 'apellido1', 'apellido2',
            'municipio_procedencia', 'curp', 'fecha_nacimiento', 'id_escolaridad', 'genero', 'correo_electronico','celular',
            'matricula_cuip',
        ]);
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
        $this->cursos = Cursos::all();
        $this->grupos = Grupos::all();
        $this->sedes = Sedes::all();
        $this->adscripciones = Adscripciones::all();
        $this->generacionesv2 = Generaciones::all();
        $this->showModal = true;// Abre el modal
    }

    //Renderiza el componente
    /*
    public function render()
    {
        $query = Estudiante::query();
        if ($this-> ) {
            $query->where(function ($q) {
                $q->where('nombre1', 'like', "%{$this->search}%")
                    ->orWhere('nombre2', 'like', "%{$this->search}%")
                    ->orWhere('apellido1', 'like', "%{$this->search}%")
                    ->orWhere('apellido2', 'like', "%{$this->search}%")
                    ->orWhere('matricula_cuip', 'like', "%{$this->search}%")
                    ->orWhere('correo_electronico', 'like', "%{$this->search}%")
                    ->orWhere('curp', 'like', "%{$this->search}%");
            });
        }    
        return view('livewire.student-form', [
            'municipios' => Municipio::all(),
            'escolaridades' => Escolaridad::all(),
            'generaciones' => Generaciones::all(),// Cargar generaciones
            'estudiantes' => $query->paginate($this->perPage)
        ]);
    }
    */

    //Renderiza el componente
    public function render()
    {
        /*
        $query = Estudiante::query();

        if ($this->search) {
            // Convertimos a minúsculas y quitamos acentos
            $normalized = mb_strtolower($this->search);
            $normalized = strtr($normalized, [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
                'ñ' => 'n', 'Ñ' => 'n'
            ]);

            // Dividimos por espacios
            $words = preg_split('/\s+/', trim($normalized));

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->where(function ($sub) use ($word) {
                        $sub
                            // Nombres (normalizados sin acentos)
                            ->where(DB::raw("
                                LOWER(
                                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                                        CONCAT_WS(' ', nombre1, nombre2, apellido1, apellido2),
                                        'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),
                                        'Á','a'),'É','e'),'Í','i'),'Ó','o'),'Ú','u')
                                    )
                            "), 'like', "%{$word}%")

                            // Búsqueda directa en matrícula, curp y email
                            ->orWhere('matricula_cuip', 'like', "%{$word}%")
                            ->orWhere('curp', 'like', "%{$word}%")
                            ->orWhere('correo_electronico', 'like', "%{$word}%");
                    });
                }
            });
        }
        */
  
        $query = Resguardo::query();

        if ($this->search) {
            $busqueda = ltrim($this->search, '0'); // quitar ceros de la izquierda
            $query->where('id', $busqueda);
        }

        return view('livewire.inventario-form', [
            'municipios' => Municipio::all(),
            'escolaridades' => Escolaridad::all(),
            'generaciones' => Generaciones::all(),
            'resguardos' => $query->paginate($this->perPage),
        ]);
    }

    #[On('saveUnsubscribetFromAnotherComponent')]
    public function saveUnsubscribeStudent($data){
        $dataFinalUnsubscribe = [
            'estatus' => 'BAJA',
            'fecha_baja' => $data['fechaBaja'],
            'idStudent' => $data['idStudent'],
        ];

        /*
        EstatusEstudiante::update
        $estudiante = Estudiante::findOrFail($data['idStudent']);
        $estudiante->update($dataFinalUnsubscribe);
        //$this->showModal = false;
        //$this->resetForm();
        */

        EstatusEstudiante::where('estudiante_id', $data['idStudent'])
            ->latest() // Ordena por el más reciente
            ->first()  // Obtiene el último
            ->update([
                'estatus' => 'BAJA',
                'fecha_baja' => $data['fechaBaja'],
                'motivo_baja' => $data['motivoBaja']
            ]);

        $this->showModal = false; // Cierra el modal
        $this->closeModal();
        
        $this->dispatch('alumno-updated', '¡Alumno dado de baja!'); 
    }

    // Guardar o actualizar estudiante    
    #[On('saveUpdateStudentFromAnotherComponent')]
    public function saveUpdateStudent($data){
        /*
        if (!$this->matricula_cuip) {
            $this->matricula_cuip = $this->generateMatricula();
        }

        if (!$this->cuip) {
            $this->cuip = $this->generate();
        }
        */

        /*
        //Este bloque de codigo sirve para agregar que cuando quiera editar el estudiante no tenga problema con que estos campos esten repetidos
        $this->rules['celular'] = 'required|string|size:10|unique:estudiantes,celular,' . $this->id_estudiante;
        $this->rules['curp'] = 'required|string|size:18|unique:estudiantes,curp,' . $this->id_estudiante;
        $this->rules['correo_electronico'] = 'required|email|unique:estudiantes,correo_electronico,' . $this->id_estudiante;        
        $this->rules['matricula_cuip'] = 'required|unique:estudiantes,matricula_cuip,' . $this->id_estudiante . '|min:20|max:20';        

        $this->validate();// Validamos los datos
        */        
        $dataFinalUpdate = [
            'nombre1' => $data['nombre1'],
            'nombre2' => $data['nombre2'],
            'apellido1' => $data['apellido1'],
            'apellido2' => $data['apellido2'],
            'matricula_cuip' => $data['matricula_cuip'],
            'municipio_id' => $this->municipio_procedencia,            
            'curp' => $data['curp'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'escolaridad_id' => $data['escolaridad_id'],                
            'genero' => $data['genero'],
            'correo_electronico' => $data['correo_electronico'],
            'celular' => $data['celular'],
            'cuip' => $data['cuip']                            
        ];
        
        $estudiante = Estudiante::findOrFail($this->id_estudiante);
        $estudiante->update($dataFinalUpdate);
        //$this->showModal = false;
        //$this->resetForm();

        $this->showModal = false; // Cierra el modal
        $this->closeModal();
        
        $this->dispatch('alumno-updated', '¡Alumno actualizado correctamente!');                
    }
    
    #[On('saveFromComponentNewStudent')] 
    public function saveNewStudent($data){ 
        
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

    #[On('saveUpdateCourseOfStudentFromAnotherComponent')]
    public function saveUpdateCourseOfStudent($data){
        $estudiante = Estudiante::find($data['id_estudiante']);
        //$estudiante->update($data);
        $tipo_de_curso = $data['type_of_course'];
        
        
        
        //AGREGAR EL MODIFICAR INSCRIPCIONES Y DEPENDIENDO EL TIPO DE CURSO LAS FECHAS DE INSCRIPCIONES O LAS FECHAS DE GENERACIONES
        //if($data['id_generacion']==1){
       //d($data);
        if($tipo_de_curso=="curso"){
            $informacion = [
                'curso_id' => $data['id_curso'],
                'grupo_id' => $data['id_grupo'],
                'adscripcion_id' => $data['id_adscripcion'],
                'sede_id' => $data['id_sede'],
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_final'],
                'fecha_validacion_inicial' => $data['fecha_validacion_id_inicial'],
                'fecha_validacion_final' => $data['fecha_validacion_id_final'],
                'fecha_de_ejecucion_inicial' => $data['fecha_ejecucion_id_inicial'],
                'fecha_de_ejecucion_final' => $data['fecha_ejecucion_id_final']
            ];
        }else{            
            $informacion = [
                'curso_id' => $data['id_curso'],
                'grupo_id' => $data['id_grupo'],
                'adscripcion_id' => $data['id_adscripcion'],
                'sede_id' => $data['id_sede'],     
                'generacion_id' => $data['id_generacion'],
                'fecha_inicio' => '2000-01-01',
                'fecha_fin' => '2000-01-01',
                'fecha_validacion_inicial' => $data['fecha_validacion_id_inicial'],
                'fecha_validacion_final' => $data['fecha_validacion_id_final'],
                'fecha_de_ejecucion_inicial' => $data['fecha_ejecucion_id_inicial'],
                'fecha_de_ejecucion_final' => $data['fecha_ejecucion_id_final']
            ];      
        }

        $id_of_inscripcion = $data['id_inscripcion'];
        $inscripcion = Inscripciones::find($id_of_inscripcion);
        $inscripcion->update($informacion);
        $this->showModal = false; // Cierra el modal
        $this->dispatch('alumno-updated', '!Inscripción actualizada correctamente!');
    }
    
    #[On('saveAssignCourse')]    
    public function save2($data)
    {        
        $dataInscripciones = Arr::except($data, ['institucion_id']);
        
        Inscripciones::create($dataInscripciones); 
        DB::table('cursos_instituciones')->insert(['curso_id' => $data['curso_id'],'institucion_id' => $data['institucion_id'],'created_at' => null,'updated_at' => null]);

                    
        $this->dispatch('alumno-created2', '¡Inscripción realizada con exito!');
        $this->resetForm(); // Limpia las propiedades del formulario
        $this->showModal = false; // Cierra el modal        
        
    }
    
    #[On('showUpdateAssigmentCourse')] 
    public function mostrarVentanaEditarAsigacionDeCurso(){
        $this->dispatch('showUpdateAssigmentCourse',1);
    }

    #[On('saveUpdateStudentFromAnotherComponentEvent')]
    public function showModalAllCertificados(){
        $this->showModal = true; // Controla el modal
    }
       
    #[On('actualizarcurso')]
    public function editCourse($data2)
    {        
        $this->id_estudiante = $data2['id_estudiante'];
        $this->id_curso = $data2['curso_id'];
        $this->id_grupo = $data2['grupo_id'];
        $this->id_adscripcion = $data2['adscripcion_id'];
        $this->id_sede = $data2['sede_id'];
        $this->id_generacion = $data2['generacion_id'];
        $this->fecha_inicio = $data2['fecha_inicio'];
        $this->fecha_terminacion = $data2['fecha_terminacion'];
        $this->id_inscripcion = $data2['id_inscripcion'];
        //dd($data2);
        $this->fecha_validacion_inicial = $data2['fecha_validacion_inicial'];
        $this->fecha_validacion_final = $data2['fecha_validacion_final'];
        $this->fecha_ejecucion_inicial = $data2['fecha_de_ejecucion_inicial'];
        $this->fecha_ejecucion_final = $data2['fecha_de_ejecucion_final'];
        
        //dd($data2);
        $this->data_external_component = $data2;        
        $this->accionPrincipal = "editar_curso";
    }

    #[On('dardebaja')]
    public function darDeBajaAlumno($data)
    {        
      
        $this->tituloModalPrincipal = "Baja de estudiante";
        $this->idEstudianteADarDeBaja = $data['idEstudiante'];

        if($data['verDetalles']=="true"){
            $this->tituloModalPrincipal = "Detalles baja de estudiante";
            $estudiante = Estudiante::find($this->idEstudianteADarDeBaja);
            //$this->fecha_baja = $estudiante->status->fecha_baja;

            //dd($estudiante->estatus[0]->fecha_baja);
            $this->fecha_baja = $estudiante->estatus[0]->fecha_baja;
            $this->motivo_baja =  $estudiante->estatus[0]->motivo_baja;
            //$this->motivo_baja = "MOTIVOS PERSONALES";
            //$this->fecha_baja = "2022-02-10";
            $this->accionPrincipal = "dar_de_baja_estudiante_detalles";
            //dd($this->motivo_baja);

        }else{
            $this->motivo_baja = "";
            $this->fecha_baja = "";
        }
        //dd("dardebajadesdestudent",$this->idEstudianteADarDeBaja);
        //$this->data_external_component = $data2;        
        $this->accionPrincipal = "dar_de_baja_estudiante";
    }

    #[On('municipio-seleccionado')]
    public function getIdOfMunicipality($municipio_id){        
        $this->municipio_procedencia = (int)$municipio_id['municipioId'];        
    }

    #[On('notifyCloseModal')]
    public function closeModalFromOtherComponent(){
        $this->showModal = false; // Cerrar el modal
    }

    #[On('downloadCertificateCall')]
    public function downloadCertificate($id,$idCurso,$nameOfCourse="")
    {
        //$this->dispatch('loading');    
        // Busca el estudiante con el ID proporcionado
        $student = Estudiante::findOrFail($id);
        //$this->nombreCurso = $student->inscripciones[0]->cursos->nombre_curso;
        $this->nombreCurso = $nameOfCourse;
        $curso = Cursos::find($idCurso);
        $urlCurso = $curso->instituciones->first();
        
        if(empty($urlCurso->url_imagen)){
            $nameImage = "logocircularieesspp.png";
        }else{
            $nameImage = $urlCurso->url_imagen;
        }
        
        if($curso->type_of_course == "programa"){
            $fecha_inicio = $student->inscripciones[0]->generaciones->fecha_inicio;
            $fecha_fin = $student->inscripciones[0]->generaciones->fecha_terminacion;
        }else{
            $fecha_inicio = $curso->inscripciones[0]->fecha_inicio;
            $fecha_fin = $curso->inscripciones[0]->fecha_fin;
        }

        $fecha_inicio_formateada = Carbon::parse($fecha_inicio)->format('d-m-Y');
        $fecha_final_formateada = Carbon::parse($fecha_fin)->format('d-m-Y');   


        // Parsear las fechas como objetos Carbon
        $fechaInicio = Carbon::parse($fecha_inicio); 
        $fechaFin = Carbon::parse($fecha_fin); 

        // Establecer el locale para español
        $fechaInicio->locale('es'); 
        $fechaFin->locale('es');

        // Mapeo de los meses en inglés a español
        $mesesEnEspañol = [
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre',
        ];

        // Usar Carbon para formatear las fechas a la estructura deseada en texto
        $inicioFormateado = $fechaInicio->format('d \de F \de Y'); // 01 de enero de 2024
        $finFormateado = $fechaFin->format('d \de F \de Y'); // 30 de junio de 2024

        // Traducir los meses usando el arreglo de meses en español
        $mesInicioEspañol = $mesesEnEspañol[$fechaInicio->format('F')] ?? $fechaInicio->format('F');
        $mesFinEspañol = $mesesEnEspañol[$fechaFin->format('F')] ?? $fechaFin->format('F');

        // Usar NumberToWords para convertir los números a palabras
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es');
        $inicioDiaEnPalabras = $numberTransformer->toWords($fechaInicio->day);
        $finDiaEnPalabras = $numberTransformer->toWords($fechaFin->day);
        $anioEnPalabras = $numberTransformer->toWords($fechaInicio->year);

        // Ajustar para que el día 1 sea "primero" en lugar de "uno"
        if ($fechaInicio->day == 1) {
            $inicioDiaEnPalabras = 'primero';
        }
        if ($fechaFin->day == 1) {
            $finDiaEnPalabras = 'primero';
        }

        // Crear el formato final con los días en palabras y las fechas formateadas
        $textoFinalFecha = $fechaInicio->format('d') . ' (' . strtolower($inicioDiaEnPalabras) . ') de ' . $mesInicioEspañol . 
            ' al ' . $fechaFin->format('d') . ' (' . strtolower($finDiaEnPalabras) . ') de ' . $mesFinEspañol . 
            ' de ' . $fechaInicio->year . ' (' . ucfirst($anioEnPalabras) . ')'; // Agregar el año numérico y en palabras al final



        //CONVERTIR HORAS DEL CURSO A TEXTO
        // Usar NumberToWords para convertir el número a palabras
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es');
        $numeroEnPalabras = $numberTransformer->toWords($curso->duracion_en_horas);

        // Convertir el número a formato con comas (para separadores de miles)
        $numeroConComas = number_format($curso->duracion_en_horas, 0, '', ','); // Esto convertirá 1080 en "1,080"

        // Crear el resultado final
        $textoFinalHorasCurso = $numeroConComas . ' (' . strtolower($numeroEnPalabras) . ') horas clase.';


        $this->cuip = $student->cuip;

        $meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        
        $fecha = date('d');
        $mes = $meses[(int)date('m') - 1];  // Resta 1 ya que los índices de los meses comienzan desde 0
        $año = date('Y');
        
        $this->lugar = "Morelia, Michoacán, a {$fecha} de {$mes} de {$año}.";


        // Prepara los datos para la plantilla del PDF
        $data = [
            'name' => "{$student->nombre1} {$student->nombre2} {$student->apellido1} {$student->apellido2}",
            'course' => $this->nombreCurso, // Curso asignado al estudiante
            'fecha_inicio' => $fecha_inicio_formateada,
            'fecha_fin' => $fecha_final_formateada,            
            //'qr' => $qrBase64,
            'duracion' => $curso->duracion_en_horas,
            'textoFinalFecha' => $textoFinalFecha,
            'textoFinalHorasCurso' => $textoFinalHorasCurso,
            'nameImage' => $nameImage,
            'cuip' => $this->cuip,
            'lugar' => $this->lugar 
        ];    

        // Genera el PDF con la vista 'pdfs.certificate' y los datos
        if($curso->type_of_course == "programa"){        
            $pdf = Pdf::loadView('pdfs.certificate', $data);
        }else{
            $pdf = Pdf::loadView('pdfs.certificate2', $data);
        }
        //$this->dispatch('loading');    
        $this->dispatch('closeloadingcertificates');    


        // Retorna el PDF como descarga
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "{$student->apellido1} {$student->apellido2} {$student->nombre1} {$student->nombre2} certificado.pdf"                             
        );        
    
        

    }



}
