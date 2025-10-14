<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nueva Marca  -->
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
                    {{--EDITAR MARCA--}}
                    @case("editar_curso")
                        @livewire('update-assigment-course',['data'=>$data_external_component])               
                    @break 
                    
                    {{--CREAR NUEVA MARCA--}}
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
                <label for="searchid">Da clic en el buscador y escribe el nombre de la Marca y luego presiona “Buscar”</label>
                <input type="text" id="searchid" placeholder="Buscador" wire:keydown.enter="searchMarcas" wire:model="search"  class="form-control" />
                <button class="btn btn-primary" wire:click="searchMarcas">
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
                <th scope="col">MARCA</th>
                <th scope="col">ACCIONES</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($marcas as $marca)
                <tr>
                    <td>{{$marca->id}}</td>
                    <td>{{$marca->nombre}}</td>
                    <td>
                        <button class="btn btn-primary">EDITAR</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">No se encontro marcas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $marcas->links() }}
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