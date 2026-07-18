<div class="container-fluid mt-4 resguardos-page">


    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO --}}
    <div
        data-tour-page="inventario"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>


    {{-- LOADING BAR --}}
    <div
        wire:loading.delay
        wire:target="showModalNewResguardo,export,rangeFrom,rangeTo,edit,addNewResguardo,searchResguardos,clearSearch,cambiarAccion,showHistorialResguardo,downloadEtiqueta,perPage"
        class="ieesspp-loading-bar"
    >
        <div class="progress w-100 h-100 rounded-0">
            <div class="progress-bar progress-bar-striped progress-bar-animated w-100"></div>
        </div>
    </div>
    
    {{-- BARRA MÓVIL --}}
    <div class="mobile-page-nav">
        <button
            type="button"
            class="mobile-nav-btn"
            onclick="window.history.back()"
        >
            <i class="fas fa-arrow-left"></i>
            <span>Atrás</span>
        </button>

        <a href="{{ url('/dashboard') }}" class="mobile-nav-btn primary">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    <!-- ENCABEZADO -->
    <div
        class="resguardos-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Módulo de inventario"
        data-tour-description="Desde aquí puedes administrar los bienes institucionales, consultar su ubicación y revisar sus resguardos."
        data-tour-side="bottom"
    >
        <div>
            <div class="resguardos-kicker">
                <i class="fas fa-boxes-stacked"></i>
                Inventario institucional
            </div>

            <h2 class="resguardos-title">
                Control de inventario
            </h2>

            <p class="resguardos-subtitle">
                Administra bienes, resguardos, etiquetas, ubicación física e historial institucional.
            </p>
        </div>

        <div class="header-actions">
            <button
                type="button"
                class="btn btn-tour-help"
                data-tour-start
                title="Ver tutorial del módulo"
            >
                <i class="fas fa-circle-question"></i>
                <span>Ver tutorial</span>
            </button>

            @hasanyrole('Administrador|Delegacion|Subdirector')
                <button
                    type="button"
                    wire:click="showModalNewResguardo"
                    class="btn btn-add-resguardo"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar inventario"
                    data-tour-description="Presiona este botón para registrar un nuevo bien y su información institucional."
                    data-tour-side="left"
                >
                    <i class="fas fa-plus"></i>
                    <span>Agregar inventario</span>
                </button>
            @endhasanyrole
        </div>
    </div>

    <!-- MODAL -->
    <div
        class="modal fade ieesspp-modal @if($showModal) show d-block @endif"
        tabindex="-1"
        role="dialog"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered ieesspp-modal-dialog" role="document">
            <div class="modal-content ieesspp-modal-content">

                <div class="modal-header ieesspp-modal-header">
                    <div>
                        <span class="modal-label">
                            @switch($accionPrincipal)
                                @case('editar')
                                    Edición de inventario
                                @break

                                @case('addNewResguardo')
                                    Nuevo resguardo
                                @break

                                @case('showHistorialResguardo')
                                    Historial del bien
                                @break

                                @default
                                    Nuevo registro
                                @break
                            @endswitch
                        </span>

                        <h5 class="modal-title" id="studentModalLabel">
                            {{ $tituloModalPrincipal }}
                        </h5>
                    </div>

                    <button
                        type="button"
                        class="modal-close-btn"
                        wire:click="closeModal"
                        aria-label="Cerrar"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="ieesspp-modal-body">
                    @switch($accionPrincipal)

                        @case("addNewResguardo")
                            @livewire('add-new-resguardo', ['data' => $data_external_component])
                        @break

                        @case("showHistorialResguardo")
                            @livewire('show-resguardos-modal', ['data' => $data_external_component])
                        @break

                        @case("dar_de_baja_estudiante")
                            @livewire('unsubscribe-student', [
                                'student' => $student,
                                'motivo_baja' => $motivo_baja,
                                'fecha_baja' => $fecha_baja
                            ])
                        @break

                        @case("dar_de_baja_estudiante_detalles")
                            @livewire('unsubscribe-student', [
                                'student' => $student,
                                'motivo_baja' => $motivo_baja,
                                'fecha_baja' => $fecha_baja
                            ])
                        @break

                        @case("editar")
                            @livewire('update-resguardo', ['data' => $data_external_component])
                        @break

                        @default
                            @livewire('create-new-resguardo')
                        @break

                    @endswitch
                </div>

            </div>
        </div>
    </div>

    <!-- BUSCADOR -->
    <div
        class="search-panel mb-4"
        data-tour-step
        data-tour-order="3"
        data-tour-title="Buscar inventario"
        data-tour-description="Busca por número de inventario o nombre del resguardante."
        data-tour-side="bottom"
    >
        <div class="search-panel-header">
            <div>
                <label for="searchid" class="search-title">
                    Buscar inventario
                </label>

                <p class="search-description">
                    Escribe o escanea el número de inventario, serie, equipo o resguardante.
                </p>
            </div>

            <div class="search-status" wire:loading wire:target="searchResguardos">
                <i class="fas fa-spinner fa-spin"></i>
                Buscando
            </div>
        </div>

        <div class="search-box">
            <span class="search-icon">
                <i class="fas fa-search"></i>
            </span>

            <input
                type="text"
                id="searchid"
                placeholder="Ejemplo: LAPTOP, DELL, JUAN PÉREZ..."
                wire:model="search"
                wire:keyup.debounce.400ms="searchResguardos"
                oninput="this.value = this.value.toUpperCase()"
                class="form-control search-input"
                autocomplete="off"
            >

            @if($search)
                <button
                    type="button"
                    class="btn-clear-search"
                    wire:click="clearSearch"
                    title="Limpiar búsqueda"
                >
                    <i class="fas fa-times"></i>
                </button>
            @endif
        </div>
    </div>

    <!-- TABLA -->
    <div
        class="table-card"
        data-tour-step
        data-tour-order="4"
        data-tour-title="Inventario registrado"
        data-tour-description="Aquí aparecen los bienes, ubicación, resguardante y las acciones disponibles."
        data-tour-side="top"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Inventario registrado
                </h5>

                <p class="table-subtitle">
                    Listado general de bienes con su último resguardo registrado.
                </p>
            </div>

            <div class="table-counter">
                @if ($resguardos instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $resguardos->total() }} registros
                @else
                    {{ $resguardos->count() }} registros
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table resguardos-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Serie</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Cant.</th>
                        <th scope="col">Área</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Resguardante</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($resguardos as $resguardo)
                        @php
                            $ultimoHistorial = $resguardo->historial->last();

                            $estadoUso = strtoupper(optional(optional($ultimoHistorial)->estadouso)->estado ?? 'SIN ESTADO');
                            $estadoClass = $estadoUso === 'ACTIVO' ? 'status-active' : 'status-secondary';

                            $areaUso = optional(optional($ultimoHistorial)->areaDeUso)->nombre ?? 'SIN ÁREA';

                            $ubicacion = optional($ultimoHistorial)->ubicacionFisica;
                            $ubicacionDescripcion = optional($ubicacion)->descripcion ?? 'SIN UBICACIÓN';

                            $resguardante = optional($ultimoHistorial)->resguardante;

                            $nombreResguardante = trim(
                                (optional($resguardante)->nombre1 ?? '') . ' ' .
                                (optional($resguardante)->nombre2 ?? '') . ' ' .
                                (optional($resguardante)->apellido1 ?? '') . ' ' .
                                (optional($resguardante)->apellido2 ?? '')
                            );

                            $nombreResguardante = $nombreResguardante !== '' ? mb_strtoupper($nombreResguardante, 'UTF-8') : 'SIN RESGUARDANTE';
                        @endphp

                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $resguardo->id }}
                                </span>
                            </td>

                            <td>
                                <div class="equipo-info">
                                    <div class="equipo-icon">
                                        <i class="fas fa-box"></i>
                                    </div>

                                    <div>
                                        <div class="equipo-name">
                                            {{ $resguardo->descripcion }}
                                        </div>

                                        <div class="equipo-meta">
                                            Bien institucional
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="text-strong">
                                    {{ optional($resguardo->marca)->nombre ?? 'SIN MARCA' }}
                                </span>
                            </td>

                            <td>
                                <span class="text-muted-soft">
                                    {{ $resguardo->modelo ?: 'SIN MODELO' }}
                                </span>
                            </td>

                            <td>
                                <span class="serie-badge">
                                    {{ $resguardo->nserie ?: 'SIN SERIE' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="status-badge {{ $estadoClass }}">
                                    {{ $estadoUso }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="cantidad-badge">
                                    {{ $resguardo->cantidad }}
                                </span>
                            </td>

                            <td>
                                <div class="area-mini">
                                    <i class="fas fa-sitemap"></i>
                                    <span>{{ $areaUso }}</span>
                                </div>
                            </td>

                            <td>
                                @if($ubicacion)
                                    @can('ubicacionfisica.create')
                                        <a
                                            href="{{ route('ubicacionfisica.show', $ubicacion->id) }}"
                                            class="link-primary-system"
                                            title="Ver ubicación física"
                                        >
                                            <i class="fas fa-location-dot"></i>
                                            {{ $ubicacionDescripcion }}
                                        </a>
                                    @else
                                        <div class="location-text">
                                            <i class="fas fa-location-dot"></i>
                                            {{ $ubicacionDescripcion }}
                                        </div>
                                    @endcan

                                    @if($ubicacion->imagen)
                                        <a
                                            href="{{ asset('storage/' . $ubicacion->imagen) }}"
                                            target="_blank"
                                            class="image-link-mini"
                                        >
                                            Ver imagen
                                        </a>
                                    @endif
                                @else
                                    <span class="no-data-badge">
                                        Sin ubicación
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($resguardante)
                                    @can('resguardante.create')
                                        <a
                                            href="{{ route('resguardante.show', $resguardante->id) }}"
                                            class="resguardante-link"
                                            class="link-primary-system"
                                            title="Ver resguardante"
                                        >
                                            <span class="resguardante-avatar">
                                                {{ mb_substr(optional($resguardante)->nombre1 ?? 'S', 0, 1, 'UTF-8') }}{{ mb_substr(optional($resguardante)->apellido1 ?? 'R', 0, 1, 'UTF-8') }}
                                            </span>

                                            <span>{{ $nombreResguardante }}</span>
                                        </a>
                                    @else
                                        <div class="resguardante-link no-link">
                                            <span class="resguardante-avatar">
                                                {{ mb_substr(optional($resguardante)->nombre1 ?? 'S', 0, 1, 'UTF-8') }}{{ mb_substr(optional($resguardante)->apellido1 ?? 'R', 0, 1, 'UTF-8') }}
                                            </span>

                                            <span>{{ $nombreResguardante }}</span>
                                        </div>
                                    @endcan
                                @else
                                    <span class="no-data-badge">
                                        Sin resguardante
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="actions-group">

                                    @hasanyrole('Administrador|Delegacion|Subdirector|Empleado')
                                        <button
                                            type="button"
                                            wire:click="cambiarAccion('editar', {{ $resguardo->id }})"
                                            class="btn-action-edit"
                                            title="Editar resguardo"
                                        >
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    @endhasanyrole

                                    <button
                                        type="button"
                                        wire:click="cambiarAccion('showHistorialResguardo', {{ $resguardo->id }})"
                                        class="btn-action-history"
                                        title="Ver historial del resguardo"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    @hasanyrole('Administrador|Delegacion|Subdirector')
                                        <button
                                            type="button"
                                            wire:click="cambiarAccion('addNewResguardo', {{ $resguardo->id }})"
                                            class="btn-action-add"
                                            title="Añadir nuevo resguardo"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    @endhasanyrole

                                    @hasanyrole('Administrador|Delegacion')
                                        <button
                                            type="button"
                                            wire:click="downloadEtiqueta({{ $resguardo->id }})"
                                            class="btn-action-download"
                                            title="Descargar etiqueta"
                                        >
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endhasanyrole

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>

                                    <h6>No se encontró inventario</h6>

                                    <p>
                                        Intenta con otro número de inventario, equipo, serie o resguardante.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CONTROLES INFERIORES -->
    <div
        class="table-bottom-controls mt-4"
        data-tour-step
        data-tour-order="5"
        data-tour-title="Controles del listado"
        data-tour-description="Selecciona cuántos registros deseas ver y exporta el inventario cuando tengas permiso."
        data-tour-side="top"
    >
        <div class="per-page-control">
            <label class="control-label">
                Mostrar
            </label>

            <select wire:model.live="perPage" class="form-select form-select-sm per-page-select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <span class="control-label">
                registros
            </span>
        </div>

        @hasanyrole('Administrador|Delegacion|Subdirector')
            <a
                href="{{ route('export') }}"
                class="btn-export-inventory"
                title="Exportar todo el inventario a Excel"
            >
                <i class="fas fa-file-export"></i>
                <span>Exportar Excel</span>
            </a>
        @endhasanyrole
    </div>

    <!-- PAGINACIÓN -->
    @if ($resguardos instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="pagination-wrapper mt-4">
            {{ $resguardos->links() }}
        </div>
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ieessppformtable.css') }}">

    @push('js')
        @livewireScripts

        <script>
            document.addEventListener('livewire:initialized', function () {

                Livewire.on('refresh-page', function ($message) {
                    location.reload();
                });

                Livewire.on('alumno-created', function ($message) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Resguardo registrado con éxito!',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                });

                Livewire.on('alumno-created2', function ($message) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Nuevo resguardo agregado a este inventario con éxito!',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                });

                Livewire.on('alumno-updated', function ($message) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Resguardo actualizado con éxito!',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                });

            });
        </script>
    @endpush

    <style>
        .resguardos-page {
            color: #111827;
        }

        .ieesspp-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 99999;
            height: 4px;
        }

        .ieesspp-loading-bar .progress-bar {
            background: linear-gradient(90deg, #171C63, #2563eb, #06b6d4);
        }

        .resguardos-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background:
                radial-gradient(circle at top left, rgba(23, 28, 99, 0.12), transparent 35%),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .resguardos-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .resguardos-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .resguardos-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-tour-help {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 16px;
            border: 1px solid rgba(23, 28, 99, 0.22);
            border-radius: 12px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-tour-help:hover,
        .btn-tour-help:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.20);
        }

        .btn-add-resguardo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 18px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #171C63 0%, #26318f 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }

        .btn-add-resguardo:hover {
            color: #ffffff;
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.28);
        }

        .ieesspp-modal {
            background: rgba(15, 23, 42, 0.58);
            backdrop-filter: blur(5px);
        }

        .ieesspp-modal-dialog {
            z-index: 1055;
        }

        .ieesspp-modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.28);
        }

        .ieesspp-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.20), transparent 35%),
                linear-gradient(135deg, #171C63 0%, #0f143f 100%);
            color: #ffffff;
        }

        .ieesspp-modal-header .modal-title {
            margin: 2px 0 0;
            font-size: 18px;
            font-weight: 800;
        }

        .modal-label {
            display: block;
            color: rgba(255, 255, 255, 0.76);
            font-size: 12px;
            font-weight: 600;
        }

        .modal-close-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.18s ease, transform 0.18s ease;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            transform: rotate(90deg);
        }

        .ieesspp-modal-body {
            background: #ffffff;
        }

        .search-panel {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 16px 42px rgba(15, 23, 42, 0.055);
        }

        .search-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .search-title {
            display: block;
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
        }

        .search-description {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .search-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #171C63;
            background: rgba(23, 28, 99, 0.08);
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .search-box {
            display: flex;
            align-items: center;
            min-height: 50px;
            background: #f8fafc;
            border: 1px solid transparent;
            border-radius: 14px;
            overflow: hidden;
            transition: background 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .search-box:focus-within {
            background: #ffffff;
            border-color: rgba(23, 28, 99, 0.35);
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09);
        }

        .search-icon {
            width: 48px;
            color: #171C63;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .search-input {
            height: 50px;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            color: #0f172a;
            font-size: 14px;
            font-weight: 600;
        }

        .search-input::placeholder {
            color: #94a3b8;
            font-weight: 500;
            text-transform: none;
        }

        .btn-clear-search {
            width: 42px;
            height: 42px;
            margin-right: 5px;
            border: none;
            border-radius: 12px;
            background: transparent;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.18s ease, color 0.18s ease;
        }

        .btn-clear-search:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .table-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f7;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .table-title {
            margin: 0;
            color: #0f172a;
            font-size: 16px;
            font-weight: 800;
        }

        .table-subtitle {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .table-counter {
            padding: 7px 12px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #334155;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .resguardos-table {
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1280px;
        }

        .resguardos-table thead th {
            padding: 14px 16px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .resguardos-table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 13px;
        }

        .resguardos-table tbody tr {
            transition: background 0.16s ease;
        }

        .resguardos-table tbody tr:hover {
            background: #fbfdff;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 800;
        }

        .equipo-info {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 210px;
        }

        .equipo-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(23, 28, 99, 0.12), rgba(37, 99, 235, 0.12));
            color: #171C63;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .equipo-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .equipo-meta {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        .text-strong {
            color: #111827;
            font-weight: 800;
            white-space: nowrap;
        }

        .text-muted-soft {
            color: #64748b;
            font-weight: 600;
            white-space: nowrap;
        }

        .serie-badge {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #334155;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .status-active {
            background: #ecfdf5;
            color: #047857;
        }

        .status-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .cantidad-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 30px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 900;
        }

        .area-mini,
        .location-text {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #334155;
            font-weight: 700;
            white-space: nowrap;
        }

        .area-mini i,
        .location-text i {
            color: #171C63;
        }

        .link-primary-system {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #171C63;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .link-primary-system:hover {
            color: #0f143f;
            text-decoration: underline;
        }

        .image-link-mini {
            display: inline-block;
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .image-link-mini:hover {
            color: #171C63;
            text-decoration: underline;
        }

        .resguardante-link {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #111827;
            font-weight: 800;
            text-decoration: none;
            min-width: 220px;
        }

        .resguardante-link:hover {
            color: #171C63;
            text-decoration: none;
        }

        .resguardante-link.no-link:hover {
            color: #111827;
        }

        .resguardante-avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .no-data-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .actions-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action-edit,
        .btn-action-history,
        .btn-action-add,
        .btn-action-download {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-action-edit {
            background: #fff7ed;
            color: #c2410c;
        }

        .btn-action-edit:hover {
            background: #f97316;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.24);
        }

        .btn-action-history {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-action-history:hover {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        }

        .btn-action-add {
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
        }

        .btn-action-add:hover {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        }

        .btn-action-download {
            background: #ecfdf5;
            color: #047857;
        }

        .btn-action-download:hover {
            background: #059669;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(5, 150, 105, 0.24);
        }

        .empty-state {
            padding: 38px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 12px;
            border-radius: 18px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .empty-state h6 {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
        }

        .empty-state p {
            margin: 6px 0 0;
            font-size: 13px;
        }

        .table-bottom-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .per-page-control {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 14px;
            padding: 10px 12px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.045);
        }

        .control-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .per-page-select {
            width: auto;
            border-radius: 10px;
            border-color: #e2e8f0;
            color: #0f172a;
            font-weight: 800;
            box-shadow: none !important;
        }

        .btn-export-inventory {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #047857;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 12px 26px rgba(5, 150, 105, 0.12);
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-export-inventory:hover {
            background: #059669;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(5, 150, 105, 0.22);
            text-decoration: none;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .btn-ieesspp {
            background: #171C63 !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            padding: 9px 20px !important;
            font-weight: 700 !important;
        }

        .mobile-page-nav {
            display: none;
        }

        @media (max-width: 768px) {
            .resguardos-page {
                margin-top: 12px !important;
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .mobile-page-nav {
                position: sticky;
                top: 8px;
                z-index: 1050;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 14px;
                padding: 10px;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(226, 232, 240, 0.95);
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.12);
                backdrop-filter: blur(12px);
            }

            .mobile-nav-btn {
                min-height: 42px;
                flex: 1;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                background: #f8fafc;
                color: #334155;
                font-size: 13px;
                font-weight: 900;
                text-decoration: none !important;
                outline: none !important;
                transition: all 0.18s ease;
            }

            .mobile-nav-btn i {
                font-size: 13px;
            }

            .mobile-nav-btn:hover,
            .mobile-nav-btn:focus {
                background: #ffffff;
                color: #171C63;
                border-color: rgba(23, 28, 99, 0.25);
            }

            .mobile-nav-btn.primary {
                background: linear-gradient(135deg, #171C63 0%, #26318f 100%);
                border-color: #171C63;
                color: #ffffff !important;
                box-shadow: 0 12px 24px rgba(23, 28, 99, 0.22);
            }

            .mobile-nav-btn.primary:hover,
            .mobile-nav-btn.primary:focus {
                color: #ffffff !important;
                transform: translateY(-1px);
                box-shadow: 0 16px 30px rgba(23, 28, 99, 0.28);
            }

            .resguardos-header {
                margin-top: 4px;
            }
        }

        @media (max-width: 992px) {
            .resguardos-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-tour-help,
            .btn-add-resguardo {
                width: 100%;
            }

            .search-panel-header {
                flex-direction: column;
            }

            .table-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .table-bottom-controls {
                align-items: stretch;
                flex-direction: column;
            }

            .per-page-control,
            .btn-export-inventory {
                width: 100%;
                justify-content: center;
            }

            .pagination-wrapper {
                justify-content: center;
            }
        }
    </style>

</div>