<div class="container mt-4 ubicaciones-page">

    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO --}}
    <div
        data-tour-page="ubicaciones-fisicas"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>

    {{-- LOADING BAR --}}
    <div
        wire:loading.delay
        wire:target="showModalNewUbicacionFisica,downloadEtiqueta,cambiarAccion,searchUbicacionesFisicas,clearSearch"
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
        class="ubicaciones-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Ubicaciones físicas"
        data-tour-description="En este módulo puedes registrar y consultar los espacios donde se encuentran los bienes institucionales."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div>
            <div class="ubicaciones-kicker">
                <i class="fas fa-map-marker-alt"></i>
                Inventario institucional
            </div>

            <h2 class="ubicaciones-title">
                Ubicaciones físicas
            </h2>

            <p class="ubicaciones-subtitle">
                Administra los espacios donde se resguardan los bienes institucionales.
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

            @hasanyrole('Administrador|Delegacion|Subdirector')
                <button
                    type="button"
                    wire:click="showModalImportUbicaciones"
                    wire:loading.attr="disabled"
                    wire:target="showModalImportUbicaciones"
                    class="btn btn-import-ubicaciones"
                >
                    <span
                        wire:loading.remove
                        wire:target="showModalImportUbicaciones"
                    >
                        <i class="fas fa-file-excel"></i>
                        Importar Excel
                    </span>

                    <span
                        wire:loading
                        wire:target="showModalImportUbicaciones"
                    >
                        <i class="fas fa-spinner fa-spin"></i>
                        Abriendo...
                    </span>
                </button>
            
                
                <button
                    type="button"
                    wire:click="showModalNewUbicacionFisica"
                    class="btn btn-add-ubicacion"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar ubicación"
                    data-tour-description="Presiona este botón para registrar un nuevo espacio físico y, cuando corresponda, agregar una fotografía."
                    data-tour-side="left"
                    data-tour-align="center"
                >
                    <i class="fas fa-plus"></i>
                    <span>Agregar ubicación física</span>
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

                        {{-- EDITAR UBICACIÓN FÍSICA --}}
                        @case("editar")
                            @livewire('update-ubicacion-fisica', ['data' => $data_external_component])
                        @break

                        {{-- CREAR NUEVA UBICACIÓN FÍSICA --}}
                        @default
                            @livewire('create-new-ubicacionfisica')
                        @break

                    @endswitch
                </div>

            </div>
        </div>
    </div>

        @if($showImportModal)
        <div
            class="modal fade show d-block ubicaciones-import-modal"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-centered"
                role="document"
            >
                <div class="modal-content import-modal-content">

                    <div class="import-modal-header">
                        <div>
                            <span>Carga masiva del catálogo</span>

                            <h5>
                                Importar ubicaciones físicas
                            </h5>
                        </div>

                        <button
                            type="button"
                            wire:click="closeImportModal"
                            wire:loading.attr="disabled"
                            wire:target="importarUbicacionesFisicas"
                            class="import-modal-close"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="import-modal-body">

                        <div class="import-information">
                            <div class="import-information-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>

                            <div>
                                <strong>Formato requerido</strong>

                                <p>
                                    La primera celda debe llamarse
                                    exactamente
                                    <b>descripcion</b>.
                                </p>
                            </div>
                        </div>

                        <form
                            wire:submit.prevent="importarUbicacionesFisicas"
                        >
                            <label
                                for="archivoUbicaciones"
                                class="import-label"
                            >
                                Seleccionar archivo
                            </label>

                            <input
                                type="file"
                                id="archivoUbicaciones"
                                wire:model="archivoUbicaciones"
                                accept=".xlsx,.xls,.csv"
                                class="form-control import-file-input"
                            >

                            <p class="import-help">
                                Formatos permitidos: XLSX, XLS y CSV.
                                Tamaño máximo: 10 MB.
                            </p>

                            @error('archivoUbicaciones')
                                <div class="import-file-error">
                                    <i class="fas fa-circle-exclamation"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <div
                                wire:loading
                                wire:target="archivoUbicaciones"
                                class="import-file-loading"
                            >
                                <i class="fas fa-spinner fa-spin"></i>
                                Cargando archivo...
                            </div>

                            @if($archivoUbicaciones)
                                <div class="import-selected-file">
                                    <i class="fas fa-file-excel"></i>

                                    <div>
                                        <span>
                                            Archivo seleccionado
                                        </span>

                                        <strong>
                                            {{ $archivoUbicaciones->getClientOriginalName() }}
                                        </strong>
                                    </div>
                                </div>
                            @endif

                            <div class="import-example">
                                <div class="import-example-title">
                                    Ejemplo del archivo
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>descripcion</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>ALMACÉN GENERAL</td>
                                            </tr>

                                            <tr>
                                                <td>SALA DE JUNTAS</td>
                                            </tr>

                                            <tr>
                                                <td>OFICINA DE DIRECCIÓN</td>
                                            </tr>

                                            <tr>
                                                <td>LABORATORIO DE CÓMPUTO</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if(
                                $ubicacionesImportadas > 0
                                || $ubicacionesDuplicadas > 0
                            )
                                <div class="import-summary">
                                    <div class="import-summary-item success">
                                        <span>Nuevas</span>

                                        <strong>
                                            {{ $ubicacionesImportadas }}
                                        </strong>
                                    </div>

                                    <div class="import-summary-item warning">
                                        <span>Duplicadas</span>

                                        <strong>
                                            {{ $ubicacionesDuplicadas }}
                                        </strong>
                                    </div>
                                </div>
                            @endif

                            @if(count($erroresImportacion) > 0)
                                <div class="import-errors">
                                    <strong>
                                        Filas que no se importaron
                                    </strong>

                                    @foreach(
                                        $erroresImportacion as $error
                                    )
                                        <div class="import-error-row">
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
                                                    <li>
                                                        {{ $mensaje }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="import-actions">
                                <button
                                    type="button"
                                    wire:click="closeImportModal"
                                    wire:loading.attr="disabled"
                                    wire:target="importarUbicacionesFisicas"
                                    class="btn-cancel-import"
                                >
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="archivoUbicaciones,importarUbicacionesFisicas"
                                    class="btn-confirm-import"
                                >
                                    <span
                                        wire:loading.remove
                                        wire:target="importarUbicacionesFisicas"
                                    >
                                        <i class="fas fa-file-import"></i>
                                        Importar ubicaciones
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="importarUbicacionesFisicas"
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
        data-tour-title="Buscar ubicaciones"
        data-tour-description="Escribe el nombre o la descripción de una ubicación. Los resultados se actualizan automáticamente."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div class="search-panel-header">
            <div>
                <label for="searchid" class="search-title">
                    Buscar ubicación física
                </label>

                <p class="search-description">
                    Escribe el nombre o descripción de la ubicación. Los resultados se actualizan automáticamente.
                </p>
            </div>

            <div class="search-status" wire:loading wire:target="searchUbicacionesFisicas">
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
                placeholder="Ejemplo: ALMACÉN GENERAL"
                wire:model="search"
                wire:keyup.debounce.400ms="searchUbicacionesFisicas"
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
        data-tour-title="Ubicaciones registradas"
        data-tour-description="Aquí puedes consultar las ubicaciones, sus imágenes y las acciones disponibles para cada registro."
        data-tour-side="top"
        data-tour-align="center"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Ubicaciones registradas
                </h5>

                <p class="table-subtitle">
                    Listado general de espacios físicos disponibles en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $ubicacionesfisicas->total() }} registros
            </div>
        </div>

        <div class="table-responsive">
            <table class="table ubicaciones-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Ubicación física</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($ubicacionesfisicas as $ubicacion)
                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $ubicacion->id }}
                                </span>
                            </td>

                            <td>
                                @if($ubicacion->imagen)
                                    <a
                                        href="{{ asset('storage/' . $ubicacion->imagen) }}"
                                        target="_blank"
                                        class="ubicacion-image-link"
                                        title="Ver imagen"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $ubicacion->imagen) }}"
                                            alt="Imagen de la ubicación"
                                            class="ubicacion-image"
                                        >
                                    </a>
                                @else
                                    <span class="no-image-badge">
                                        <i class="fas fa-image"></i>
                                        Sin imagen
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="ubicacion-info">
                                    <div class="ubicacion-icon">
                                        <i class="fas fa-building"></i>
                                    </div>

                                    <div>
                                        <div class="ubicacion-name">
                                            {{ $ubicacion->descripcion }}
                                        </div>

                                        <div class="ubicacion-meta">
                                            Espacio físico institucional
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div
                                    class="actions-group"
                                    data-tour-step
                                    data-tour-order="5"
                                    data-tour-title="Acciones de ubicación"
                                    data-tour-description="Desde estos botones puedes editar, descargar la etiqueta o consultar el inventario asociado a la ubicación."
                                    data-tour-side="left"
                                    data-tour-align="center"
                                >

                                    @hasanyrole('Administrador')
                                        <button
                                            type="button"
                                            class="btn-action-edit"
                                            wire:click="cambiarAccion('editar', {{ $ubicacion->id }})"
                                            title="Editar ubicación"
                                        >
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="downloadEtiqueta({{ $ubicacion->id }})"
                                            class="btn-action-download"
                                            title="Descargar etiqueta"
                                        >
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endhasanyrole

                                    <a
                                        href="{{ route('ubicacionfisica.show', $ubicacion->id) }}"
                                        class="btn-action-view"
                                        title="Ver inventario en esta ubicación"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>

                                    <h6>No se encontraron ubicaciones físicas</h6>

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
        data-tour-order="6"
        data-tour-title="Navegar entre páginas"
        data-tour-description="Utiliza estos controles para consultar las demás ubicaciones registradas."
        data-tour-side="top"
        data-tour-align="end"
    >
        {{ $ubicacionesfisicas->links() }}
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
                        text: '¡Ubicación física registrada con éxito!',
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
                        text: '¡Ubicación física actualizada con éxito!',
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

                Livewire.on('limpiar-archivo-ubicaciones', function () {
                    const input = document.getElementById(
                        'archivoUbicaciones'
                    );

                    if (input) {
                        input.value = '';
                    }
                });

                Livewire.on('ubicaciones-importadas', function (event) {
                    Swal.fire({
                        title: '¡Importación terminada!',
                        text: event.mensaje
                            ?? 'Las ubicaciones fueron importadas correctamente.',
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
                    'ubicaciones-importacion-advertencia',
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

            });
        </script>
    @endpush

    <style>
        .ubicaciones-page {
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

        .ubicaciones-header {
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

        .ubicaciones-kicker {
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

        .ubicaciones-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .ubicaciones-subtitle {
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

        .btn-add-ubicacion {
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

        .btn-add-ubicacion:hover {
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

        .ubicaciones-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .ubicaciones-table thead th {
            padding: 14px 20px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .ubicaciones-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .ubicaciones-table tbody tr {
            transition: background 0.16s ease;
        }

        .ubicaciones-table tbody tr:hover {
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

        .ubicacion-image-link {
            display: inline-block;
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
        }

        .ubicacion-image {
            width: 86px;
            height: 62px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .ubicacion-image:hover {
            transform: scale(1.04);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.14);
        }

        .no-image-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ubicacion-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ubicacion-icon {
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

        .ubicacion-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25;
        }

        .ubicacion-meta {
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
            .ubicaciones-page {
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

            .ubicaciones-header {
                margin-top: 4px;
            }
        }

        @media (max-width: 992px) {
            .ubicaciones-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-tour,
            .btn-add-ubicacion {
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

        .btn-import-ubicaciones {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border: 1px solid #15803d;
            border-radius: 12px;
            background: #ffffff;
            color: #15803d;
            font-weight: 800;
        }

        .btn-import-ubicaciones span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-import-ubicaciones:hover {
            background: #15803d;
            color: #ffffff;
        }

        .ubicaciones-import-modal {
            background: rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(5px);
        }

        .import-modal-content {
            overflow: hidden;
            border: none;
            border-radius: 18px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.28);
        }

        .import-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            background: linear-gradient(
                135deg,
                #14532d,
                #15803d
            );
            color: #ffffff;
        }

        .import-modal-header span {
            color: rgba(255, 255, 255, 0.75);
            font-size: 12px;
        }

        .import-modal-header h5 {
            margin: 3px 0 0;
            font-size: 18px;
            font-weight: 800;
        }

        .import-modal-close {
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .import-modal-body {
            padding: 24px;
            background: #ffffff;
        }

        .import-information {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #bbf7d0;
            border-radius: 13px;
            background: #f0fdf4;
        }

        .import-information-icon {
            display: inline-flex;
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #dcfce7;
            color: #15803d;
            font-size: 20px;
        }

        .import-information p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .import-label {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
        }

        .import-file-input {
            min-height: 48px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
        }

        .import-help {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        .import-file-error {
            margin-top: 10px;
            padding: 11px 13px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 700;
        }

        .import-file-loading {
            margin-top: 12px;
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        .import-selected-file {
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

        .import-selected-file > i {
            font-size: 22px;
        }

        .import-selected-file span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .import-selected-file strong {
            display: block;
            margin-top: 2px;
        }

        .import-example {
            overflow: hidden;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        .import-example-title {
            padding: 11px 14px;
            background: #f8fafc;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .import-example th,
        .import-example td {
            padding: 9px 14px;
            font-size: 12px;
        }

        .import-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
        }

        .import-summary-item {
            padding: 13px;
            border-radius: 11px;
        }

        .import-summary-item.success {
            background: #f0fdf4;
            color: #166534;
        }

        .import-summary-item.warning {
            background: #fffbeb;
            color: #92400e;
        }

        .import-summary-item span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .import-summary-item strong {
            display: block;
            margin-top: 2px;
            font-size: 20px;
        }

        .import-errors {
            margin-top: 18px;
            padding: 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
        }

        .import-error-row {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            background: #ffffff;
            font-size: 12px;
        }

        .import-error-row ul {
            margin: 6px 0 0;
            padding-left: 18px;
        }

        .import-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-cancel-import,
        .btn-confirm-import {
            min-height: 44px;
            padding: 0 18px;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 800;
        }

        .btn-cancel-import {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .btn-confirm-import {
            border: none;
            background: linear-gradient(
                135deg,
                #15803d,
                #16a34a
            );
            color: #ffffff;
        }

        .btn-confirm-import span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .import-modal-body {
                padding: 18px;
            }

            .import-summary {
                grid-template-columns: 1fr;
            }

            .import-actions {
                flex-direction: column-reverse;
            }

            .btn-cancel-import,
            .btn-confirm-import {
                width: 100%;
            }
        }
    </style>
</div>