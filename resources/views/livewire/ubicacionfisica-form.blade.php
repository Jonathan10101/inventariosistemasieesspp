<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nueva Marca  -->
    <div class="row">
        <div class="col d-flex justify-content-end">   
            @can('ubicacionfisica.create')               
            <button wire:click="showModalNewUbicacionFisica" class="btn btn-primary mb-3 fa">                        
                <i class="fas fa-plus"></i>
                Agregar ubicación fisica            
            </button>  
            @endcan          
        </div>
    </div>

    <!--ESTE COMPONENTE TIENE LA LOGICA PARA MOSTRAL MODAL DE VENTANA EMERGENTE-->
    <div class="modal fade @if($showModal) show @endif" style="display: @if($showModal) block @else none @endif; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color:#171C63;">
                    <h5 class="modal-title w-100 fw-bold" id="studentModalLabel">{{$tituloModalPrincipal}}</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>                    
                </div>
  
                @switch($accionPrincipal)        
                    {{--EDITAR UBICACIÓN FISICA--}}
                    @case("editar")
                        @livewire('update-ubicacion-fisica',['data'=>$data_external_component])     
                    @break 

                    {{--CREAR NUEVA UBICACIÓN FISICA--}}
                    @default
                        @livewire('create-new-ubicacionfisica') 
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
                <label for="searchid">Da clic en el Buscador, escanea o escribe el nombre de la Ubicación Física y luego presiona “Buscar”</label>
                <input type="text" id="searchid" placeholder="Buscador" wire:keydown.enter="searchUbicacionesFisicas" wire:model="search" oninput="this.value = this.value.toUpperCase()" class="form-control" />
                <button class="btn btn-primary" wire:click="searchUbicacionesFisicas">
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


        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">IMAGEN</th>
                <th scope="col">UBICACIÓN FÍSICA</th>
                <th scope="col">ACCIONES</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($ubicacionesfisicas as $ubicacion)
                <tr>
                    <td>{{$ubicacion->id}}</td>
                    <td>
                    @if($ubicacion->imagen)
                        <a href="{{ asset('storage/' . $ubicacion->imagen) }}" target="_blank">
                            <img src="{{ asset('storage/' . $ubicacion->imagen) }}" 
                                alt="Imagen de la ubicación" 
                                class="img-thumbnail border zoom-image" 
                                width="100">
                        </a>
                    @else
                            <span class="text-muted">Sin imagen</span>
                    @endif
                    </td>

                    <td>{{$ubicacion->descripcion}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="cambiarAccion('editar',{{ $ubicacion->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <button wire:click="downloadEtiqueta({{ $ubicacion->id }})" class="btn btn-success btn-sm mt-1 mb-1" title="Descargar etiqueta">            
                            <i class="fas fa-download"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">No se encontro ubicaciones fisicas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $ubicacionesfisicas->links() }}
    </div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/ieessppformtable.css') }}">
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
                    text: '!Ubicación fisica registrada con exito!',
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
                    text: '!Ubicación fisica actualizada con éxito!',
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