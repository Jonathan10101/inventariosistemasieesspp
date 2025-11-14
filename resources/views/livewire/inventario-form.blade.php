<div class="container mt-4">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- Botón Agregar Inventario -->
    <div class="row mb-3">
        <div class="col d-flex justify-content-end">   
            @can('inventario.create')               
            <button wire:click="showModalNewResguardo" class="btn btn-primary shadow-sm" style="background-color:#171C63; border:none;">                        
                <i class="fas fa-plus me-1"></i> Agregar inventario            
            </button>  
            @endcan          
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade @if($showModal) show @endif"
        style="display:@if($showModal) block @else none @endif; background-color:rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header text-white" style="background-color:#171C63;">
                    <h5 class="modal-title w-100 fw-bold" id="studentModalLabel">{{$tituloModalPrincipal}}</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>                    
                </div>

                @switch($accionPrincipal)
                    @case("addNewResguardo")                    
                        @livewire('add-new-resguardo',['data'=>$data_external_component])                                       
                    @break
                    @case("showHistorialResguardo")                    
                        @livewire('show-resguardos-modal',['data'=>$data_external_component])                              
                    @break
                    @case("dar_de_baja_estudiante")
                        @livewire('unsubscribe-student',['student'=>$student,'motivo_baja'=>$motivo_baja,'fecha_baja'=>$fecha_baja])                                  
                    @break    
                    @case("dar_de_baja_estudiante_detalles")
                        @livewire('unsubscribe-student',['student'=>$student,'motivo_baja'=>$motivo_baja,'fecha_baja'=>$fecha_baja])                                  
                    @break 
                    @case("editar")
                        @livewire('update-resguardo',['data'=>$data_external_component])               
                    @break 
                    @default
                        @livewire('create-new-resguardo') 
                    @break                    
                @endswitch
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- Buscador -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark">Da clic en el Buscador, escanea o escribe el No. de Inventario y luego presiona “Buscar”</label>
            <div class="input-group shadow-sm">
                <input type="text" id="searchid" placeholder="Buscador ..." 
                       wire:keydown.enter="searchResguardos" wire:model="search" class="form-control border-end-0">
                <button class="btn btn-primary" style="background-color:#171C63; border:none;" wire:click="searchResguardos">
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

    <!-- Tabla -->
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="background-color:#F9FAFF;">
                    <thead style="background-color:#171C63; color:white;">
                        <tr>           
                            <th>Id</th>
                            <th>Imagen</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Estado</th>                      
                            <th>Área</th>
                            <th>Ubicación</th>
                            <th>Resguardante</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resguardos as $resguardo)
                            <tr>
                                <td>{{ $resguardo->id }}</td>
                                <td>
                                    @if($resguardo->imagen)
                                        <a href="{{ asset('storage/' . $resguardo->imagen) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $resguardo->imagen) }}" 
                                                alt="Imagen del producto" class="img-thumbnail border zoom-image" width="90">
                                        </a>
                                    @else
                                        <span class="text-muted">Sin imagen</span>
                                    @endif
                                </td>
                                <td>{{ $resguardo->descripcion }}</td>
                                <td>{{ $resguardo->marca->nombre }}</td>
                                <td>{{ $resguardo->modelo }}</td>
                                <td>{{ $resguardo->nserie }}</td>
                                <td><span class="badge rounded-pill bg-{{ strtoupper(optional($resguardo->historial->last()->estadouso)->estado) == 'ACTIVO' ? 'success' : 'secondary' }}">{{ strtoupper(optional($resguardo->historial->last()->estadouso)->estado) }}</span></td>
                                <td>{{ $resguardo->historial->last()->areaDeUso->nombre }}</td>
                                <td>
                                    @if($resguardo->historial->last() && $resguardo->historial->last()->ubicacionFisica->imagen)
                                        <a href="{{ route('ubicacionfisica.show', $resguardo->historial->last()->ubicacionFisica->id) }}" class="fw-semibold text-decoration-none" style="color:#171C63;">
                                            {{ optional($resguardo->historial->last()->ubicacionFisica)->descripcion }}
                                        </a>
                                        <br>
                                        <a href="{{ asset('storage/' . $resguardo->historial->last()->ubicacionFisica->imagen) }}" target="_blank" class="small text-muted">
                                            Ver imagen
                                        </a>
                                    @else
                                        <a href="{{ route('ubicacionfisica.show', $resguardo->historial->last()->ubicacionFisica->id) }}" class="fw-semibold text-decoration-none" style="color:#171C63;">
                                            {{ optional($resguardo->historial->last()->ubicacionFisica)->descripcion }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('resguardante.show', $resguardo->historial->last()->resguardante->id) }}" 
                                       class="fw-semibold text-decoration-none" style="color:#171C63;">
                                        {{ strtoupper(optional($resguardo->historial->last()->resguardante)->nombre1) }}
                                        {{ strtoupper(optional($resguardo->historial->last()->resguardante)->nombre2) }}
                                        {{ strtoupper(optional($resguardo->historial->last()->resguardante)->apellido1) }}
                                        {{ strtoupper(optional($resguardo->historial->last()->resguardante)->apellido2) }}
                                    </a>
                                </td>
                      <td class="text-nowrap">
                        <button wire:click="cambiarAccion('editar',{{ $resguardo->id }})" 
                                class="btn btn-warning btn-sm text-white mb-1" 
                                title="Editar Resguardo">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button wire:click="cambiarAccion('showHistorialResguardo',{{ $resguardo->id }})" 
                                class="btn btn-dark btn-sm mb-1" 
                                title="Ver Historial del Resguardo">
                            <i class="fas fa-eye"></i>
                        </button>

                        @can('inventario.create')   
                            <button wire:click="cambiarAccion('addNewResguardo',{{ $resguardo->id }})" 
                                    class="btn btn-primary btn-sm mb-1" 
                                    style="background-color:#171C63; border:none;" 
                                    title="Añadir Nuevo Resguardo">
                                <i class="fas fa-plus"></i>
                            </button>  

                            <button wire:click="downloadEtiqueta({{ $resguardo->id }})" 
                                    class="btn btn-success btn-sm mb-1" 
                                    title="Descargar Etiqueta">
                                <i class="fas fa-download"></i>
                            </button>
                        @endcan
                    </td>

                            </tr>
                        @empty
                            <tr><td colspan="13" class="text-center text-muted py-3">No se encontró inventario.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">
        {{ $resguardos->links() }}
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

            Livewire.on('alumno-created', function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: '!Resguardo registrado con éxito!',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false, // Deshabilita clics fuera del modal
                    allowEscapeKey: false,    // Deshabilita Escape
                    allowEnterKey: false,     // Deshabilita Enter
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

            Livewire.on('alumno-created2', function($message){                
                Swal.fire({
                    title: '¡Éxito!',
                    text: '!Nuevo resguardo agregado a este inventario con éxito!',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false, // Deshabilita clics fuera del modal
                    allowEscapeKey: false,    // Deshabilita Escape
                    allowEnterKey: false,     // Deshabilita Enter
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
                    text: '!Resguardo actualizado con éxito!',
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
