<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nuevo Inventario  -->
    <div class="row">
        <div class="col d-flex justify-content-end">   
            @can('alumnos.create')               
            <button wire:click="showModalNewResguardo" class="btn btn-primary mb-3 fa">                        
                <i class="fas fa-plus"></i>
                Agregar inventario            
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
                    @case("addNewResguardo")                    
                        @livewire('add-new-resguardo',['data'=>$data_external_component])                                       
                    @break

                    {{--MOSTRAR HISTORIAL RESGUARDO--}}
                    @case("showHistorialResguardo")                    
                        @livewire('show-resguardos-modal',['data'=>$data_external_component])                              
                    @break

                    {{--DAR DE BAJA ESTUDIANTE--}}
                    @case("dar_de_baja_estudiante")
                        @livewire('unsubscribe-student',['student' => $student,'motivo_baja' => $motivo_baja,'fecha_baja' => $fecha_baja])                                  
                    @break    

                    {{--VER DETALLES DE BAJA ESTUDIANTE--}}
                    @case("dar_de_baja_estudiante_detalles")
                        @livewire('unsubscribe-student',['student' => $student,'motivo_baja' => $motivo_baja,'fecha_baja' => $fecha_baja])                                  
                    @break 
                    
                    {{--EDITAR RESGUARDO--}}
                    @case("editar")
                        @livewire('update-resguardo',['data'=>$data_external_component])               
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
                <label for="searchid">Da clic en el Buscador, escanea o escribe el No. de inventario y luego presiona “Buscar”</label>
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
                    <th scope="col">Id</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Equipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>

                    <th scope="col">Serie</th>
                    <!--
                    <th scope="col">Inventario</th>
                 
                    <th scope="col">CUIP</th>
                    <th scope="col">NO. DE RESGUARDO</th>
                    -->
                    <th scope="col">Estado</th>                      
                    <th scope="col">Área</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Resguardante</th>
                    <!--
                    <th scope="col">Puesto</th>
          
                    <th scope="col">N° DE INVENTARIO ACTUALIZADO</th>
                    -->
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resguardos as $resguardo)
                    <tr>
                        <td>
                            {{ $resguardo->id }}
                        </td>
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
                        

         
                        {{--
                        <td class="text-center">
                            @if($resguardo->historial[0]->resguardo_pdf != null)
                                <div class="mt-2">
                                    <a href="{{ Storage::url($resguardo->resguardo_pdf) }}" target="_blank">
                                        Descargar Inventario No. {{ $resguardo->id }}
                                        
                                        ({{ $histo->fecha_asignacion->format('d/m/Y H:i') }})
                                       
                                    </a>
                                </div>
                            @else
                                <button wire:click="showModalNewStudent" class="btn btn-warning btn-sm mt-1 mb-1">            
                                    <i class="fas fa-upload"></i> Subir
                                </button>
                            @endif
                        </td>
                        --}}


                        <td>{{ strtoupper(optional($resguardo->historial->last()->estadouso)->estado) }}</td>
                   
                        <td>{{ $resguardo->historial->last()->areaDeUso->nombre }}</td>
                        <td>{{ $resguardo->historial->last()->ubicacionFisica->descripcion }}</td>

                         
                        <td>
                            @if($resguardo->historial->last())
                            <a href="{{ asset('storage/' . $resguardo->historial) }}" target="_blank">
                                {{--
                                <img src="{{ asset('storage/' . $resguardo->historial) }}" 
                                    alt="Imagen del producto" 
                                    class="img-thumbnail" 
                                    width="100">
                                --}}
                            </a>
                            @else
                                {{strtoupper(optional($resguardo->historial->last()->ubicacionFisica)->descripcion)}}<br>
                            @endif
                        </td>
                        <td><a href="{{ route('resguardante.show', $resguardo->resguardante->id) }}">{{strtoupper(optional($resguardo->historial->last()->resguardante)->nombre1)}} {{strtoupper(optional($resguardo->historial->last()->resguardante)->nombre2)}} {{strtoupper(optional($resguardo->historial->last()->resguardante)->apellido1)}} {{strtoupper(optional($resguardo->historial->last()->resguardante)->apellido2)}}</a></td>
                        <!--
                        <td>{{ strtoupper($resguardo->puesto->nombre) }}</td>
                        !-->
                        <td class="w-100">   
                            
                            <button wire:click="cambiarAccion('editar',{{ $resguardo->id }})" class="btn btn-warning btn-sm mt-1 mb-1">                            
                                <i class="fas fa-edit"></i> Editar
                            </button>
                              
                            <button wire:click="cambiarAccion('showHistorialResguardo',{{ $resguardo->id }})" class="btn btn-dark btn-sm mt-1 mb-1">                            
                                <i class="fas fa-eye"></i> Ver resguardos
                            </button>
                            <button wire:click="" class="btn btn-danger btn-sm mt-1 mb-1">                            
                                <i class="fas fa-trash"></i> Dar de baja inventario
                            </button>  
                            <button wire:click="cambiarAccion('addNewResguardo',{{ $resguardo->id }})"  class="btn btn-primary btn-sm mt-1 mb-1">                            
                                <i class="fas fa-plus"></i> Agregar resguardo
                            </button>  
                            <button wire:click="downloadEtiqueta({{ $resguardo->id }})" class="btn btn-success btn-sm mt-1 mb-1">            
                                <i class="fas fa-download"></i> Descargar etiqueta
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
    @if(request()->has('search'))
    <script>
        // Espera un segundo y luego limpia el parámetro de la URL visualmente
        setTimeout(() => {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.history.replaceState({}, document.title, url.pathname);
        }, 1000);
    </script>
    @endif
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


