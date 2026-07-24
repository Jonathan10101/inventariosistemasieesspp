<div class="container mt-4 puestos-page">

    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO --}}
    <div
        data-tour-page="puestos"
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
        class="puestos-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Catálogo de puestos"
        data-tour-description="En este módulo puedes consultar, registrar y actualizar los puestos institucionales utilizados para los resguardantes."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div>
            <div class="puestos-kicker">
                <i class="fas fa-briefcase"></i>
                Inventario institucional
            </div>

            <h2 class="puestos-title">
                Catálogo de puestos
            </h2>

            <p class="puestos-subtitle">
                Administra los puestos utilizados para asignar responsables y controlar bienes institucionales.
            </p>
        </div>

        <div class="header-actions">
            <button
                type="button"
                class="btn btn-tour-puesto"
                data-tour-start
                title="Ver tutorial del módulo"
            >
                <i class="fas fa-circle-question"></i>
                <span>Ver tutorial</span>
            </button>

            @hasanyrole('Administrador')
              <button
                type="button"
                wire:click="showModalImportPuestos"
                wire:loading.attr="disabled"
                wire:target="showModalImportPuestos"
                title="Importar puestos desde Excel"
                class="btn btn-outline-success"   
                data-tour-step
                data-tour-order="6"
                data-tour-title="Importar datos"
                data-tour-description="Presiona este botón para importar datos de forma masiva y ahorrar tiempo al registrar de manera manual, solo tienes que generar un excel e importarlo."
                data-tour-side="left" 
            >
                <span
                    wire:loading.remove
                    wire:target="showModalImportPuestos"
                >
                    <i class="fas fa-file-excel"></i>
                    Importar Excel
                </span>

                <span
                    wire:loading
                    wire:target="showModalImportPuestos"
                >
                    <i class="fas fa-spinner fa-spin"></i>
                    Abriendo...
                </span>
            </button>
                <button
                    type="button"
                    wire:click="showModalNewPuesto"
                    class="btn btn-add-puesto"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar un puesto"
                    data-tour-description="Presiona este botón para registrar un nuevo puesto institucional."
                    data-tour-side="left"
                    data-tour-align="center"
                >
                    <i class="fas fa-plus"></i>
                    <span>Agregar puesto</span>
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

                        {{-- EDITAR PUESTO --}}
                        @case("editar")
                            @livewire('update-puesto', ['data' => $data_external_component])
                        @break

                        {{-- CREAR NUEVO PUESTO --}}
                        @default
                            @livewire('create-new-puesto')
                        @break

                    @endswitch
                </div>

            </div>
        </div>
    </div>

    @if($showImportModal)
        <div
            class="modal fade ieesspp-modal show d-block"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-centered ieesspp-modal-dialog"
                role="document"
            >
                <div class="modal-content ieesspp-modal-content">

                    <div class="modal-header ieesspp-modal-header import-puestos-header">
                        <div>
                            <span class="modal-label">
                                Carga masiva del catálogo
                            </span>

                            <h5 class="modal-title">
                                Importar puestos desde Excel
                            </h5>
                        </div>

                        <button
                            type="button"
                            class="modal-close-btn"
                            wire:click="closeImportModal"
                            wire:loading.attr="disabled"
                            wire:target="importarPuestos"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="import-puestos-body">

                        <div class="import-puestos-info">
                            <div class="import-puestos-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>

                            <div>
                                <strong>Formato requerido</strong>

                                <p>
                                    La celda A1 debe llamarse exactamente
                                    <b>nombre</b>.
                                </p>
                            </div>
                        </div>

                        <form wire:submit.prevent="importarPuestos">

                            <label
                                for="archivoPuestos"
                                class="import-puestos-label"
                            >
                                Seleccionar archivo
                            </label>

                            <input
                                type="file"
                                id="archivoPuestos"
                                wire:model="archivoPuestos"
                                accept=".xlsx,.xls,.csv"
                            >

                            <p class="import-puestos-help">
                                Formatos permitidos: XLSX, XLS y CSV.
                                Tamaño máximo: 10 MB.
                            </p>

                            @error('archivoPuestos')
                                <div class="import-puestos-error">
                                    <i class="fas fa-circle-exclamation"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <div
                                wire:loading
                                wire:target="archivoPuestos"
                                class="import-puestos-loading"
                            >
                                <i class="fas fa-spinner fa-spin"></i>
                                Cargando archivo...
                            </div>

                            @if($archivoPuestos)
                                <div class="import-puestos-selected">
                                    <i class="fas fa-file-excel"></i>

                                    <div>
                                        <span>Archivo seleccionado</span>

                                        <strong>
                                            {{ $archivoPuestos->getClientOriginalName() }}
                                        </strong>
                                    </div>
                                </div>
                            @endif

                            <div class="import-puestos-example">
                                <div class="import-puestos-example-title">
                                    Ejemplo del archivo
                                </div>

                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>nombre</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>DIRECTOR GENERAL</td>
                                        </tr>

                                        <tr>
                                            <td>SUBDIRECTOR</td>
                                        </tr>

                                        <tr>
                                            <td>JEFE DE DEPARTAMENTO</td>
                                        </tr>

                                        <tr>
                                            <td>ANALISTA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if(
                                $puestosImportados > 0
                                || $puestosDuplicados > 0
                            )
                                <div class="import-puestos-summary">
                                    <div>
                                        <span>Nuevos</span>
                                        <strong>{{ $puestosImportados }}</strong>
                                    </div>

                                    <div>
                                        <span>Duplicados</span>
                                        <strong>{{ $puestosDuplicados }}</strong>
                                    </div>
                                </div>
                            @endif

                            @if(count($erroresImportacion) > 0)
                                <div class="import-puestos-row-errors">
                                    <strong>
                                        Filas que no se importaron
                                    </strong>

                                    @foreach($erroresImportacion as $error)
                                        <div class="import-puesto-row-error">
                                            <div>
                                                Fila {{ $error['fila'] }}

                                                @if(!empty($error['valor']))
                                                    — {{ $error['valor'] }}
                                                @endif
                                            </div>

                                            <ul>
                                                @foreach(
                                                    $error['mensajes']
                                                    as $mensaje
                                                )
                                                    <li>{{ $mensaje }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="import-puestos-actions">
                                <!--
                                <button
                                    type="button"
                                    wire:click="closeImportModal"
                                    wire:loading.attr="disabled"
                                    wire:target="importarPuestos"
                                    class="btn-cancel-puestos"
                                >
                                    Cancelar
                                </button>
                                -->

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="archivoPuestos,importarPuestos"
                                    class="btn-confirm-puestos"
                                >
                                    <span
                                        wire:loading.remove
                                        wire:target="importarPuestos"
                                    >
                                        <i class="fas fa-file-import"></i>
                                        Importar puestos
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="importarPuestos"
                                    >
                                        <i class="fas fa-spinner fa-spin"></i>
                                        Importando...
                                    </span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- BUSCADOR -->
    <div
        class="search-panel mb-4"
        data-tour-step
        data-tour-order="3"
        data-tour-title="Buscar puestos"
        data-tour-description="Escribe el nombre del puesto y la lista se actualizará automáticamente. También puedes limpiar la búsqueda con el botón de cerrar."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div class="search-panel-header">
            <div>
                <label for="searchid" class="search-title">
                    Buscar puesto
                </label>

                <p class="search-description">
                    Escribe el nombre del puesto. Los resultados se actualizan automáticamente.
                </p>
            </div>

            <div class="search-status" wire:loading wire:target="searchPuestos">
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
                placeholder="Ejemplo: DIRECTOR GENERAL"
                wire:model="search"
                wire:keyup.debounce.400ms="searchPuestos"
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
        data-tour-title="Puestos registrados"
        data-tour-description="Aquí puedes consultar los puestos disponibles. Los administradores también pueden editar cada registro desde la columna de acciones."
        data-tour-side="top"
        data-tour-align="center"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Puestos registrados
                </h5>

                <p class="table-subtitle">
                    Listado general de puestos disponibles en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $puestos->total() }} registros
            </div>
        </div>

        <div class="table-responsive">
            <table class="table puestos-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Puesto</th>

                        @hasanyrole('Administrador')
                            <th scope="col" class="text-center">Acciones</th>
                        @endhasanyrole
                    </tr>
                </thead>

                <tbody>
                    @forelse ($puestos as $puesto)
                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $puesto->id }}
                                </span>
                            </td>

                            <td>
                                <div class="puesto-info">
                                    <div class="puesto-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>

                                    <div>
                                        <div class="puesto-name">
                                            {{ $puesto->nombre }}
                                        </div>

                                        <div class="puesto-meta">
                                            Puesto institucional
                                        </div>
                                    </div>
                                </div>
                            </td>

                            @hasanyrole('Administrador')
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="cambiarAccion('editar', {{ $puesto->id }})"
                                        title="Editar puesto"
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
                                        <i class="fas fa-briefcase"></i>
                                    </div>

                                    <h6>No se encontraron puestos</h6>

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
        data-tour-title="Cambiar de página"
        data-tour-description="Utiliza estos controles para recorrer todas las páginas del catálogo de puestos."
        data-tour-side="top"
        data-tour-align="end"
    >
        {{ $puestos->links() }}
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

                Livewire.on('limpiar-archivo-puestos', function () {
                    const input = document.getElementById('archivoPuestos');

                    if (input) {
                        input.value = '';
                    }
                });

                Livewire.on('puestos-importados', function (event) {
                    Swal.fire({
                        title: '¡Importación terminada!',
                        text: event.mensaje ?? 'Los puestos fueron importados correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            confirmButton: 'btn-ieesspp'
                        },
                        buttonsStyling: false
                    });
                });

                Livewire.on(
                    'puestos-importacion-advertencia',
                    function (event) {
                        Swal.fire({
                            title: 'Importación finalizada',
                            text: event.mensaje
                                ?? 'Algunas filas no pudieron importarse.',
                            icon: 'warning',
                            confirmButtonText: 'Revisar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            customClass: {
                                confirmButton: 'btn-ieesspp'
                            },
                            buttonsStyling: false
                        });
                    }
                );

                Livewire.on('alumno-created', function ($message) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '¡Puesto registrado con éxito!',
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
                        text: '¡Puesto actualizado con éxito!',
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
        .puestos-page {
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

        .puestos-header {
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

        .puestos-kicker {
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

        .puestos-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .puestos-subtitle {
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

        .btn-tour-puesto {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 16px;
            border: 1px solid rgba(23, 28, 99, 0.18);
            border-radius: 12px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-tour-puesto:hover,
        .btn-tour-puesto:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
        }

        .btn-add-puesto {
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

        .btn-add-puesto:hover {
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

        .puestos-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .puestos-table thead th {
            padding: 14px 20px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .puestos-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .puestos-table tbody tr {
            transition: background 0.16s ease;
        }

        .puestos-table tbody tr:hover {
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

        .puesto-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .puesto-icon {
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

        .puesto-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .puesto-meta {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
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

            .puestos-header {
                margin-top: 4px;
            }
        }

        @media (max-width: 992px) {
            .puestos-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions,
            .btn-tour-puesto,
            .btn-add-puesto,
            .btn-outline-success {
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

        .btn-import-puestos {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 18px;
            border: 1px solid #15803d;
            border-radius: 12px;
            background: #ffffff;
            color: #15803d;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(21, 128, 61, 0.10);
        }

        .btn-import-puestos span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-import-puestos:hover {
            background: #15803d;
            color: #ffffff;
        }

        .import-puestos-header {
            background: linear-gradient(
                135deg,
                #14532d 0%,
                #15803d 100%
            );
        }

        .import-puestos-body {
            padding: 24px;
            background: #ffffff;
        }

        .import-puestos-info {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #bbf7d0;
            border-radius: 13px;
            background: #f0fdf4;
        }

        .import-puestos-info p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .import-puestos-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #dcfce7;
            color: #15803d;
            font-size: 20px;
        }

        .import-puestos-label {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
        }

        .import-puestos-input {
            min-height: 48px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
        }

        .import-puestos-help {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        .import-puestos-error {
            margin-top: 10px;
            padding: 11px 13px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 700;
        }

        .import-puestos-loading {
            margin-top: 12px;
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        .import-puestos-selected {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 14px;
            padding: 13px;
            border: 1px solid #bbf7d0;
            border-radius: 11px;
            background: #f0fdf4;
            color: #166534;
        }

        .import-puestos-selected > i {
            font-size: 22px;
        }

        .import-puestos-selected span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .import-puestos-selected strong {
            display: block;
            margin-top: 2px;
        }

        .import-puestos-example {
            overflow: hidden;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        .import-puestos-example-title {
            padding: 11px 14px;
            background: #f8fafc;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .import-puestos-example th,
        .import-puestos-example td {
            padding: 9px 14px;
            font-size: 12px;
        }

        .import-puestos-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
        }

        .import-puestos-summary > div {
            padding: 13px;
            border-radius: 11px;
            background: #f1f5f9;
        }

        .import-puestos-summary span {
            display: block;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .import-puestos-summary strong {
            display: block;
            margin-top: 2px;
            color: #171C63;
            font-size: 20px;
        }

        .import-puestos-row-errors {
            margin-top: 18px;
            padding: 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
        }

        .import-puesto-row-error {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            background: #ffffff;
            font-size: 12px;
        }

        .import-puesto-row-error ul {
            margin: 6px 0 0;
            padding-left: 18px;
        }

        .import-puestos-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-cancel-puestos,
        .btn-confirm-puestos {
            min-height: 44px;
            padding: 0 18px;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 800;
        }

        .btn-cancel-puestos {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .btn-confirm-puestos {
            border: none;
            background: linear-gradient(
                135deg,
                #15803d,
                #16a34a
            );
            color: #ffffff;
        }

        .btn-confirm-puestos span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 992px) {
            .btn-import-puestos {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .import-puestos-body {
                padding: 18px;
            }

            .import-puestos-summary {
                grid-template-columns: 1fr;
            }

            .import-puestos-actions {
                flex-direction: column-reverse;
            }

            .btn-cancel-puestos,
            .btn-confirm-puestos {
                width: 100%;
            }
        }
    </style>

</div>