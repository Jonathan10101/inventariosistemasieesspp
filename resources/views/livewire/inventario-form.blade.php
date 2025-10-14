<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nuevo Inventario  -->
    <div class="row">
        <div class="col d-flex justify-content-end">   
            @can('alumnos.create')               
            <button wire:click="showModalNewStudent" class="btn btn-primary mb-3 fa">                        
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
                    {{--REALIZAR INSCRIPCIÓN A CURSO O PROGRAMA--}}
                    @case("inscripcion_a_curso")                    
                        @livewire('assign-course',
                            ['student'=>$student,'inscripciones'=>$inscripciones,'cursos'=>$cursos,'grupos'=>$grupos,
                            'adscripciones'=>$adscripciones,'sedes'=>$sedes,'generacionesv2'=>$generacionesv2,'instituciones' => $instituciones])                                       
                    @break

                    {{--MOSTRAR CERTIFICADOS--}}
                    @case("mostrar_certificados")                    
                        @livewire('show-certificates',['student'=>$student,'inscripciones'=>$inscripciones])                                       
                    @break

                    {{--EDITAR ESTUDIANTE--}}
                    @case("editar")
                        @livewire('update-modal',
                        ['student'=>$student,'inscripciones'=>$inscripciones,'cursos'=>$cursos,'grupos'=>$grupos,
                            'adscripciones'=>$adscripciones,'sedes'=>$sedes,'generacionesv2'=>$generacionesv2])                                        
                    @break    
                    
                    {{--DAR DE BAJA ESTUDIANTE--}}
                    @case("dar_de_baja_estudiante")
                        @livewire('unsubscribe-student',['student' => $student,'motivo_baja' => $motivo_baja,'fecha_baja' => $fecha_baja])                                  
                    @break    

                    {{--VER DETALLES DE BAJA ESTUDIANTE--}}
                    @case("dar_de_baja_estudiante_detalles")
                        @livewire('unsubscribe-student',['student' => $student,'motivo_baja' => $motivo_baja,'fecha_baja' => $fecha_baja])                                  
                    @break 
                    
                    {{--EDITAR CURSO--}}
                    @case("editar_curso")
                        @livewire('update-assigment-course',['data'=>$data_external_component])               
                    @break 
                    
                    {{--CREAR NUEVO RESGUARDO--}}
                    @default
                        @livewire('create-new-resguardo') 
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
                <label for="searchid">Da clic en el buscador, escanea o escribe el No. de inventario y luego presiona “Buscar”</label>
                <input type="text" id="searchid" placeholder="Buscador" wire:keydown.enter="searchResguardos" wire:model="search"  class="form-control" />
                <button class="btn btn-primary" wire:click="searchResguardos">
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
                    <th scope="col">IMAGEN</th>
                    <th scope="col">DESCRIPCIÓN</th>
                    <th scope="col">MARCA</th>
                    <th scope="col">MODELO</th>

                    <th scope="col">NO. DE SERIE</th>
                    
                    <th scope="col">NO. DE INVENTARIO</th>
                    <!--
                    <th scope="col">CUIP</th>
                    <th scope="col">NO. DE RESGUARDO</th>
                    -->
                    <th scope="col">ESTADO DE USO</th>                      
                    <th scope="col">ÁREA DE ASIGNACIÓN</th>
                    <th scope="col">UBICACIÓN FISICA</th>
                    <th scope="col">NOMBRE USUARIO RESGUARDANTE</th>
                    <th scope="col">PUESTO USUARIO RESGUARDANTE</th>
                    <!--
                    <th scope="col">N° DE INVENTARIO ACTUALIZADO</th>
                    -->
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resguardos as $resguardo)
                    <tr>
                        <td>
                        @if($resguardo->imagen)
                        <a href="{{ asset('storage/' . $resguardo->imagen) }}" target="_blank">
                            <img src="{{ asset('storage/' . $resguardo->imagen) }}" 
                                alt="Imagen del producto" 
                                class="img-thumbnail" 
                                width="100">
                        </a>
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                        </td>

                        <td>{{ $resguardo->descripcion }}</td>
                        <td>{{ $resguardo->marca->nombre }}</td>
                        <td>{{ $resguardo->modelo }}</td>
                        <td>{{ $resguardo->nserie }}</td>
                        
                        <td class="text-center">
                            @if($resguardo->resguardo_pdf)
                                {{ $resguardo->id }}
                                <a href="{{ Storage::url($resguardo->resguardo_pdf) }}" target="_blank">
                                    <br>
                                    Descargar
                                </a>
                            @else
                                {{ $resguardo->id }}
                                <button wire:click="showModalNewStudent" class="btn btn-danger mb-3 fa">                        
                                    <i class="fas fa-upload"></i>
                                    Subir resguardo            
                                </button> 
                            @endif 
                        </td>

                        <td>{{ strtoupper($resguardo->estadouso->estado) }}</td>
                        <td>{{ $resguardo->areadeasignacion->nombre }}</td>
                        <td>
                            {{ $resguardo->ubicacionFisica->descripcion }}<br>
                            @if($resguardo->ubicacionFisica->imagen)
                            <a href="{{ asset('storage/' . $resguardo->ubicacionFisica->imagen) }}" target="_blank">
                                Ver imagen   
                                {{--
                                <img src="{{ asset('storage/' . $resguardo->ubicacionFisica->imagen) }}" 
                                    alt="Imagen del producto" 
                                    class="img-thumbnail" 
                                    width="100">
                                --}}
                            </a>
                            @endif
                        </td>
                        <td><a href="{{ route('resguardante.show', $resguardo->resguardante->id) }}">{{$resguardo->resguardante->nombre1}} {{$resguardo->resguardante->nombre2}} {{$resguardo->resguardante->apellido1}} {{$resguardo->resguardante->apellido2}}</a></td>
                        <td>{{ strtoupper($resguardo->puesto->nombre) }}</td>

                        <td class="w-100">    
                            <button wire:click="cambiarAccion('editar',{{ $resguardo->id }})" class="btn btn-primary btn-sm mt-1 mb-1">                            
                                <i class="fas fa-edit"></i>Editar resguardo
                            </button>  
                            {{--
                            @can('alumnos.edit')   
                            <button wire:click="cambiarAccion('editar',{{ $resguardo->id }})" class="btn btn-primary btn-sm mt-1 mb-1">                            
                                <i class="fas fa-edit"></i>Editar
                            </button>  
                            @endcan
                            --}}                                                                                              
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">No se encontro inventario.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $resguardos->links() }}
    </div>


@push('js')
@livewireScripts
    <script>
        document.addEventListener('livewire:initialized',function(){    
            Livewire.on('refresh-page',function($message){                
                //window.location.reload();
                location.reload(); // Recarga la página completa
                //alert("x");
            }); 

            Livewire.on('alumno-created',function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: '!Resguardo registrado con exito!',
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
        });
    </script>
@endpush
</div>


