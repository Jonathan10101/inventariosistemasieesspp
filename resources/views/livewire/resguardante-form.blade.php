<div class="container mt-4 resguardantes-page">

    {{--
    |--------------------------------------------------------------------------
    | Límite de usuarios del tenant
    |--------------------------------------------------------------------------
    |
    | Se obtiene una sola vez el número de usuarios existentes para mostrar
    | el contador y bloquear visualmente la creación de nuevos resguardantes.
    |
    --}}

    @php
        $tenantUserLimit = app(\App\Services\TenantUserLimit::class);

        $usuariosUsados = $tenantUserLimit->used();
        $limiteUsuarios = $tenantUserLimit->limit();

        $usuariosDisponibles = max(
            0,
            $limiteUsuarios - $usuariosUsados
        );

        $limiteUsuariosAlcanzado =
            $usuariosUsados >= $limiteUsuarios;
    @endphp

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

        <a
            href="{{ url('/dashboard') }}"
            class="mobile-nav-btn primary"
        >
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
    <div
        class="resguardantes-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Módulo de resguardantes"
        data-tour-description="Desde aquí puedes consultar y administrar a las personas responsables de los bienes institucionales."
        data-tour-side="bottom"
    >

        <div class="resguardantes-header-information">

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

            {{-- BOTÓN DEL TUTORIAL --}}
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

                {{-- CONTADOR DE USUARIOS --}}
                <div
                    class="users-limit-card
                    {{ $limiteUsuariosAlcanzado ? 'limit-reached' : '' }}"
                >

                    <div class="users-limit-icon">

                        @if ($limiteUsuariosAlcanzado)
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
                            {{ $usuariosUsados }} de {{ $limiteUsuarios }}
                        </strong>

                        <span class="users-limit-remaining">

                            @if ($limiteUsuariosAlcanzado)

                                Límite alcanzado

                            @else

                                {{ $usuariosDisponibles }}

                                {{ $usuariosDisponibles === 1
                                    ? 'espacio disponible'
                                    : 'espacios disponibles'
                                }}

                            @endif

                        </span>

                    </div>

                </div>

                {{-- BOTÓN AGREGAR RESGUARDANTE --}}
                @if ($limiteUsuariosAlcanzado)

                    <button
                        type="button"
                        class="btn btn-add-resguardante btn-add-resguardante-disabled"
                        disabled
                        title="La institución alcanzó el límite de {{ $limiteUsuarios }} usuarios"
                        data-tour-step
                        data-tour-order="2"
                        data-tour-title="Límite alcanzado"
                        data-tour-description="La institución alcanzó el número máximo de usuarios permitidos."
                        data-tour-side="left"
                    >
                        <i class="fas fa-user-lock"></i>
                        <span>Límite alcanzado</span>
                    </button>

                @else

                    <button
                        type="button"
                        wire:click="showModalNewResguardante"
                        wire:loading.attr="disabled"
                        wire:target="showModalNewResguardante"
                        class="btn btn-add-resguardante"
                        data-tour-step
                        data-tour-order="2"
                        data-tour-title="Agregar resguardante"
                        data-tour-description="Presiona aquí para registrar una nueva persona responsable de bienes institucionales."
                        data-tour-side="left"
                    >
                        <span
                            wire:loading.remove
                            wire:target="showModalNewResguardante"
                        >
                            <i class="fas fa-plus"></i>
                        </span>

                        <span
                            wire:loading
                            wire:target="showModalNewResguardante"
                        >
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>

                        <span>Agregar resguardante</span>
                    </button>

                @endif

            @endhasanyrole

        </div>

    </div>

    {{-- MODAL --}}
    <div
        class="modal fade ieesspp-modal @if($showModal) show d-block @endif"
        tabindex="-1"
        role="dialog"
        aria-hidden="{{ $showModal ? 'false' : 'true' }}"
    >

        <div
            class="modal-dialog modal-lg
            {{ $accionPrincipal === 'editar'
                ? 'modal-dialog-centered'
                : ''
            }}
            ieesspp-modal-dialog"
            role="document"
        >

            <div class="modal-content ieesspp-modal-content">

                {{-- ENCABEZADO DEL MODAL --}}
                <div class="modal-header ieesspp-modal-header">

                    <div>

                        <span class="modal-label">
                            {{ $accionPrincipal === 'editar'
                                ? 'Edición de registro'
                                : 'Nuevo registro'
                            }}
                        </span>

                        <h5
                            class="modal-title"
                            id="studentModalLabel"
                        >
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

                {{-- CONTENIDO DEL MODAL --}}
                <div class="ieesspp-modal-body">

                    @switch($accionPrincipal)

                        {{-- EDITAR RESGUARDANTE --}}
                        @case('editar')

                            @livewire(
                                'update-resguardante',
                                ['data' => $data_external_component],
                                key(
                                    'update-resguardante-' .
                                    ($data_external_component['id'] ?? 'nuevo')
                                )
                            )

                        @break

                        {{-- CREAR NUEVO RESGUARDANTE --}}
                        @default

                            @if ($limiteUsuariosAlcanzado)

                                <div class="limit-modal-message">

                                    <div class="limit-modal-icon">
                                        <i class="fas fa-user-lock"></i>
                                    </div>

                                    <h5>
                                        Límite de usuarios alcanzado
                                    </h5>

                                    <p>
                                        Esta institución ya tiene los
                                        {{ $limiteUsuarios }} usuarios
                                        permitidos. No es posible registrar
                                        un nuevo resguardante hasta liberar
                                        un espacio.
                                    </p>

                                    <button
                                        type="button"
                                        class="btn btn-close-limit-modal"
                                        wire:click="closeModal"
                                    >
                                        Cerrar
                                    </button>

                                </div>

                            @else

                                @livewire(
                                    'create-new-resguardante',
                                    [],
                                    key('create-new-resguardante')
                                )

                            @endif

                        @break

                    @endswitch

                </div>

            </div>

        </div>

    </div>

    {{-- BUSCADOR --}}
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

                <label
                    for="searchid"
                    class="search-title"
                >
                    Buscar resguardante
                </label>

                <p class="search-description">
                    Escribe el nombre del resguardante. Los resultados se actualizan automáticamente.
                </p>

            </div>

            <div
                class="search-status"
                wire:loading
                wire:target="searchResguardantes"
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
                placeholder="Ejemplo: JONATHAN, JUAN, MARÍA..."
                wire:model="search"
                wire:keyup.debounce.400ms="searchResguardantes"
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
                {{ $resguardantes->total() }}

                {{ $resguardantes->total() === 1
                    ? 'registro'
                    : 'registros'
                }}
            </div>

        </div>

        <div class="table-responsive">

            <table class="table resguardantes-table mb-0">

                <thead>

                    <tr>

                        <th scope="col">
                            ID
                        </th>

                        <th scope="col">
                            Nombre del resguardante
                        </th>

                        <th scope="col">
                            Rol
                        </th>

                        <th
                            scope="col"
                            class="text-center"
                        >
                            Resguardos
                        </th>

                        @hasanyrole('Administrador')

                            <th
                                scope="col"
                                class="text-center"
                            >
                                Acciones
                            </th>

                        @endhasanyrole

                    </tr>

                </thead>

                <tbody>

                    @forelse ($resguardantes as $resguardante)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="id-badge">
                                    #{{ $resguardante->id }}
                                </span>

                            </td>

                            {{-- NOMBRE --}}
                            <td>

                                <div class="resguardante-info">

                                    <div class="avatar-resguardante">
                                        {{ strtoupper(
                                            substr(
                                                $resguardante->nombre1,
                                                0,
                                                1
                                            )
                                        ) }}

                                        {{ strtoupper(
                                            substr(
                                                $resguardante->apellido1,
                                                0,
                                                1
                                            )
                                        ) }}
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

                            {{-- ROL --}}
                            <td>

                                <span class="id-badge">
                                    {{ $resguardante->user?->roles?->first()?->name ?? 'SIN ROL' }}
                                </span>

                            </td>

                            {{-- RESGUARDOS --}}
                            <td class="text-center">

                                @if (
                                    auth()->user()->hasRole('Director') ||
                                    auth()->user()->hasRole('Delegacion') ||
                                    auth()->user()->hasRole('Administrador') ||
                                    (
                                        $resguardante->user &&
                                        $resguardante->user->subdireccion ===
                                        auth()->user()->subdireccion
                                    )
                                )

                                    <a
                                        href="{{ route(
                                            'resguardante.show',
                                            $resguardante->id
                                        ) }}"
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

                            {{-- ACCIONES --}}
                            @hasanyrole('Administrador')

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="cambiarAccion(
                                            'editar',
                                            {{ $resguardante->id }}
                                        )"
                                        wire:loading.attr="disabled"
                                        wire:target="cambiarAccion"
                                        title="Editar resguardante"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>

                                </td>

                            @endhasanyrole

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->hasRole('Administrador') ? 5 : 4 }}"
                            >

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>

                                    <h6>
                                        No se encontraron resguardantes
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

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/ieessppformtable.css') }}"
    >

    @push('js')

        @livewireScripts

        <script>
            document.addEventListener('livewire:initialized', function () {

                /*
                |--------------------------------------------------------------------------
                | Recargar página
                |--------------------------------------------------------------------------
                */

                Livewire.on('refresh-page', function () {
                    location.reload();
                });

                /*
                |--------------------------------------------------------------------------
                | Límite de usuarios alcanzado
                |--------------------------------------------------------------------------
                */

                Livewire.on('user-limit-reached', function (event) {

                    const payload = Array.isArray(event)
                        ? (event[0] ?? {})
                        : (event ?? {});

                    const limite = payload.limite ?? {{ $limiteUsuarios }};

                    Swal.fire({
                        title: 'Límite alcanzado',
                        text: `Esta institución ya tiene los ${limite} usuarios permitidos.`,
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: true,
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    });

                });

                /*
                |--------------------------------------------------------------------------
                | Resguardante creado
                |--------------------------------------------------------------------------
                */

                Livewire.on('alumno-created', function () {

                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Resguardante registrado con éxito!',
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

                /*
                |--------------------------------------------------------------------------
                | Resguardante actualizado
                |--------------------------------------------------------------------------
                */

                Livewire.on('alumno-updated', function () {

                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Resguardante actualizado con éxito!',
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
        /*
        |--------------------------------------------------------------------------
        | Página
        |--------------------------------------------------------------------------
        */

        .resguardantes-page {
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
            z-index: 99999;
            width: 100%;
            height: 4px;
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

        .resguardantes-header {
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

        .resguardantes-header-information {
            min-width: 0;
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

        /*
        |--------------------------------------------------------------------------
        | Acciones del encabezado
        |--------------------------------------------------------------------------
        */

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-shrink: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Botón del tutorial
        |--------------------------------------------------------------------------
        */

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
            white-space: nowrap;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-tour-help:hover,
        .btn-tour-help:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.20);
        }

        /*
        |--------------------------------------------------------------------------
        | Tarjeta del límite
        |--------------------------------------------------------------------------
        */

        .users-limit-card {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 178px;
            padding: 9px 12px;
            border: 1px solid rgba(23, 28, 99, 0.12);
            border-radius: 13px;
            background: rgba(23, 28, 99, 0.055);
        }

        .users-limit-card.limit-reached {
            border-color: rgba(185, 28, 28, 0.18);
            background: rgba(254, 226, 226, 0.62);
        }

        .users-limit-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #171C63;
            color: #ffffff;
            font-size: 13px;
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
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.045em;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .users-limit-value {
            margin-top: 2px;
            color: #171C63;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.2;
        }

        .users-limit-card.limit-reached .users-limit-value {
            color: #991b1b;
        }

        .users-limit-remaining {
            margin-top: 2px;
            color: #64748b;
            font-size: 10px;
            font-weight: 600;
            line-height: 1.2;
        }

        /*
        |--------------------------------------------------------------------------
        | Botón agregar
        |--------------------------------------------------------------------------
        */

        .btn-add-resguardante {
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

        .btn-add-resguardante:hover,
        .btn-add-resguardante:focus {
            color: #ffffff;
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.28);
        }

        .btn-add-resguardante:disabled,
        .btn-add-resguardante-disabled {
            cursor: not-allowed;
            background: #94a3b8;
            color: #ffffff;
            opacity: 1;
            filter: none;
            transform: none;
            box-shadow: none;
        }

        .btn-add-resguardante-disabled:hover,
        .btn-add-resguardante-disabled:focus {
            background: #94a3b8;
            color: #ffffff;
            filter: none;
            transform: none;
            box-shadow: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Modal
        |--------------------------------------------------------------------------
        */

        .ieesspp-modal {
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
        | Mensaje de límite dentro del modal
        |--------------------------------------------------------------------------
        */

        .limit-modal-message {
            padding: 42px 25px;
            text-align: center;
        }

        .limit-modal-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: #fee2e2;
            color: #b91c1c;
            font-size: 24px;
        }

        .limit-modal-message h5 {
            margin: 0;
            color: #0f172a;
            font-size: 19px;
            font-weight: 900;
        }

        .limit-modal-message p {
            max-width: 470px;
            margin: 10px auto 20px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.65;
        }

        .btn-close-limit-modal {
            min-height: 42px;
            padding: 0 20px;
            border: none;
            border-radius: 11px;
            background: #171C63;
            color: #ffffff;
            font-weight: 800;
        }

        .btn-close-limit-modal:hover {
            background: #26318f;
            color: #ffffff;
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

        .resguardantes-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .resguardantes-table thead th {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
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
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(
                135deg,
                rgba(23, 28, 99, 0.12),
                rgba(37, 99, 235, 0.12)
            );
            color: #171C63;
            font-size: 13px;
            font-weight: 900;
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
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .btn-view-resguardos:hover {
            background: #171C63;
            color: #ffffff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
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
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1200px) {

            .header-actions {
                flex-wrap: wrap;
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
                align-items: stretch;
                flex-direction: column;
            }

            .btn-tour-help,
            .btn-add-resguardante,
            .users-limit-card {
                width: 100%;
            }

            .users-limit-card {
                min-width: 0;
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

        @media (max-width: 768px) {

            .resguardantes-page {
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

            .resguardantes-header {
                margin-top: 4px;
                padding: 18px;
            }

            .resguardantes-title {
                font-size: 23px;
            }

            .search-panel {
                padding: 15px;
            }

            .table-card-header {
                padding: 16px;
            }

            .resguardantes-table thead th,
            .resguardantes-table tbody td {
                padding-right: 14px;
                padding-left: 14px;
            }

        }
    </style>

</div>