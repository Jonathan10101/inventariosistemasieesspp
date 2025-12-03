<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nueva Marca  -->
    <div class="row">
        <div class="col d-flex justify-content-end">   
            @hasanyrole('Administrador|Delegacion|Subdirector')                             
            <button wire:click="showModalNewPuesto" class="btn btn-primary mb-3 fa" style="background-color:#171C63; border:none;">                        
                <i class="fas fa-plus"></i>
                Agregar puesto           
            </button>  
            @endhasanyrole      
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
                    {{--EDITAR MARCA--}}
                    @case("editar")
                        @livewire('update-puesto',['data'=>$data_external_component])     
                    @break 

                    {{--CREAR NUEVA MARCA--}}
                    @default
                        @livewire('create-new-puesto') 
                    @break                    
                @endswitch

                <div class="modal-footer">                           
                </div>

            </div>
        </div>
    </div>


    <!-- Buscador -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark">Da clic en el Buscador y escribe el nombre del Puesto y luego presiona “Buscar”</label>
            <div class="input-group shadow-sm">
                <input type="text" id="searchid" placeholder="Buscador ..." 
                       wire:keydown.enter="searchPuestos" wire:model="search" style="border:none; text-transform: uppercase;" class="form-control border-end-0">
                <button class="btn btn-primary" style="background-color:#171C63; border:none;text-transform: uppercase;" wire:click="Puestos">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if($search)
                <button class="btn btn-outline-secondary" wire:click="clearSearch">
                    <i class="fas fa-times"></i>
                </button>
                @endif
            </div>
        </div>
    </div>


    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">PUESTO</th>

                @hasanyrole('Administrador')
                    <th scope="col">ACCIONES</th>
                @endhasanyrole

            </tr>
        </thead>

        <tbody>
            @forelse ($puestos as $puesto)
                <tr>
                    <td>{{ $puesto->id }}</td>
                    <td>{{ $puesto->nombre }}</td>

                    @hasanyrole('Administrador')
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    wire:click="cambiarAccion('editar', {{ $puesto->id }})"
                                    title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    @endhasanyrole

                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center">No se encontraron puestos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $puestos->links() }}
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
                    text: '!Puesto registrado con exito!',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false, // Deshabilita clics fuera del modal
                    allowEscapeKey: false,   // Deshabilita la tecla Escape
                    allowEnterKey: false,     // Deshabilita la tecla Enter
                    customClass: {
                        confirmButton: 'btn-ieesspp' // Clase personalizada
                    },
                    buttonsStyling: false // Permite que la clase personalizada sobrescriba estilos de SweetAlert
                }).then((result) => {
                       if (result.isConfirmed) {
                            window.location.reload();     
                        }    
                });                
            });   

            Livewire.on('alumno-updated',function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: '!Puesto actualizado con éxito!',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                     allowOutsideClick: false, // Deshabilita clics fuera del modal
                    allowEscapeKey: false,   // Deshabilita la tecla Escape
                    allowEnterKey: false,     // Deshabilita la tecla Enter
                    customClass: {
                        confirmButton: 'btn-ieesspp' // Clase personalizada
                    },
                    buttonsStyling: false // Permite que la clase personalizada sobrescriba estilos de SweetAlert
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