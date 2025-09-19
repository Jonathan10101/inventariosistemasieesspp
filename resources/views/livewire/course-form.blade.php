<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    
    <!-- Add nuevo Curso  -->
    <div class="row">
        <div class="col d-flex justify-content-end">           
            @can('cursos.create') 
            <button wire:click="showModalNewCourse" class="btn btn-primary mb-3 fa">                        
                <i class="fas fa-plus"></i>
                Agregar            
            </button>          
            @endcan  
        </div>
    </div>

    <!--ESTE COMPONENTE TIENE LA LOGICA PARA MOSTRAL MODAL DE VENTANA EMERGENTE-->
    <div class="modal fade @if($showModal) show @endif" style="display: @if($showModal) block @else none @endif; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">                    
                    <h5 class="modal-title w-100" id="studentModalLabel">  
                        {{$tituloModalPrincipal}}                                                 
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>                    
                </div>

                @switch($accionPrincipal)
                    {{--EDITAR CURSO--}}                    
                    @case("editar")
                        @livewire('update-course',['course'=>$course])                                                                    
                    @break                                             
                    {{--CREAR NUEVO CURSO--}}
                    @default
                        @livewire('create-new-course') 
                    @break                    
                @endswitch

           
                <div class="modal-footer">                           
                </div>

            </div>
        </div>
    </div>
    

    <!-- Buscador -->
    <div class="row mb-3">
        <div class="col-md-6">            
            <div class="input-group">
                <input type="text" id="search" wire:model="search" placeholder="Buscar por nombre" class="form-control" />
                <button class="btn btn-primary" wire:click="searchCourses">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if($search)
                    <button class="btn btn-secondary" wire:click="clearSearch" style="border-left: none;">
                        <i class="fas fa-times"></i> <!-- Icono de borrar -->
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabla de estudiantes -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>                                        
                    <th scope="col">NOMBRE DEL CURSO</th>                    
                    <th scope="col">DURACIÓN (HORAS)</th>                    
                    <th scope="col">TIPO DE CURSO</th>                    
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @if($cursos)                
                @forelse ($cursos as $curso)
                    <tr>
                        <td>{{ $curso->nombre_curso }}</td>                        
                        <td>{{ $curso->duracion_en_horas }}</td>        
                        <td>{{ $curso->type_of_course  }}</td>      
                        
                        <td>
                            @can('cursos.edit')
                            <button class="btn btn-primary btn-sm mt-1 mb-1" wire:click="cambiarAccion('editar',{{ $curso->id }})">                            
                                <i class="fas fa-edit"></i>Editar
                            </button>     
                            @endcan
                            @can('cursos.destroy')
                            <button   id="delete-btn-{{ $curso->id }}" class="btn btn-danger btn-sm mt-1 mb-1" wire:click="accionEjecutada('borrarAlert', {{ $curso->id }})">
                                <i class="fas fa-trash-alt"></i> Borrar
                            </button>
    
                            <button  id="btnDestroy-{{ $curso->id }}" class="btn btn-danger btn-sm mt-1 mb-1 d-none" wire:click="cambiarAccion('borrar',{{ $curso->id }})">                            
                                <i class="fas fa-edit"></i>Borrar
                            </button>     
                            @endcan
                        </td>
                        
                        {{--
                        <td class="w-100">                                                        
                            <button  wire:click="cambiarAccion('inscripcion_a_curso',{{$estudiante->id}})" class="btn btn-dark btn-sm mt-1 mb-1">                           
                                <i class="fas fa-hand-pointer"></i> Asignar
                            </button>
                            <button wire:click="cambiarAccion('editar',{{ $estudiante->id }})" class="btn btn-primary btn-sm mt-1 mb-1">                            
                                <i class="fas fa-edit"></i>Editar
                            </button>                            
                            
                            @if(isset($estudiante->inscripciones[0]) && $estudiante->inscripciones[0]->cursos)                            
                            <button  wire:click="cambiarAccion('mostrar_certificados',{{ $estudiante->id }})" class="btn btn-warning btn-sm mt-1 mb-1">                                                                                            
                                <i class="fas fa-download"></i> Certificados
                            </button>
                            @endif                                                                                                        
                        </td>
                        --}}                         
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No se encontraron cursos.</td>
                    </tr>
                @endforelse
                @endif
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $cursos->links() }}
    </div>


@push('js')
@livewireScripts
    <script>
      
        document.addEventListener('livewire:initialized',function(){    
                               

            Livewire.on('refresh-page',function($message){                
                //window.location.reload();

            }); 
            Livewire.on('course-created',function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: $message,
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false, // Deshabilita clics fuera del modal
                    allowEscapeKey: false,   // Deshabilita la tecla Escape
                    allowEnterKey: false     // Deshabilita la tecla Enter
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });                
            });         
            Livewire.on('alumno-updated',function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: $message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });                
            });  

            /*
            Livewire.on('course-destroy',function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: $message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });                
            }); 
            */


            Livewire.on('course-destroy-alert', function ($courseId) {             
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción es irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, eliminar!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Obtén el botón por su ID
            //var buttonDestroy = document.getElementById('btnDestroy');
            // Simula un clic en el botón
            //buttonDestroy.click();
            document.getElementById('btnDestroy-' + $courseId).click(); // Usan
            
            //Livewire.emit('borrar', $courseId); // Llamará al método 'borrar' en Livewire
            //window.Livewire.emit('borrar', $courseId); 



            // Muestra el mensaje de éxito
            Swal.fire({
                title: "¡Eliminado!",
                text: "El curso ha sido eliminado.",
                icon: "success"
            });
        }
    });
});






            Livewire.on('loading',function($message){//Inicio                
                let timerInterval;
                Swal.fire({
                    title: "Generando certificado",
                    html: "",
                    timer: 1000,
                    timerProgressBar: true,
                didOpen: () => {
                Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                    willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
                });             
            });//Fin                     
                        
        });
    </script>
@endpush
</div>


