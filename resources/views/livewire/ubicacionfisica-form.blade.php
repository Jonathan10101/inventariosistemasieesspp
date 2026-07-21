<div class="container mt-4 ubicaciones-page">

    {{-- ========================================================= --}}
    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO                          --}}
    {{-- ========================================================= --}}
    <div
        data-tour-page="ubicaciones-fisicas"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>

    {{-- ========================================================= --}}
    {{-- BARRA DE CARGA                                            --}}
    {{-- ========================================================= --}}
    <div
        wire:loading.delay
        wire:target="showModalNewUbicacionFisica,showModalImportUbicaciones,closeImportModal,archivoUbicaciones,importarUbicacionesFisicas,downloadEtiqueta,cambiarAccion,searchUbicacionesFisicas,clearSearch"
        class="ieesspp-loading-bar"
    >
        <div class="progress w-100 h-100 rounded-0">
            <div
                class="progress-bar progress-bar-striped progress-bar-animated w-100"
            ></div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- NAVEGACIÓN MÓVIL                                          --}}
    {{-- ========================================================= --}}
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

    {{-- ========================================================= --}}
    {{-- SWEETALERT2                                               --}}
    {{-- ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    {{-- ========================================================= --}}
    {{-- ENCABEZADO PRINCIPAL                                      --}}
    {{-- ========================================================= --}}
    <div
        class="ubicaciones-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Ubicaciones físicas"
        data-tour-description="En este módulo puedes registrar, importar y consultar los espacios donde se encuentran los bienes institucionales."
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
                Administra los espacios donde se resguardan los bienes
                institucionales.
            </p>
        </div>

        <div class="header-actions">

            {{-- BOTÓN DEL TUTORIAL --}}
            <button
                type="button"
                class="btn btn-tour"
                data-tour-start
                title="Ver tutorial del módulo"
            >
                <i class="fas fa-circle-question"></i>
                <span>Ver tutorial</span>
            </button>

            @hasanyrole('Administrador|Delegacion|Subdirector')

                {{-- BOTÓN IMPORTAR EXCEL --}}
                <button
                    type="button"
                    wire:click="showModalImportUbicaciones"
                    wire:loading.attr="disabled"
                    wire:target="showModalImportUbicaciones"
                    class="btn btn-import-ubicaciones"
                    title="Importar ubicaciones físicas desde Excel"
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

                {{-- BOTÓN AGREGAR UBICACIÓN --}}
                <button
                    type="button"
                    wire:click="showModalNewUbicacionFisica"
                    wire:loading.attr="disabled"
                    wire:target="showModalNewUbicacionFisica"
                    class="btn btn-add-ubicacion"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar ubicación"
                    data-tour-description="Presiona este botón para registrar un nuevo espacio físico y agregar una fotografía cuando corresponda."
                    data-tour-side="left"
                    data-tour-align="center"
                >
                    <span
                        wire:loading.remove
                        wire:target="showModalNewUbicacionFisica"
                    >
                        <i class="fas fa-plus"></i>
                        Agregar ubicación física
                    </span>

                    <span
                        wire:loading
                        wire:target="showModalNewUbicacionFisica"
                    >
                        <i class="fas fa-spinner fa-spin"></i>
                        Abriendo...
                    </span>
                </button>

            @endhasanyrole
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MODAL PARA REGISTRAR O EDITAR                             --}}
    {{-- ========================================================= --}}
    @if($showModal)
        <div
            class="modal fade ieesspp-modal show d-block"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
            aria-labelledby="ubicacionModalTitle"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-centered ieesspp-modal-dialog"
                role="document"
            >
                <div class="modal-content ieesspp-modal-content">

                    <div class="modal-header ieesspp-modal-header">
                        <div>
                            <span class="modal-label">
                                {{ $accionPrincipal === 'editar'
                                    ? 'Edición de registro'
                                    : 'Nuevo registro' }}
                            </span>

                            <h5
                                class="modal-title"
                                id="ubicacionModalTitle"
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

                    <div class="ieesspp-modal-body">
                        @switch($accionPrincipal)

                            {{-- EDITAR UBICACIÓN FÍSICA --}}
                            @case('editar')
                                @livewire(
                                    'update-ubicacion-fisica',
                                    [
                                        'data' => $data_external_component
                                    ],
                                    key(
                                        'update-ubicacion-fisica-'
                                        . $data_external_component
                                    )
                                )
                            @break

                            {{-- CREAR UBICACIÓN FÍSICA --}}
                            @default
                                @livewire(
                                    'create-new-ubicacionfisica',
                                    [],
                                    key('create-new-ubicacionfisica')
                                )
                            @break

                        @endswitch
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- MODAL PARA IMPORTAR UBICACIONES                           --}}
    {{-- ========================================================= --}}
    @if($showImportModal)
        <div
            class="modal fade show d-block ubicaciones-import-modal"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
            aria-labelledby="importarUbicacionesTitle"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-centered import-modal-dialog"
                role="document"
            >
                <div class="modal-content import-modal-content">

                    {{-- ENCABEZADO --}}
                    <div class="import-modal-header">
                        <div>
                            <span>
                                Carga masiva del catálogo
                            </span>

                            <h5 id="importarUbicacionesTitle">
                                Importar ubicaciones físicas
                            </h5>
                        </div>

                        <button
                            type="button"
                            wire:click="closeImportModal"
                            wire:loading.attr="disabled"
                            wire:target="importarUbicacionesFisicas"
                            class="import-modal-close"
                            aria-label="Cerrar"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- CUERPO --}}
                    <div class="import-modal-body">

                        {{-- INFORMACIÓN --}}
                        <div class="import-information">
                            <div class="import-information-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>

                            <div>
                                <strong>
                                    Formato requerido
                                </strong>

                                <p>
                                    La primera celda del archivo debe llamarse
                                    exactamente
                                    <b>descripcion</b>.
                                </p>
                            </div>
                        </div>

                        <form
                            wire:submit.prevent="importarUbicacionesFisicas"
                        >
                            {{-- ARCHIVO --}}
                            <div class="import-field">
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

                                        <span>
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                            </div>

                            {{-- CARGANDO ARCHIVO --}}
                            <div
                                wire:loading
                                wire:target="archivoUbicaciones"
                                class="import-file-loading"
                            >
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Cargando archivo...</span>
                            </div>

                            {{-- ARCHIVO SELECCIONADO --}}
                            @if($archivoUbicaciones)
                                <div class="import-selected-file">
                                    <div class="import-selected-icon">
                                        <i class="fas fa-file-excel"></i>
                                    </div>

                                    <div class="import-selected-info">
                                        <span>
                                            Archivo seleccionado
                                        </span>

                                        <strong>
                                            {{ $archivoUbicaciones->getClientOriginalName() }}
                                        </strong>
                                    </div>

                                    <div class="import-selected-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            @endif

                            {{-- EJEMPLO DEL EXCEL --}}
                            <div class="import-example">
                                <div class="import-example-header">
                                    <div>
                                        <div class="import-example-title">
                                            Estructura del archivo
                                        </div>

                                        <p>
                                            No coloques títulos, instrucciones
                                            o filas vacías antes del encabezado.
                                        </p>
                                    </div>

                                    <span class="import-example-badge">
                                        Excel
                                    </span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table import-example-table mb-0">
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

                            {{-- RESUMEN --}}
                            @if(
                                $ubicacionesImportadas > 0
                                || $ubicacionesDuplicadas > 0
                            )
                                <div class="import-summary">
                                    <div class="import-summary-item primary">
                                        <div class="import-summary-icon">
                                            <i class="fas fa-check"></i>
                                        </div>

                                        <div>
                                            <span>
                                                Nuevas ubicaciones
                                            </span>

                                            <strong>
                                                {{ $ubicacionesImportadas }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="import-summary-item warning">
                                        <div class="import-summary-icon">
                                            <i class="fas fa-copy"></i>
                                        </div>

                                        <div>
                                            <span>
                                                Duplicadas
                                            </span>

                                            <strong>
                                                {{ $ubicacionesDuplicadas }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ERRORES DE FILAS --}}
                            @if(count($erroresImportacion) > 0)
                                <div class="import-errors">
                                    <div class="import-errors-title">
                                        <i class="fas fa-triangle-exclamation"></i>

                                        <div>
                                            <strong>
                                                Filas que no se importaron
                                            </strong>

                                            <span>
                                                Corrige estos registros antes
                                                de volver a cargar el archivo.
                                            </span>
                                        </div>
                                    </div>

                                    <div class="import-errors-list">
                                        @foreach(
                                            $erroresImportacion as $error
                                        )
                                            <div class="import-error-row">
                                                <div class="import-error-row-header">
                                                    <strong>
                                                        Fila
                                                        {{ $error['fila'] }}
                                                    </strong>

                                                    @if(!empty($error['valor']))
                                                        <span>
                                                            {{ $error['valor'] }}
                                                        </span>
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
                                </div>
                            @endif

                            {{-- BOTONES --}}
                            <div class="import-actions">
                                <button
                                    type="button"
                                    wire:click="closeImportModal"
                                    wire:loading.attr="disabled"
                                    wire:target="importarUbicacionesFisicas"
                                    class="btn-cancel-import"
                                >
                                    <i class="fas fa-times"></i>
                                    <span>Cancelar</span>
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

    {{-- ========================================================= --}}
    {{-- BUSCADOR                                                  --}}
    {{-- ========================================================= --}}
    <div
        class="search-panel mb-4"
        data-tour-step
        data-tour-order="3"
        data-tour-title="Buscar ubicaciones"
        data-tour-description="Escribe el nombre, descripción o identificador de una ubicación. Los resultados se actualizan automáticamente."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div class="search-panel-header">
            <div>
                <label
                    for="searchid"
                    class="search-title"
                >
                    Buscar ubicación física
                </label>

                <p class="search-description">
                    Escribe el nombre, descripción o identificador
                    de la ubicación.
                </p>
            </div>

            <div
                class="search-status"
                wire:loading
                wire:target="searchUbicacionesFisicas"
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

    {{-- ========================================================= --}}
    {{-- TABLA                                                     --}}
    {{-- ========================================================= --}}
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
                    Listado general de espacios físicos disponibles
                    en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $ubicacionesfisicas->total() }}

                {{ $ubicacionesfisicas->total() === 1
                    ? 'registro'
                    : 'registros' }}
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
                    @forelse($ubicacionesfisicas as $ubicacion)
                        <tr wire:key="ubicacion-{{ $ubicacion->id }}">
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
                                            alt="Imagen de {{ $ubicacion->descripcion }}"
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
                                    data-tour-description="Desde estos botones puedes editar, descargar la etiqueta o consultar el inventario asociado."
                                    data-tour-side="left"
                                    data-tour-align="center"
                                >
                                    @hasanyrole('Administrador')
                                        <button
                                            type="button"
                                            class="btn-action-edit"
                                            wire:click="cambiarAccion('editar', {{ $ubicacion->id }})"
                                            wire:loading.attr="disabled"
                                            title="Editar ubicación"
                                        >
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="downloadEtiqueta({{ $ubicacion->id }})"
                                            wire:loading.attr="disabled"
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
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>

                                    <h6>
                                        No se encontraron ubicaciones físicas
                                    </h6>

                                    <p>
                                        Intenta con otro nombre o limpia la
                                        búsqueda para ver todos los registros.
                                    </p>

                                    @if($search)
                                        <button
                                            type="button"
                                            wire:click="clearSearch"
                                            class="btn-empty-clear"
                                        >
                                            <i class="fas fa-times"></i>
                                            Limpiar búsqueda
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- PAGINACIÓN                                                --}}
    {{-- ========================================================= --}}
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

    {{-- ========================================================= --}}
    {{-- ESTILOS EXTERNOS                                          --}}
    {{-- ========================================================= --}}
    <!--
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    -->

    <link
        rel="stylesheet"
        href="{{ asset('css/ieessppformtable.css') }}"
    >

    {{-- ========================================================= --}}
    {{-- JAVASCRIPT                                                --}}
    {{-- ========================================================= --}}
    @push('js')
        <script>
            document.addEventListener(
                'livewire:initialized',
                function () {

                    function obtenerMensaje(evento, mensajeDefault) {
                        if (!evento) {
                            return mensajeDefault;
                        }

                        if (
                            Array.isArray(evento)
                            && evento.length > 0
                            && evento[0]
                            && evento[0].mensaje
                        ) {
                            return evento[0].mensaje;
                        }

                        if (evento.mensaje) {
                            return evento.mensaje;
                        }

                        return mensajeDefault;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | RECARGAR PÁGINA
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on('refresh-page', function () {
                        location.reload();
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | UBICACIÓN REGISTRADA
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on('alumno-created', function () {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: '¡Ubicación física registrada con éxito!',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                confirmButton: 'btn-ieesspp'
                            },
                            buttonsStyling: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | UBICACIÓN ACTUALIZADA
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on('alumno-updated', function () {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: '¡Ubicación física actualizada con éxito!',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                confirmButton: 'btn-ieesspp'
                            },
                            buttonsStyling: false
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | LIMPIAR ARCHIVO
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'limpiar-archivo-ubicaciones',
                        function () {
                            const input =
                                document.getElementById(
                                    'archivoUbicaciones'
                                );

                            if (input) {
                                input.value = '';
                            }
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTACIÓN CORRECTA
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'ubicaciones-importadas',
                        function (evento) {
                            const mensaje = obtenerMensaje(
                                evento,
                                'Las ubicaciones fueron importadas correctamente.'
                            );

                            Swal.fire({
                                title: '¡Importación terminada!',
                                text: mensaje,
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    confirmButton: 'btn-ieesspp'
                                },
                                buttonsStyling: false
                            });
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTACIÓN CON ADVERTENCIAS
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'ubicaciones-importacion-advertencia',
                        function (evento) {
                            const mensaje = obtenerMensaje(
                                evento,
                                'Algunas filas no pudieron importarse.'
                            );

                            Swal.fire({
                                title: 'Importación finalizada',
                                text: mensaje,
                                icon: 'warning',
                                confirmButtonText: 'Revisar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    confirmButton: 'btn-ieesspp'
                                },
                                buttonsStyling: false
                            });
                        }
                    );

                }
            );
        </script>
    @endpush

    {{-- ========================================================= --}}
    {{-- ESTILOS                                                   --}}
    {{-- ========================================================= --}}
    <style>
        /*
        |--------------------------------------------------------------------------
        | VARIABLES INSTITUCIONALES
        |--------------------------------------------------------------------------
        */

        .ubicaciones-page {
            --intevi-primary: #171C63;
            --intevi-primary-light: #26318f;
            --intevi-primary-dark: #0f143f;
            --intevi-background: #f8fafc;
            --intevi-border: #e2e8f0;
            --intevi-text: #0f172a;
            --intevi-muted: #64748b;
            color: #111827;
        }

        .ubicaciones-page button:disabled {
            cursor: wait !important;
            opacity: 0.65;
        }

        /*
        |--------------------------------------------------------------------------
        | BARRA DE CARGA
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
        | ENCABEZADO
        |--------------------------------------------------------------------------
        */

        .ubicaciones-header {
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

        /*
        |--------------------------------------------------------------------------
        | BOTÓN TUTORIAL
        |--------------------------------------------------------------------------
        */

        .btn-tour {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 18px;
            border: 1px solid rgba(23, 28, 99, 0.18);
            border-radius: 12px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            transition:
                transform 0.18s ease,
                border-color 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-tour:hover,
        .btn-tour:focus {
            border-color: #171C63;
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.18);
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN IMPORTAR
        |--------------------------------------------------------------------------
        */

        .btn-import-ubicaciones {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 18px;
            border: 1px solid rgba(23, 28, 99, 0.25);
            border-radius: 12px;
            background: #ffffff;
            color: #15803d;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(21, 128, 61, 0.10);
        }

        .btn-import-ubicaciones span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-import-ubicaciones:hover{
            background: #15803d;
            color: #ffffff;
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN AGREGAR
        |--------------------------------------------------------------------------
        */

        .btn-add-ubicacion {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 9px;
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
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .btn-add-ubicacion span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
        }

        .btn-add-ubicacion:hover,
        .btn-add-ubicacion:focus {
            color: #ffffff;
            filter: brightness(1.04);
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.28);
        }

        /*
        |--------------------------------------------------------------------------
        | MODAL GENERAL
        |--------------------------------------------------------------------------
        */

        .ieesspp-modal {
            overflow-x: hidden;
            overflow-y: auto;
            background: rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(5px);
        }

        .ieesspp-modal-dialog {
            position: relative;
            z-index: 1055;
        }

        .ieesspp-modal-content {
            overflow: hidden;
            border: none;
            border-radius: 18px;
            background: #ffffff;
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
            color: #ffffff;
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
            display: inline-flex;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
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

        .modal-close-btn:hover,
        .modal-close-btn:focus {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            transform: rotate(90deg);
        }

        .ieesspp-modal-body {
            background: #ffffff;
        }

        /*
        |--------------------------------------------------------------------------
        | MODAL IMPORTACIÓN
        |--------------------------------------------------------------------------
        */

        .ubicaciones-import-modal {
            overflow-x: hidden;
            overflow-y: auto;
            background: rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(5px);
        }

        .import-modal-dialog {
            position: relative;
            z-index: 1055;
        }

        .import-modal-content {
            overflow: hidden;
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.28);
        }

        .import-modal-header {
            background: linear-gradient(
                    135deg,
                    #14532d 0%,
                    #15803d 100%
            );
        }

        .import-modal-header > div > span {
            display: block;
            color: rgba(255, 255, 255, 0.76);
            font-size: 12px;
            font-weight: 600;
        }

        .import-modal-header h5 {
            margin: 3px 0 0;
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
        }

        .import-modal-close {
            display: inline-flex;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
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

        .import-modal-close:hover,
        .import-modal-close:focus {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            transform: rotate(90deg);
        }

        .import-modal-body {
            padding: 24px;
            background: #ffffff;
        }

        .import-information {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            padding: 16px;
            border: 1px solid rgba(23, 28, 99, 0.16);
            border-radius: 14px;
            background: rgba(23, 28, 99, 0.05);
        }

        .import-information-icon {
            display: inline-flex;
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(23, 28, 99, 0.10);
            color: #171C63;
            font-size: 21px;
        }

        .import-information strong {
            display: block;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
        }

        .import-information p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }

        .import-field {
            margin-bottom: 16px;
        }

        .import-label {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
        }

        .import-file-input {
            display: block;
            width: 100%;
            min-height: 50px;
            padding: 8px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            color: #334155;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                background 0.18s ease,
                box-shadow 0.18s ease;
        }

        .import-file-input:focus {
            border-color: rgba(23, 28, 99, 0.45);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09);
        }

        .import-file-input::file-selector-button {
            margin-right: 12px;
            padding: 9px 13px;
            border: none;
            border-radius: 9px;
            background: #171C63;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .import-help {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 12px;
        }

        .import-file-error {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 10px;
            padding: 11px 13px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 700;
        }

        .import-file-error i {
            margin-top: 2px;
        }

        .import-file-loading {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            padding: 11px 13px;
            border-radius: 10px;
            background: rgba(23, 28, 99, 0.07);
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        .import-selected-file {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 14px;
            padding: 14px;
            border: 1px solid rgba(23, 28, 99, 0.18);
            border-radius: 12px;
            background: rgba(23, 28, 99, 0.06);
            color: #171C63;
        }

        .import-selected-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: rgba(23, 28, 99, 0.10);
            color: #171C63;
            font-size: 20px;
        }

        .import-selected-info {
            min-width: 0;
            flex: 1;
        }

        .import-selected-info span {
            display: block;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .import-selected-info strong {
            display: block;
            overflow: hidden;
            margin-top: 2px;
            color: #171C63;
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .import-selected-check {
            display: inline-flex;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #171C63;
            color: #ffffff;
            font-size: 12px;
        }

        .import-example {
            overflow: hidden;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
        }

        .import-example-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 13px 15px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .import-example-title {
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .import-example-header p {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 11px;
        }

        .import-example-badge {
            padding: 5px 9px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.10);
            color: #171C63;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .import-example-table thead th {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .import-example-table tbody td {
            padding: 9px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .import-example-table tbody tr:last-child td {
            border-bottom: none;
        }

        .import-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .import-summary-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 12px;
        }

        .import-summary-item.primary {
            border: 1px solid rgba(23, 28, 99, 0.16);
            background: rgba(23, 28, 99, 0.05);
            color: #171C63;
        }

        .import-summary-item.warning {
            border: 1px solid #fde68a;
            background: #fffbeb;
            color: #92400e;
        }

        .import-summary-icon {
            display: inline-flex;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.78);
        }

        .import-summary-item span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .import-summary-item strong {
            display: block;
            margin-top: 3px;
            font-size: 21px;
            font-weight: 900;
        }

        .import-errors {
            margin-top: 18px;
            padding: 14px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
        }

        .import-errors-title {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .import-errors-title > i {
            margin-top: 3px;
        }

        .import-errors-title strong {
            display: block;
            font-size: 14px;
            font-weight: 900;
        }

        .import-errors-title span {
            display: block;
            margin-top: 3px;
            color: #b91c1c;
            font-size: 11px;
        }

        .import-errors-list {
            max-height: 250px;
            overflow-y: auto;
            margin-top: 12px;
            padding-right: 4px;
        }

        .import-error-row {
            margin-bottom: 9px;
            padding: 11px;
            border: 1px solid #fee2e2;
            border-radius: 9px;
            background: #ffffff;
            color: #7f1d1d;
            font-size: 12px;
        }

        .import-error-row:last-child {
            margin-bottom: 0;
        }

        .import-error-row-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .import-error-row-header span {
            overflow: hidden;
            color: #64748b;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .import-error-row ul {
            margin: 7px 0 0;
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
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 800;
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-cancel-import {
            gap: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .btn-cancel-import:hover,
        .btn-cancel-import:focus {
            border-color: rgba(23, 28, 99, 0.25);
            background: #f8fafc;
            color: #171C63;
        }

        .btn-confirm-import {
            border: none;
            background: linear-gradient(
                135deg,
                #171C63 0%,
                #26318f 100%
            );
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(23, 28, 99, 0.22);
        }

        .btn-confirm-import span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-confirm-import:hover,
        .btn-confirm-import:focus {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(23, 28, 99, 0.28);
        }

        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
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
            min-height: 50px;
            align-items: center;
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
            display: inline-flex;
            width: 48px;
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
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
            border: none;
            border-radius: 12px;
            background: transparent;
            color: #64748b;
            transition:
                background 0.18s ease,
                color 0.18s ease;
        }

        .btn-clear-search:hover,
        .btn-clear-search:focus {
            background: #fee2e2;
            color: #dc2626;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLA
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

        .ubicaciones-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .ubicaciones-table thead th {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
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
            min-width: 48px;
            align-items: center;
            justify-content: center;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 800;
        }

        .ubicacion-image-link {
            display: inline-block;
            overflow: hidden;
            border-radius: 14px;
            text-decoration: none;
        }

        .ubicacion-image {
            width: 86px;
            height: 62px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .ubicacion-image:hover {
            transform: scale(1.04);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.14);
        }

        .no-image-badge {
            display: inline-flex;
            min-height: 34px;
            align-items: center;
            justify-content: center;
            gap: 7px;
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
            display: inline-flex;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(
                135deg,
                rgba(23, 28, 99, 0.12),
                rgba(37, 99, 235, 0.12)
            );
            color: #171C63;
            font-size: 15px;
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

        /*
        |--------------------------------------------------------------------------
        | ACCIONES DE TABLA
        |--------------------------------------------------------------------------
        */

        .actions-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-action-edit,
        .btn-action-download,
        .btn-action-view {
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 11px;
            text-decoration: none;
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-action-edit {
            background: #fff7ed;
            color: #c2410c;
        }

        .btn-action-edit:hover,
        .btn-action-edit:focus {
            background: #f97316;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.24);
        }

        .btn-action-download {
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
        }

        .btn-action-download:hover,
        .btn-action-download:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        }

        .btn-action-view {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-action-view:hover,
        .btn-action-view:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        }

        /*
        |--------------------------------------------------------------------------
        | ESTADO VACÍO
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 34px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-icon {
            display: flex;
            width: 54px;
            height: 54px;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
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

        .btn-empty-clear {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 14px;
            padding: 9px 14px;
            border: 1px solid rgba(23, 28, 99, 0.20);
            border-radius: 10px;
            background: #ffffff;
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINACIÓN Y SWEETALERT
        |--------------------------------------------------------------------------
        */

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

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
        | NAVEGACIÓN MÓVIL
        |--------------------------------------------------------------------------
        */

        .mobile-page-nav {
            display: none;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE TABLET
        |--------------------------------------------------------------------------
        */

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
            .btn-import-ubicaciones,
            .btn-add-ubicacion {
                width: 100%;
            }

            .search-panel-header {
                align-items: flex-start;
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
        | RESPONSIVE MÓVIL
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {
            .ubicaciones-page {
                margin-top: 12px !important;
                padding-right: 12px !important;
                padding-left: 12px !important;
            }

            .mobile-page-nav {
                position: sticky;
                top: 8px;
                z-index: 1040;
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
                display: inline-flex;
                min-height: 42px;
                flex: 1;
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

            .ubicaciones-header {
                margin-top: 4px;
            }

            .ieesspp-modal-dialog,
            .import-modal-dialog {
                margin: 12px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE MÓVIL PEQUEÑO
        |--------------------------------------------------------------------------
        */

        @media (max-width: 576px) {
            .ubicaciones-header {
                padding: 18px;
                border-radius: 15px;
            }

            .ubicaciones-title {
                font-size: 23px;
            }

            .import-modal-body {
                padding: 18px;
            }

            .import-information {
                align-items: flex-start;
                padding: 14px;
            }

            .import-example-header {
                flex-direction: column;
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

            .import-selected-check {
                display: none;
            }

            .ubicaciones-table thead th,
            .ubicaciones-table tbody td {
                padding-right: 14px;
                padding-left: 14px;
            }
        }
    </style>

</div>