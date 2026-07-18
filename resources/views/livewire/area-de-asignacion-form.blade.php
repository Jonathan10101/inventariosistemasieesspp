<div class="container mt-4 areas-page">

    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO --}}
    <div
        data-tour-page="areas-de-asignacion"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>

    {{-- LOADING BAR --}}
    <div
        wire:loading.delay
        wire:target="showModalNewAreaDeAsignacion,cambiarAccion,downloadEtiqueta,searchAreasDeAsignacion,clearSearch"
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
        class="areas-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Áreas de asignación"
        data-tour-description="En este módulo puedes consultar y administrar las áreas institucionales utilizadas para asignar los bienes."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div>
            <div class="areas-kicker">
                <i class="fas fa-sitemap"></i>
                Inventario institucional
            </div>

            <h2 class="areas-title">
                Áreas de asignación
            </h2>

            <p class="areas-subtitle">
                Administra las áreas institucionales utilizadas para clasificar la asignación de bienes.
            </p>
        </div>

        <div class="header-actions">
            <button
                type="button"
                class="btn btn-tour"
                data-tour-start
            >
                <i class="fas fa-circle-question"></i>
                <span>Ver tutorial</span>
            </button>

            @can('areadeasignacion.create')
                <button
                    type="button"
                    wire:click="showModalNewAreaDeAsignacion"
                    class="btn btn-add-area"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar área"
                    data-tour-description="Presiona este botón para registrar una nueva área de asignación."
                    data-tour-side="left"
                    data-tour-align="center"
                >
                    <i class="fas fa-plus"></i>
                    <span>Agregar área</span>
                </button>
            @endcan
        </div>
    </div>

    <!-- MODAL -->
    <div
        class="modal fade ieesspp-modal @if($showModal) show d-block @endif"
        tabindex="-1"
        role="dialog"
    >
        <div class="modal-dialog modal-lg {{ $accionPrincipal === 'editar' ? 'modal-dialog-centered' : '' }} ieesspp-modal-dialog" role="document">
            <div class="modal-content ieesspp-modal-content">

                <div class="modal-header ieesspp-modal-header">
                    <div>
                        <span class="modal-label">
                            {{ $accionPrincipal === 'editar' ? 'Edición de registro' : 'Nuevo registro' }}
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

                        {{-- EDITAR ÁREA DE ASIGNACIÓN --}}
                        @case("editar")
                            @livewire('update-area-de-asignacion', ['data' => $data_external_component])
                        @break

                        {{-- CREAR NUEVA ÁREA DE ASIGNACIÓN --}}
                        @default
                            @livewire('create-new-area-de-asignacion')
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
        data-tour-title="Buscar áreas"
        data-tour-description="Escribe el nombre del área para filtrar los resultados automáticamente. También puedes limpiar la búsqueda con el botón de cerrar."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div class="search-panel-header">
            <div>
                <label for="searchid" class="search-title">
                    Buscar área de asignación
                </label>

                <p class="search-description">
                    Escribe el nombre del área. Los resultados se actualizan automáticamente.
                </p>
            </div>

            <div class="search-status" wire:loading wire:target="searchAreasDeAsignacion">
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
                placeholder="Ejemplo: DIRECCIÓN GENERAL"
                wire:model="search"
                wire:keyup.debounce.400ms="searchAreasDeAsignacion"
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
        data-tour-title="Áreas registradas"
        data-tour-description="Aquí aparece el listado general de áreas de asignación disponibles dentro de INTEVI."
        data-tour-side="top"
        data-tour-align="center"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Áreas registradas
                </h5>

                <p class="table-subtitle">
                    Listado general de áreas de asignación disponibles en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $areasdeasignacion->total() }} registros
            </div>
        </div>

        <div class="table-responsive">
            <table class="table areas-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Área de asignación</th>
                        {{--
                        <th scope="col" class="text-center">Acciones</th>
                        --}}
                    </tr>
                </thead>

                <tbody>
                    @forelse ($areasdeasignacion as $areadeasignacion)
                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $areadeasignacion->id }}
                                </span>
                            </td>

                            <td>
                                <div class="area-info">
                                    <div class="area-icon">
                                        <i class="fas fa-sitemap"></i>
                                    </div>

                                    <div>
                                        <div class="area-name">
                                            {{ $areadeasignacion->nombre }}
                                        </div>

                                        <div class="area-meta">
                                            Área institucional de asignación
                                        </div>
                                    </div>
                                </div>
                            </td>
                             
                            {{--
                            <td class="text-center">
                                <div class="actions-group">

                                    @can('areadeasignacion.edit')
                                        <button
                                            type="button"
                                            class="btn-action-edit"
                                            wire:click="cambiarAccion('editar', {{ $areadeasignacion->id }})"
                                            title="Editar área de asignación"
                                        >
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    @endcan

                                    @can('areadeasignacion.edit')
                                        <button
                                            type="button"
                                            class="btn-action-download"
                                            wire:click="downloadEtiqueta({{ $areadeasignacion->id }})"
                                            title="Descargar etiqueta"
                                        >
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endcan

                                    <a
                                        href="{{ route('areadeasignacion.show', $areadeasignacion->id) }}"
                                        class="btn-action-view"
                                        title="Ver detalle"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </div>
                            </td>
                            --}}

                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-sitemap"></i>
                                    </div>

                                    <h6>No se encontraron áreas de asignación</h6>

                                    <p>
                                        Intenta con otro nombre o limpia la búsqueda para ver todos los registros.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINACIÓN -->
    <div
        class="pagination-wrapper mt-4"
        data-tour-step
        data-tour-order="5"
        data-tour-title="Navegar entre páginas"
        data-tour-description="Utiliza estos controles cuando el listado tenga más registros de los que caben en una sola página."
        data-tour-side="top"
        data-tour-align="end"
    >
        {{ $areasdeasignacion->links() }}
    </div>

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
                        text: '¡Área de asignación registrada con éxito!',
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
                        text: '¡Área de asignación actualizada con éxito!',
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
        .areas-page {
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

        .areas-header {
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

        .areas-kicker {
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

        .areas-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .areas-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-tour {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 18px;
            border: 1px solid rgba(23, 28, 99, 0.18);
            border-radius: 12px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-tour:hover,
        .btn-tour:focus {
            color: #171C63;
            border-color: rgba(23, 28, 99, 0.38);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.12);
        }

        .btn-add-area {
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

        .btn-add-area:hover {
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

        .areas-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .areas-table thead th {
            padding: 14px 20px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .areas-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .areas-table tbody tr {
            transition: background 0.16s ease;
        }

        .areas-table tbody tr:hover {
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

        .area-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .area-icon {
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

        .area-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .area-meta {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        .actions-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-action-edit,
        .btn-action-download,
        .btn-action-view {
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

        .btn-action-view {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-action-view:hover {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        }

        .empty-state {
            padding: 34px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-icon {
            width: 54px;
            height: 54px;
            margin: 0 auto 12px;
            border-radius: 16px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
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
            .areas-page {
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

            .areas-header {
                margin-top: 4px;
            }
        }

        @media (max-width: 992px) {
            .areas-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-tour,
            .btn-add-area {
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