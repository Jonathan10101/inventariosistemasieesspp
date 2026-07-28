<div class="container mt-4 users-page">

    {{-- LOADING BAR --}}
    <div
        wire:loading.delay
        wire:target="showModalNewUser,editar,searchUsers,clearSearch,cambiarAccion"
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

    {{-- SWEETALERT2 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    {{-- ENCABEZADO --}}
    <div class="users-header mb-4">

        <div class="users-header-information">

            <div class="users-kicker">
                <i class="fas fa-layer-group"></i>
                Catálogo institucional
            </div>

            <h2 class="users-title">
                Gestión de usuarios
            </h2>

            <p class="users-subtitle">
                Administra, consulta y actualiza los usuarios registrados en el sistema.
            </p>

        </div>

        @hasanyrole('Administrador|Delegacion|Subdirector')

            <div class="users-header-actions">

                {{-- CONTADOR DE USUARIOS --}}
                <div
                    class="users-limit-card
                        {{ $this->limiteUsuariosAlcanzado ? 'limit-reached' : '' }}"
                >
                    <div class="users-limit-icon">
                        @if ($this->limiteUsuariosAlcanzado)
                            <i class="fas fa-user-lock"></i>
                        @else
                            <i class="fas fa-users"></i>
                        @endif
                    </div>

                    <div class="users-limit-information">
                        <span class="users-limit-label">
                            Usuarios institucionales
                        </span>

                        <strong class="users-limit-value">
                            {{ $this->usuariosUsados }}
                            de
                            {{ $this->limiteUsuarios }}
                        </strong>

                        <span class="users-limit-remaining">
                            @if ($this->limiteUsuariosAlcanzado)
                                Límite de usuarios alcanzado
                            @else
                                {{ $this->usuariosDisponibles }}
                                {{ $this->usuariosDisponibles === 1 ? 'espacio disponible' : 'espacios disponibles' }}
                            @endif
                        </span>
                    </div>
                </div>

                {{-- BOTÓN AGREGAR USUARIO --}}
                @if ($this->limiteUsuariosAlcanzado)

                    <button
                        type="button"
                        class="btn btn-add-user btn-add-user-disabled"
                        disabled
                        title="La institución alcanzó el límite de {{ $this->limiteUsuarios }} usuarios"
                    >
                        <i class="fas fa-user-lock"></i>
                        <span>Límite alcanzado</span>
                    </button>

                @else

                    <button
                        type="button"
                        wire:click="showModalNewUser"
                        wire:loading.attr="disabled"
                        wire:target="showModalNewUser"
                        class="btn btn-add-user"
                    >
                        <span wire:loading.remove wire:target="showModalNewUser">
                            <i class="fas fa-plus"></i>
                        </span>

                        <span wire:loading wire:target="showModalNewUser">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>

                        <span>
                            Agregar usuario
                        </span>
                    </button>

                @endif

            </div>

        @endhasanyrole

    </div>

    {{-- MODAL --}}
    <div
        class="modal fade @if($showModal) show @endif"
        style="display: @if($showModal) block @else none @endif;"
        tabindex="-1"
        role="dialog"
        aria-hidden="{{ $showModal ? 'false' : 'true' }}"
    >
        <div class="modal-backdrop-custom"></div>

        <div
            class="modal-dialog modal-lg
                {{ $accionPrincipal === 'editar' ? 'modal-dialog-centered' : '' }}
                ieesspp-modal-dialog"
            role="document"
        >
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

                        {{-- EDITAR USUARIO --}}
                        @case('editar')

                            @livewire(
                                'update-user',
                                ['data' => $data_external_component],
                                key('update-user-' . ($data_external_component['id'] ?? 'new'))
                            )

                        @break

                        {{-- CREAR NUEVO USUARIO --}}
                        @default

                            @livewire(
                                'create-new-user',
                                [],
                                key('create-new-user')
                            )

                        @break

                    @endswitch

                </div>

            </div>
        </div>
    </div>

    {{-- BUSCADOR --}}
    <div class="search-panel mb-4">

        <div class="search-panel-header">

            <div>
                <label for="searchid" class="search-title">
                    Buscar usuario
                </label>

                <p class="search-description">
                    Escribe el nombre del usuario. Los resultados se actualizan automáticamente.
                </p>
            </div>

            <div
                class="search-status"
                wire:loading
                wire:target="searchUsers"
            >
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
                placeholder="Ejemplo: Juan, María, Fernando..."
                wire:model="search"
                wire:input.debounce.400ms="searchUsers"
                oninput="this.value = this.value.toUpperCase()"
                class="form-control search-input"
                autocomplete="off"
            >

            @if ($search)

                <button
                    type="button"
                    class="btn-clear-search"
                    wire:click="clearSearch"
                    wire:loading.attr="disabled"
                    wire:target="clearSearch"
                    title="Limpiar búsqueda"
                >
                    <i class="fas fa-times"></i>
                </button>

            @endif

        </div>

    </div>

    {{-- TABLA --}}
    <div class="table-card">

        <div class="table-card-header">

            <div>
                <h5 class="table-title">
                    Usuarios registrados
                </h5>

                <p class="table-subtitle">
                    Listado general de usuarios disponibles.
                </p>
            </div>

            <div class="table-counter">
                {{ $usuarios->total() }}
                {{ $usuarios->total() === 1 ? 'registro' : 'registros' }}
            </div>

        </div>

        <div class="table-responsive">

            <table class="table users-table mb-0">

                <thead>
                    <tr>
                        <th scope="col">
                            ID
                        </th>

                        <th scope="col">
                            Usuario
                        </th>

                        @hasanyrole('Administrador')
                            <th scope="col" class="text-center">
                                Acciones
                            </th>
                        @endhasanyrole
                    </tr>
                </thead>

                <tbody>

                    @forelse ($usuarios as $user)

                        <tr>

                            <td>
                                <span class="id-badge">
                                    #{{ $user->id }}
                                </span>
                            </td>

                            <td>
                                <div class="user-name">
                                    {{ $user->name }}
                                </div>
                            </td>

                            @hasanyrole('Administrador')
                                <td class="text-center">

                                    {{--
                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="cambiarAccion('editar', {{ $user->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="cambiarAccion"
                                        title="Editar usuario"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    --}}

                                    <span class="text-muted">
                                        —
                                    </span>

                                </td>
                            @endhasanyrole

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="{{ auth()->user()->hasRole('Administrador') ? 3 : 2 }}"
                            >
                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="fas fa-search"></i>
                                    </div>

                                    <h6>
                                        No se encontraron usuarios
                                    </h6>

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

    {{-- PAGINACIÓN --}}
    <div class="pagination-wrapper mt-4">
        {{ $usuarios->links() }}
    </div>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/ieessppformtable.css') }}"
    >

    @push('js')

        <script>
            document.addEventListener('livewire:initialized', function () {

                Livewire.on('refresh-page', function () {
                    location.reload();
                });

                Livewire.on('user-limit-reached', function (event) {
                    const limite = event.limite ?? 10;

                    Swal.fire({
                        title: 'Límite alcanzado',
                        text: `Esta institución ya tiene los ${limite} usuarios permitidos.`,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    });
                });

                Livewire.on('alumno-created', function () {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Usuario registrado con éxito!',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
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

                Livewire.on('alumno-updated', function () {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Usuario actualizado con éxito!',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
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
        .users-page {
            color: #111827;
        }

        /*
        |--------------------------------------------------------------------------
        | Barra de carga
        |--------------------------------------------------------------------------
        */

        .ieesspp-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            z-index: 99999;
        }

        .ieesspp-loading-bar .progress-bar {
            background: linear-gradient(
                90deg,
                #171C63,
                #2563eb,
                #06b6d4
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Encabezado
        |--------------------------------------------------------------------------
        */

        .users-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(23, 28, 99, 0.12),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8fafc 100%
                );
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .users-header-information {
            min-width: 0;
        }

        .users-kicker {
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

        .users-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .users-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Acciones y límite de usuarios
        |--------------------------------------------------------------------------
        */

        .users-header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
            flex-shrink: 0;
        }

        .users-limit-card {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 190px;
            padding: 11px 14px;
            border: 1px solid rgba(23, 28, 99, 0.12);
            border-radius: 14px;
            background: rgba(23, 28, 99, 0.055);
        }

        .users-limit-card.limit-reached {
            border-color: rgba(185, 28, 28, 0.18);
            background: rgba(254, 226, 226, 0.62);
        }

        .users-limit-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #171C63;
            color: #ffffff;
            font-size: 14px;
        }

        .users-limit-card.limit-reached .users-limit-icon {
            background: #b91c1c;
        }

        .users-limit-information {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .users-limit-label {
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.045em;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .users-limit-value {
            margin-top: 2px;
            color: #171C63;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.2;
        }

        .users-limit-card.limit-reached .users-limit-value {
            color: #991b1b;
        }

        .users-limit-remaining {
            margin-top: 2px;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;
        }

        /*
        |--------------------------------------------------------------------------
        | Botón agregar usuario
        |--------------------------------------------------------------------------
        */

        .btn-add-user {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 18px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(
                135deg,
                #171C63 0%,
                #26318f 100%
            );
            color: #ffffff;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .btn-add-user:hover,
        .btn-add-user:focus {
            color: #ffffff;
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.28);
        }

        .btn-add-user:disabled,
        .btn-add-user-disabled {
            cursor: not-allowed;
            background: #94a3b8;
            color: #ffffff;
            opacity: 1;
            box-shadow: none;
            transform: none;
            filter: none;
        }

        .btn-add-user-disabled:hover,
        .btn-add-user-disabled:focus {
            color: #ffffff;
            background: #94a3b8;
            box-shadow: none;
            transform: none;
            filter: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Modal
        |--------------------------------------------------------------------------
        */

        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: rgba(15, 23, 42, 0.58);
            backdrop-filter: blur(5px);
        }

        .ieesspp-modal-dialog {
            z-index: 1055;
        }

        .ieesspp-modal-content {
            overflow: hidden;
            border: none;
            border-radius: 18px;
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
                radial-gradient(
                    circle at top left,
                    rgba(255, 255, 255, 0.20),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #171C63 0%,
                    #0f143f 100%
                );
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            transition:
                background 0.18s ease,
                transform 0.18s ease;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            transform: rotate(90deg);
        }

        .ieesspp-modal-body {
            background: #ffffff;
        }

        /*
        |--------------------------------------------------------------------------
        | Buscador
        |--------------------------------------------------------------------------
        */

        .search-panel {
            padding: 18px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            background: #ffffff;
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
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .search-box {
            display: flex;
            align-items: center;
            min-height: 50px;
            overflow: hidden;
            border: 1px solid transparent;
            border-radius: 14px;
            background: #f8fafc;
            transition:
                background 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .search-box:focus-within {
            border-color: rgba(23, 28, 99, 0.35);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09);
        }

        .search-icon {
            width: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #171C63;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 12px;
            background: transparent;
            color: #64748b;
            transition:
                background 0.18s ease,
                color 0.18s ease;
        }

        .btn-clear-search:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /*
        |--------------------------------------------------------------------------
        | Tabla
        |--------------------------------------------------------------------------
        */

        .table-card {
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f7;
            background: linear-gradient(
                180deg,
                #ffffff 0%,
                #fbfdff 100%
            );
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

        .users-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .users-table thead th {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .users-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .users-table tbody tr {
            transition:
                background 0.16s ease,
                transform 0.16s ease;
        }

        .users-table tbody tr:hover {
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

        .user-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        .btn-action-edit {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 11px;
            background: #fff7ed;
            color: #c2410c;
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-action-edit:hover {
            background: #f97316;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.24);
        }

        /*
        |--------------------------------------------------------------------------
        | Estado vacío
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 34px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-icon {
            width: 54px;
            height: 54px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
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

        /*
        |--------------------------------------------------------------------------
        | Paginación
        |--------------------------------------------------------------------------
        */

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        /*
        |--------------------------------------------------------------------------
        | SweetAlert
        |--------------------------------------------------------------------------
        */

        .btn-ieesspp {
            padding: 9px 20px !important;
            border: none !important;
            border-radius: 10px !important;
            background: #171C63 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | Navegación móvil
        |--------------------------------------------------------------------------
        */

        .mobile-page-nav {
            display: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive tablet
        |--------------------------------------------------------------------------
        */

        @media (max-width: 992px) {

            .users-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .users-header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .users-limit-card {
                flex: 1;
            }

            .search-panel-header {
                flex-direction: column;
            }

            .table-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .pagination-wrapper {
                justify-content: center;
            }

        }

        /*
        |--------------------------------------------------------------------------
        | Responsive móvil
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .users-page {
                margin-top: 12px !important;
                padding-right: 12px !important;
                padding-left: 12px !important;
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
                border: 1px solid rgba(226, 232, 240, 0.95);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.92);
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
                outline: none !important;
                background: #f8fafc;
                color: #334155;
                font-size: 13px;
                font-weight: 900;
                text-decoration: none !important;
                transition: all 0.18s ease;
            }

            .mobile-nav-btn i {
                font-size: 13px;
            }

            .mobile-nav-btn:hover,
            .mobile-nav-btn:focus {
                border-color: rgba(23, 28, 99, 0.25);
                background: #ffffff;
                color: #171C63;
            }

            .mobile-nav-btn.primary {
                border-color: #171C63;
                background: linear-gradient(
                    135deg,
                    #171C63 0%,
                    #26318f 100%
                );
                color: #ffffff !important;
                box-shadow: 0 12px 24px rgba(23, 28, 99, 0.22);
            }

            .mobile-nav-btn.primary:hover,
            .mobile-nav-btn.primary:focus {
                color: #ffffff !important;
                transform: translateY(-1px);
                box-shadow: 0 16px 30px rgba(23, 28, 99, 0.28);
            }

            .users-header {
                margin-top: 4px;
                padding: 18px;
            }

            .users-title {
                font-size: 23px;
            }

            .users-header-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .users-limit-card {
                width: 100%;
                min-width: 0;
            }

            .btn-add-user {
                width: 100%;
            }

            .search-panel {
                padding: 15px;
            }

            .table-card-header {
                padding: 16px;
            }

            .users-table thead th,
            .users-table tbody td {
                padding-right: 14px;
                padding-left: 14px;
            }

        }
    </style>

</div>