<div class="container mt-4 resguardantes-page">
    
    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO --}}
    <div
        data-tour-page="resguardantes"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>


    {{-- LOADING BAR --}}
    <div
        wire:loading
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
        class="resguardantes-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Módulo de resguardantes"
        data-tour-description="Desde aquí puedes consultar y administrar a las personas responsables de los bienes institucionales."
        data-tour-side="bottom"
    >
        <div>
            <div class="resguardantes-kicker">
                <i class="fas fa-user-shield"></i>
                Inventario institucional
            </div>

            <h2 class="resguardantes-title">
                Control de resguardantes
            </h2>

            <p class="resguardantes-subtitle">
                Administra las personas responsables del resguardo de bienes institucionales.
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

            @hasanyrole('Administrador')
                <button
                    type="button"
                    wire:click="showModalNewResguardante"
                    class="btn btn-add-resguardante"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar resguardante"
                    data-tour-description="Presiona aquí para registrar una nueva persona responsable de bienes institucionales."
                    data-tour-side="left"
                >
                    <i class="fas fa-plus"></i>
                    <span>Agregar resguardante</span>
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

                        {{-- EDITAR RESGUARDANTE --}}
                        @case("editar")
                            @livewire('update-resguardante', ['data' => $data_external_component])
                        @break

                        {{-- CREAR NUEVO RESGUARDANTE --}}
                        @default
                            @livewire('create-new-resguardante')
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
        data-tour-title="Buscar resguardante"
        data-tour-description="Escribe el nombre de una persona para filtrar los resultados automáticamente."
        data-tour-side="bottom"
    >
        <div class="search-panel-header">
            <div>
                <label for="searchid" class="search-title">
                    Buscar resguardante
                </label>

                <p class="search-description">
                    Escribe el nombre del resguardante. Los resultados se actualizan automáticamente.
                </p>
            </div>

            <div class="search-status" wire:loading wire:target="searchResguardantes">
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
                placeholder="Ejemplo: JONATHAN, JUAN, MARIA..."
                wire:model="search"
                wire:keyup.debounce.400ms="searchResguardantes"
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
        data-tour-title="Resguardantes registrados"
        data-tour-description="Consulta los responsables registrados, su rol, sus resguardos y las acciones disponibles."
        data-tour-side="top"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Resguardantes registrados
                </h5>

                <p class="table-subtitle">
                    Listado general de responsables de resguardo.
                </p>
            </div>

            <div class="table-counter">
                {{ $resguardantes->total() }} registros
            </div>
        </div>

        <div class="table-responsive">
            <table class="table resguardantes-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del resguardante</th>
                        <th scope="col">Rol</th>

                        <th scope="col" class="text-center">Resguardos</th>

                        @hasanyrole('Administrador')
                            <th scope="col" class="text-center">Acciones</th>
                        @endhasanyrole
                    </tr>
                </thead>

                <tbody>
                    @forelse ($resguardantes as $resguardante)
                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $resguardante->id }}
                                </span>
                            </td>

                            <td>
                                <div class="resguardante-info">
                                    <div class="avatar-resguardante">
                                        {{ strtoupper(substr($resguardante->nombre1, 0, 1)) }}{{ strtoupper(substr($resguardante->apellido1, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="resguardante-name">
                                            {{ $resguardante->nombre1 }}
                                            {{ $resguardante->nombre2 }}
                                            {{ $resguardante->apellido1 }}
                                            {{ $resguardante->apellido2 }}
                                        </div>

                                        <div class="resguardante-meta">
                                            Responsable de bienes institucionales
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="id-badge">
                                    {{ $resguardante->user->roles[0]->name}}
                                </span>
                            </td>

                            <td class="text-center">
                                @if(
                                    auth()->user()->hasRole('Director') ||
                                    auth()->user()->hasRole('Delegacion') ||
                                    auth()->user()->hasRole('Administrador') ||
                                    ($resguardante->user && $resguardante->user->subdireccion == auth()->user()->subdireccion)
                                )
                                    <a
                                        href="{{ route('resguardante.show', $resguardante->id) }}"
                                        class="btn-view-resguardos"
                                        title="Ver resguardos"
                                    >
                                        <i class="fas fa-eye"></i>
                                        <span>Ver</span>
                                    </a>
                                @else
                                    <span class="access-denied-badge">
                                        <i class="fas fa-lock"></i>
                                        Sin acceso
                                    </span>
                                @endif
                            </td>

                            @hasanyrole('Administrador')
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="cambiarAccion('editar', {{ $resguardante->id }})"
                                        title="Editar resguardante"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </td>
                            @endhasanyrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>

                                    <h6>No se encontraron resguardantes</h6>

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
        data-tour-title="Paginación"
        data-tour-description="Utiliza estos controles para recorrer todos los resguardantes registrados."
        data-tour-side="top"
    >
        {{ $resguardantes->links() }}
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
                        text: '¡Resguardante registrado con éxito!',
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
                        text: '¡Resguardante actualizado con éxito!',
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
        .resguardantes-page {
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

        .resguardantes-header {
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

        .resguardantes-kicker {
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

        .resguardantes-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .resguardantes-subtitle {
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

        .btn-add-resguardante {
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

        .btn-add-resguardante:hover {
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

        .resguardantes-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .resguardantes-table thead th {
            padding: 14px 20px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .resguardantes-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .resguardantes-table tbody tr {
            transition: background 0.16s ease;
        }

        .resguardantes-table tbody tr:hover {
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

        .resguardante-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-resguardante {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(23, 28, 99, 0.12), rgba(37, 99, 235, 0.12));
            color: #171C63;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .resguardante-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .resguardante-meta {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        .btn-view-resguardos {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 36px;
            padding: 0 13px;
            border-radius: 11px;
            background: #0f172a;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .btn-view-resguardos:hover {
            color: #ffffff;
            background: #171C63;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
            text-decoration: none;
        }

        .access-denied-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .btn-action-edit {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 11px;
            background: #fff7ed;
            color: #c2410c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-action-edit:hover {
            background: #f97316;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.24);
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
            .resguardantes-page {
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

            .resguardantes-header {
                margin-top: 4px;
            }
        }

        @media (max-width: 992px) {
            .resguardantes-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-tour-help,
            .btn-add-resguardante {
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