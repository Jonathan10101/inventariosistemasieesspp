<div class="container mt-4">
    <!-- Agregar SweetAlert2 CDN en tu archivo Blade -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Add nueva Área de asignación  -->
    <div class="row">
        <div class="col d-flex justify-content-end">
            {{--   
            @can('areadeasignacion.create')               
            <button wire:click="showModalNewAreaDeAsignacion" class="btn btn-primary mb-3 fa" >                        
                <i class="fas fa-plus"></i>
                Agregar Área de Asignación            
            </button>  
            @endcan     
            --}}     
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
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark">Da clic en el Buscador y escribe el nombre de asignación y luego presiona “Buscar”</label>
            <div class="input-group shadow-sm">
                <input disabled type="text" id="searchid" placeholder="Buscador ..." 
                       wire:keydown.enter="searchAreasDeAsignacion" wire:model="search" style="text-transform: uppercase;" class="form-control border-end-0">
                <button disabled class="btn btn-primary" style="background-color:#171C63; border:none;" wire:click="searchUsearchAreasDeAsignacionbicacionesFisicas">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if($search)
                <button  class="btn btn-outline-secondary" wire:click="clearSearch">
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
                <th scope="col">ÁREA DE ASIGNACIÓN</th>
                {{--
                <th scope="col">ACCIONES</th>
                --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($areasdeasignacion as $areadeasignacion)
                <tr>
                    <td>{{$areadeasignacion->id}}</td>
                    <td>{{$areadeasignacion->nombre}}</td>
                    {{--
                    <td>
                        
                        <button class="btn btn-warning btn-sm" wire:click="cambiarAccion('editar',{{ $areadeasignacion->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                    </td>
                    --}}
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">No se encontraron áreas de asignación.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $areasdeasignacion->links() }}
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
    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
@endpush
</div>