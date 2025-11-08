<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nueva Marca  -->
    <div class="row">
        <div class="col d-flex justify-content-end">   
            @can('areadeasignacion.create')               
            <button wire:click="showModalNewAreaDeAsignacion" class="btn btn-primary mb-3 fa">                        
                <i class="fas fa-plus"></i>
                Agregar Área de Asignación            
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
                    {{--EDITAR ÁREA DE ASIGNACIÓN--}}
                    @case("editar")
                        @livewire('update-marca',['data'=>$data_external_component])     
                    @break 

                    {{--CREAR NUEVA ÁREA DE ASIGNACIÓN--}}
                    @default
                        @livewire('create-new-area-de-asignacion')
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
                <label for="searchid">Da clic en el Buscador y escribe el nombre de la área de asignación y luego presiona “Buscar”</label>
                <input type="text" id="searchid" placeholder="Buscador" wire:keydown.enter="searchAreasDeAsignacion" wire:model="search" oninput="this.value = this.value.toUpperCase()" class="form-control" />
                <button class="btn btn-primary" wire:click="searchAreasDeAsignacion">
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
                <th scope="col">ÁREA DE ASIGNACIÓN</th>
                <th scope="col">ACCIONES</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($areasdeasignacion as $areadeasignacion)
                <tr>
                    <td>{{$areadeasignacion->id}}</td>
                    <td>{{$areadeasignacion->nombre}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="cambiarAccion('editar',{{ $areadeasignacion->id }})">
                            <i class="fas fa-edit"></i> EDITAR
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">No se encontro áreas de asignación.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $areasdeasignacion->links() }}
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
                    text: '!Área de asignación registrada con exito!',
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
                    text: '!Área de asignación actualizada con éxito!',
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