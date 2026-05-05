<div class="container mt-4">

    {{-- LOADING BAR (solo acciones de botones) --}}
    <div
        wire:loading.delay
        wire:target="showModalNewResguardo,export,rangeFrom,rangeTo,edit,addNewResguardo,searchResguardos,clearSearch,cambiarAccion,showHistorialResguardo,downloadEtiqueta"
        class="position-fixed top-0 start-0 w-100"
        style="z-index: 99999; height: 4px;"
    >
        <div class="progress w-100 h-100 rounded-0">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info w-100"></div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>
    

    <!-- Botón Agregar Inventario -->
    <div class="row">
        <div class="col d-flex justify-content-between   ">
            <div class="col-2 p-0">
                <label class="form-label">Institución</label>
                <select class="form-select" wire:model.live="filtroInstitucion">
                    <option value="ALL">Mostrar todo</option>
                    <option value="IEESSPP">IEESSPP</option>
                    <option value="ARSPO">ARSPO</option>
                </select>
            </div>
            
            <div class="col-2 p-0">   
                <label for="" style="color:white;">na</label>
                @hasanyrole('Administrador|Delegacion|Subdirector')
                <button wire:click="showModalNewResguardo" class="btn btn-primary shadow-sm ml-2" style="background-color:#171C63; border:none;">                        
                    <i class="fas fa-plus me-1"></i> Agregar inventario            
                </button>  
                @endhasanyrole
            </div>
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
    <div class="row mt-3 mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark">
                Escribe o escanea el número de inventario o el nombre del resguardante y presiona “Buscar”.
            </label>
            <div class="input-group shadow-sm">
                <input type="text" id="searchid" placeholder="Buscador ..." 
                       wire:keydown.enter="searchResguardos" wire:model="search" style="border:none;text-transform: uppercase;" class="form-control border-end-0">
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
                <table class="table table-hover align-middle mb-0 w-100" style="background-color:#F9FAFF;">

                    <thead style="background-color:#171C63; color:white;">
                        <tr>           
                            <th>Id</th>
                            {{--
                            <th>Imagen</th>
                            --}}
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Estado</th>
                            <th>Cant.</th>
                            <th>Área</th>
                            <th>Ubicación</th>
                            <th>Resguardante</th>
                            <th>Inventario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resguardos as $resguardo)
                            <tr>
                                <td class="text-center"  >{{ $resguardo->id }}</td>
                                {{--
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
                                --}}
                                <td>{{ $resguardo->descripcion }}</td>
                                <td>{{ $resguardo->marca->nombre }}</td>
                                <td>{{ $resguardo->modelo }}</td>
                                <td>{{ $resguardo->nserie }}</td>
                                <td><span class="badge rounded-pill bg-{{ strtoupper(optional($resguardo->historial->last()->estadouso)->estado) == 'ACTIVO' ? 'success' : 'secondary' }}">{{ strtoupper(optional($resguardo->historial->last()->estadouso)->estado) }}</span></td>
                                <td class="text-center">{{ $resguardo->cantidad }}</td>
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
                                        @can('ubicacionfisica.create')               
                                        <a href="{{ route('ubicacionfisica.show', $resguardo->historial->last()->ubicacionFisica->id) }}" class="fw-semibold text-decoration-none" style="color:#171C63;">
                                            {{ optional($resguardo->historial->last()->ubicacionFisica)->descripcion }}
                                        </a>
                                        @else
                                            <p>{{ optional($resguardo->historial->last()->ubicacionFisica)->descripcion }}</p>
                                        @endcan
                                    @endif
                                </td>
                                <td>
                                    @can('resguardante.create')               
                                    <a href="{{ route('resguardante.show', $resguardo->historial->last()->resguardante->id) }}" 
                                       class="fw-semibold text-decoration-none" style="color:#171C63;">
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->nombre1 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->nombre2 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->apellido1 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->apellido2 ?? '', 'UTF-8') }}
                                    </a>

                                    @else
                                        <p>{{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->nombre1 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->nombre2 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->apellido1 ?? '', 'UTF-8') }}
                                        {{ mb_strtoupper(optional($resguardo->historial->last()->resguardante)->apellido2 ?? '', 'UTF-8') }}</p>
                                    @endcan
                                </td>
                                <td>
                                    <p>{{$resguardo->institucion}}</p>
                                </td>
                                <!--  text-nowrap  -->
                                <td class="text-wrap">
                                    @hasanyrole('Administrador|Delegacion|Subdirector|Empleado')              
                                    <button wire:click="cambiarAccion('editar',{{ $resguardo->id }})" 
                                            class="btn btn-warning btn-sm text-white mb-1" 
                                            title="Editar Resguardo">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endhasanyrole

                                    <button wire:click="cambiarAccion('showHistorialResguardo',{{ $resguardo->id }})" 
                                            class="btn btn-dark btn-sm mb-1" 
                                            title="Ver Historial del Resguardo">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    @hasanyrole('Administrador|Delegacion|Subdirector')              
                                        <button wire:click="cambiarAccion('addNewResguardo',{{ $resguardo->id }})" 
                                                class="btn btn-primary btn-sm mb-1" 
                                                style="background-color:#171C63; border:none;" 
                                                title="Añadir Nuevo Resguardo">
                                            <i class="fas fa-plus"></i>
                                        </button>  
                                    @endhasanyrole
                                    @hasanyrole('Administrador|Delegacion')              
                                        <button wire:click="downloadEtiqueta({{ $resguardo->id }})" 
                                                class="btn btn-success btn-sm mb-1" 
                                                title="Descargar Etiqueta">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endhasanyrole
                                </td>

                            </tr>
                        @empty
                            <div class="row">
                                <div class="col">
                                    <td colspan="13" class="text-center text-muted py-3">
                                        No se encontró inventario.
                                    </td>
                                </div>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col">
                <!-- Texto de rango de registros -->
            
                    <!-- Select dinámico para cambiar cantidad por página -->
                    <div>
                        <label class="text-muted me-2">Mostrar:</label>
                        <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
            </div>

            @hasanyrole('Administrador|Delegacion|Subdirector')
                <div class="col d-flex justify-content-end mt-4">
                    <a href="{{route('export')}}" class="btn btn-warning mb-2 fa"><i class="fas fa-file-export"></i> Exportar todo el Inventario a Excel</a>
                </div>
            @endhasanyrole
            
        </div>
    </div>
    
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="mr-3">
                <label class="fw-bold">Desde:</label>
                <input type="number" wire:model.defer="rangeFrom" class="form-control" style="width:120px;">
            </div>

            <div>
                <label class="fw-bold">Hasta:</label>
                <input type="number" wire:model.live="rangeTo" class="form-control" style="width:120px;">
            </div>
        </div>
    </div>

    
    <!-- Paginación -->
    {{--
    <div class="d-flex justify-content-end mt-3">
        {{ $resguardos->links() }}
    </div>
    --}}
    @if ($resguardos instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="d-flex justify-content-end mt-3">
        {{ $resguardos->links() }}
    </div>
    @endif


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
