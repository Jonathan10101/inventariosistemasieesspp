<div class="container mt-4 marcas-page">

    {{-- ========================================================= --}}
    {{-- MARCADOR DEL TUTORIAL DEL MÓDULO                          --}}
    {{-- ========================================================= --}}
    <div
        data-tour-page="marcas"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>

    {{-- ========================================================= --}}
    {{-- BARRA SUPERIOR DE CARGA                                   --}}
    {{-- ========================================================= --}}
    <div
        wire:loading.delay
        wire:target="
            showModalNewMarca,
            showModalImportMarcas,
            closeImportModal,
            importarMarcas,
            archivoMarcas,
            editar,
            searchMarcas,
            clearSearch,
            cambiarAccion
        "
        class="ieesspp-loading-bar"
    >
        <div class="progress w-100 h-100 rounded-0">
            <div
                class="progress-bar progress-bar-striped progress-bar-animated w-100"
            ></div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- BARRA DE NAVEGACIÓN MÓVIL                                 --}}
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
        class="marcas-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Módulo de marcas"
        data-tour-description="Desde este módulo puedes consultar, registrar, importar y actualizar las marcas utilizadas en el inventario institucional."
        data-tour-side="bottom"
    >
        <div>
            <div class="marcas-kicker">
                <i class="fas fa-layer-group"></i>
                Catálogo institucional
            </div>

            <h2 class="marcas-title">
                Gestión de marcas
            </h2>

            <p class="marcas-subtitle">
                Administra, consulta, importa y actualiza las marcas
                registradas en el sistema.
            </p>
        </div>

        <div class="header-actions">

            {{-- BOTÓN DEL TUTORIAL --}}
            <button
                type="button"
                class="btn btn-tour-module"
                data-tour-start
                title="Ver tutorial de este módulo"
            >
                <i class="fas fa-circle-question"></i>
                <span>Ver tutorial</span>
            </button>

            @hasanyrole('Administrador|Delegacion|Subdirector')

                {{-- BOTÓN IMPORTAR EXCEL --}}
                <button
                    type="button"
                    wire:click="showModalImportMarcas"
                    wire:loading.attr="disabled"
                    wire:target="showModalImportMarcas"
                    title="Importar marcas desde Excel"
                    class="btn btn-outline-success"
                >
                    <span
                        wire:loading.remove
                        wire:target="showModalImportMarcas"
                    >
                        <i class="fas fa-file-excel"></i>
                        <span>Importar Excel</span>
                    </span>

                    <span
                        wire:loading
                        wire:target="showModalImportMarcas"
                    >
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Abriendo...</span>
                    </span>
                </button>

                {{-- BOTÓN AGREGAR MARCA --}}
                <button
                    type="button"
                    wire:click="showModalNewMarca"
                    wire:loading.attr="disabled"
                    wire:target="showModalNewMarca"
                    class="btn btn-add-marca"
                    data-tour-step
                    data-tour-order="2"
                    data-tour-title="Agregar una marca"
                    data-tour-description="Presiona este botón para registrar una nueva marca en el catálogo institucional."
                    data-tour-side="left"
                >
                    <span
                        wire:loading.remove
                        wire:target="showModalNewMarca"
                    >
                        <i class="fas fa-plus"></i>
                        <span>Agregar marca</span>
                    </span>

                    <span
                        wire:loading
                        wire:target="showModalNewMarca"
                    >
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Abriendo...</span>
                    </span>
                </button>

            @endhasanyrole
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MODAL PARA REGISTRAR O EDITAR MARCA                       --}}
    {{-- ========================================================= --}}
    @if($showModal)
        <div
            class="modal fade show marca-modal-wrapper"
            style="display: block;"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
            aria-labelledby="marcaModalTitle"
        >
            <div
                class="modal-backdrop-custom"
                wire:click="closeModal"
            ></div>

            <div
                class="modal-dialog modal-lg modal-dialog-centered ieesspp-modal-dialog"
                role="document"
            >
                <div class="modal-content ieesspp-modal-content">

                    {{-- ENCABEZADO --}}
                    <div class="modal-header ieesspp-modal-header">
                        <div>
                            <span class="modal-label">
                                {{ $accionPrincipal === 'editar'
                                    ? 'Edición de registro'
                                    : 'Nuevo registro' }}
                            </span>

                            <h5
                                class="modal-title"
                                id="marcaModalTitle"
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

                    {{-- CONTENIDO --}}
                    <div class="ieesspp-modal-body">
                        @switch($accionPrincipal)

                            {{-- EDITAR MARCA --}}
                            @case('editar')
                                @livewire(
                                    'update-marca',
                                    [
                                        'data' => $data_external_component
                                    ],
                                    key(
                                        'update-marca-'
                                        . $data_external_component
                                    )
                                )
                            @break

                            {{-- CREAR NUEVA MARCA --}}
                            @default
                                @livewire(
                                    'create-new-marca',
                                    [],
                                    key('create-new-marca')
                                )
                            @break

                        @endswitch
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- MODAL PARA IMPORTAR MARCAS DESDE EXCEL                    --}}
    {{-- ========================================================= --}}
    @if($showImportModal)
        <div
            class="modal fade show marca-modal-wrapper"
            style="display: block;"
            tabindex="-1"
            role="dialog"
            aria-modal="true"
            aria-labelledby="importarMarcasModalTitle"
        >
            <div
                class="modal-backdrop-custom"
                wire:click="closeImportModal"
            ></div>

            <div
                class="modal-dialog modal-lg modal-dialog-centered ieesspp-modal-dialog"
                role="document"
            >
                <div class="modal-content ieesspp-modal-content">

                    {{-- ENCABEZADO --}}
                    <div class="modal-header ieesspp-modal-header import-modal-header">
                        <div>
                            <span class="modal-label">
                                Carga masiva del catálogo
                            </span>

                            <h5
                                class="modal-title"
                                id="importarMarcasModalTitle"
                            >
                                Importar marcas desde Excel
                            </h5>
                        </div>

                        <button
                            type="button"
                            class="modal-close-btn"
                            wire:click="closeImportModal"
                            wire:loading.attr="disabled"
                            wire:target="importarMarcas"
                            aria-label="Cerrar"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- CONTENIDO --}}
                    <div class="import-marcas-body">

                        {{-- INFORMACIÓN DEL FORMATO --}}
                        <div class="import-instructions">
                            <div class="import-instructions-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>

                            <div>
                                <h6>
                                    Formato requerido
                                </h6>

                                <p>
                                    La primera fila del archivo debe contener
                                    una columna llamada exactamente
                                    <strong>nombre</strong>.
                                </p>
                            </div>
                        </div>

                        <form wire:submit.prevent="importarMarcas">

                            {{-- SELECTOR DE ARCHIVO --}}
                            <div class="import-field">
                                <label
                                    for="archivoMarcas"
                                    class="import-label"
                                >
                                    Seleccionar archivo
                                </label>

                                <div class="import-file-wrapper">
                                    <input
                                        type="file"
                                        id="archivoMarcas"
                                        wire:model="archivoMarcas"
                                        accept=".xlsx,.xls,.csv"
                                    >
                                </div>

                                <p class="import-help">
                                    Formatos permitidos: XLSX, XLS y CSV.
                                    Tamaño máximo permitido: 10 MB.
                                </p>

                                @error('archivoMarcas')
                                    <div class="import-validation-error">
                                        <i class="fas fa-circle-exclamation"></i>

                                        <span>
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                            </div>

                            {{-- PROGRESO AL SUBIR ARCHIVO --}}
                            <div
                                wire:loading
                                wire:target="archivoMarcas"
                                class="import-loading"
                            >
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Cargando archivo...</span>
                            </div>

                            {{-- ARCHIVO SELECCIONADO --}}
                            @if($archivoMarcas)
                                <div class="selected-file">
                                    <div class="selected-file-icon">
                                        <i class="fas fa-file-excel"></i>
                                    </div>

                                    <div class="selected-file-info">
                                        <span>
                                            Archivo seleccionado
                                        </span>

                                        <strong>
                                            {{ $archivoMarcas->getClientOriginalName() }}
                                        </strong>
                                    </div>

                                    <div class="selected-file-check">
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

                                    <span class="excel-badge">
                                        Excel
                                    </span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table import-example-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>nombre</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>DELL</td>
                                            </tr>

                                            <tr>
                                                <td>HP</td>
                                            </tr>

                                            <tr>
                                                <td>LENOVO</td>
                                            </tr>

                                            <tr>
                                                <td>APPLE</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- RESUMEN DE IMPORTACIÓN --}}
                            @if(
                                $marcasImportadas > 0
                                || $marcasDuplicadas > 0
                            )
                                <div class="import-summary">
                                    <div class="import-summary-item success">
                                        <div class="import-summary-icon">
                                            <i class="fas fa-check"></i>
                                        </div>

                                        <div>
                                            <span>
                                                Nuevas marcas
                                            </span>

                                            <strong>
                                                {{ $marcasImportadas }}
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
                                                {{ $marcasDuplicadas }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- FILAS CON ERRORES --}}
                            @if(count($erroresImportacion) > 0)
                                <div class="import-row-errors">
                                    <div class="import-row-errors-title">
                                        <i class="fas fa-triangle-exclamation"></i>

                                        <div>
                                            <strong>
                                                Filas que no se importaron
                                            </strong>

                                            <span>
                                                Revisa los siguientes registros
                                                y vuelve a cargar el archivo.
                                            </span>
                                        </div>
                                    </div>

                                    <div class="import-errors-list">
                                        @foreach(
                                            $erroresImportacion as $error
                                        )
                                            <div class="import-row-error">
                                                <div class="import-row-error-header">
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

                            {{-- ACCIONES DEL MODAL --}}
                            <div class="import-modal-actions">
                                <!--
                                <button
                                    type="button"
                                    wire:click="closeImportModal"
                                    wire:loading.attr="disabled"
                                    wire:target="importarMarcas"
                                    class="btn-cancel-import"
                                >
                                    <i class="fas fa-times"></i>
                                    <span>Cancelar</span>
                                </button>
                                -->

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="
                                        archivoMarcas,
                                        importarMarcas
                                    "
                                    class="btn-confirm-import"
                                >
                                    <span
                                        wire:loading.remove
                                        wire:target="importarMarcas"
                                    >
                                        <i class="fas fa-file-import"></i>
                                        Importar marcas
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="importarMarcas"
                                    >
                                        <i class="fas fa-spinner fa-spin"></i>
                                        Importando marcas...
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
        data-tour-title="Buscar marcas"
        data-tour-description="Escribe el nombre de una marca. La tabla se actualizará automáticamente mientras escribes."
        data-tour-side="bottom"
    >
        <div class="search-panel-header">
            <div>
                <label
                    for="searchid"
                    class="search-title"
                >
                    Buscar marca
                </label>

                <p class="search-description">
                    Escribe el nombre de la marca. Los resultados
                    se actualizan automáticamente.
                </p>
            </div>

            <div
                class="search-status"
                wire:loading
                wire:target="searchMarcas"
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
                placeholder="Ejemplo: DELL, HP, LENOVO..."
                wire:model="search"
                wire:input.debounce.400ms="searchMarcas"
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
        data-tour-title="Marcas registradas"
        data-tour-description="Aquí puedes consultar las marcas disponibles. Los usuarios autorizados también pueden editar cada registro."
        data-tour-side="top"
    >
        <div class="table-card-header">
            <div>
                <h5 class="table-title">
                    Marcas registradas
                </h5>

                <p class="table-subtitle">
                    Listado general de marcas disponibles.
                </p>
            </div>

            <div class="table-counter">
                {{ $marcas->total() }}
                {{ $marcas->total() === 1
                    ? 'registro'
                    : 'registros' }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table marcas-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">
                            ID
                        </th>

                        <th scope="col">
                            Marca
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
                    @forelse($marcas as $marca)
                        <tr wire:key="marca-{{ $marca->id }}">
                            <td>
                                <span class="id-badge">
                                    #{{ $marca->id }}
                                </span>
                            </td>

                            <td>
                                <div class="marca-name">
                                    {{ $marca->nombre }}
                                </div>
                            </td>

                            @hasanyrole('Administrador')
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="
                                            cambiarAccion(
                                                'editar',
                                                {{ $marca->id }}
                                            )
                                        "
                                        wire:loading.attr="disabled"
                                        wire:target="
                                            cambiarAccion(
                                                'editar',
                                                {{ $marca->id }}
                                            )
                                        "
                                        title="Editar marca"
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
                                        <i class="fas fa-search"></i>
                                    </div>

                                    <h6>
                                        No se encontraron marcas
                                    </h6>

                                    <p>
                                        Intenta con otro nombre o limpia
                                        la búsqueda para ver todos los
                                        registros.
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
        data-tour-order="5"
        data-tour-title="Cambiar de página"
        data-tour-description="Utiliza estos controles para consultar los demás registros del catálogo de marcas."
        data-tour-side="top"
    >
        {{ $marcas->links() }}
    </div>

    {{-- ========================================================= --}}
    {{-- ESTILOS EXTERNOS                                          --}}
    {{-- ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/ieessppformtable.css') }}"
    >

    {{-- ========================================================= --}}
    {{-- JAVASCRIPT                                                --}}
    {{-- ========================================================= --}}
    @push('js')
        @livewireScripts

        <script>
            document.addEventListener(
                'livewire:initialized',
                function () {

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
                    | Marca registrada
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on('alumno-created', function () {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: '¡Marca registrada con éxito!',
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
                    | Marca actualizada
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on('alumno-updated', function () {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: '¡Marca actualizada con éxito!',
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
                    | Limpiar selector de archivo
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'limpiar-archivo-marcas',
                        function () {
                            const input = document.getElementById(
                                'archivoMarcas'
                            );

                            if (input) {
                                input.value = '';
                            }
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Importación correcta
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'marcas-importadas',
                        function (event) {
                            const mensaje =
                                event && event.mensaje
                                    ? event.mensaje
                                    : 'Las marcas fueron importadas correctamente.';

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
                    | Importación con advertencias
                    |--------------------------------------------------------------------------
                    */
                    Livewire.on(
                        'marcas-importacion-advertencia',
                        function (event) {
                            const mensaje =
                                event && event.mensaje
                                    ? event.mensaje
                                    : 'La importación terminó con algunas filas rechazadas.';

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
        | BASE
        |--------------------------------------------------------------------------
        */

        .marcas-page {
            color: #111827;
        }

        button:disabled {
            cursor: wait !important;
            opacity: 0.68;
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
            width: 100%;
            z-index: 99999;
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

        .marcas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
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
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .marcas-kicker {
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

        .marcas-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .marcas-subtitle {
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

        .btn-tour-module {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 0 16px;
            border: 1px solid rgba(23, 28, 99, 0.22);
            border-radius: 12px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-tour-module:hover,
        .btn-tour-module:focus {
            background: #171C63;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.20);
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN IMPORTAR EXCEL
        |--------------------------------------------------------------------------
        */

        .btn-import-marcas {
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
            transition:
                transform 0.18s ease,
                background 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-import-marcas > span {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .btn-import-marcas:hover,
        .btn-import-marcas:focus {
            background: #15803d;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(21, 128, 61, 0.22);
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN AGREGAR
        |--------------------------------------------------------------------------
        */

        .btn-add-marca {
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
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .btn-add-marca > span {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .btn-add-marca:hover {
            color: #ffffff;
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.28);
        }

        /*
        |--------------------------------------------------------------------------
        | MODALES
        |--------------------------------------------------------------------------
        */

        .marca-modal-wrapper {
            position: fixed;
            inset: 0;
            z-index: 1050;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(5px);
        }

        .ieesspp-modal-dialog {
            position: relative;
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

        .import-modal-header {
            background:
                radial-gradient(
                    circle at top left,
                    rgba(255, 255, 255, 0.18),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #14532d 0%,
                    #15803d 100%
                );
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
        | MODAL DE IMPORTACIÓN
        |--------------------------------------------------------------------------
        */

        .import-marcas-body {
            padding: 24px;
            background: #ffffff;
        }

        .import-instructions {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            padding: 16px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: #f8fafc;
        }

        .import-instructions-icon {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #dcfce7;
            color: #15803d;
            font-size: 21px;
        }

        .import-instructions h6 {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
        }

        .import-instructions p {
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

        .import-file-wrapper {
            padding: 5px;
            border: 1px solid #cbd5e1;
            border-radius: 13px;
            background: #f8fafc;
            transition:
                border-color 0.18s ease,
                background 0.18s ease,
                box-shadow 0.18s ease;
        }

        .import-file-wrapper:focus-within {
            border-color: rgba(23, 28, 99, 0.45);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09);
        }

        .import-file-input {
            min-height: 46px;
            padding: 10px 12px;
            border: none !important;
            border-radius: 10px;
            background: transparent;
            box-shadow: none !important;
        }

        .import-file-input::file-selector-button {
            margin-right: 12px;
            padding: 8px 12px;
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

        .import-validation-error {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 9px;
            padding: 10px 12px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 700;
        }

        .import-validation-error i {
            margin-top: 2px;
        }

        .import-loading {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0;
            padding: 11px 13px;
            border-radius: 10px;
            background: rgba(23, 28, 99, 0.07);
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        .selected-file {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 15px 0;
            padding: 14px;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            background: #f0fdf4;
            color: #166534;
        }

        .selected-file-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #dcfce7;
            color: #15803d;
            font-size: 20px;
        }

        .selected-file-info {
            min-width: 0;
            flex: 1;
        }

        .selected-file-info span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .selected-file-info strong {
            display: block;
            overflow: hidden;
            margin-top: 2px;
            color: #14532d;
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .selected-file-check {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #16a34a;
            color: #ffffff;
            font-size: 12px;
        }

        .import-example {
            overflow: hidden;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
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

        .excel-badge {
            padding: 5px 9px;
            border-radius: 999px;
            background: #dcfce7;
            color: #15803d;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .import-example-table th {
            padding: 10px 14px;
            background: #f1f5f9;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .import-example-table td {
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
            padding: 13px;
            border-radius: 12px;
        }

        .import-summary-item.success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .import-summary-item.warning {
            border: 1px solid #fde68a;
            background: #fffbeb;
            color: #92400e;
        }

        .import-summary-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.75);
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
            font-weight: 900;
        }

        .import-row-errors {
            margin-top: 18px;
            padding: 15px;
            border: 1px solid #fecaca;
            border-radius: 12px;
            background: #fef2f2;
        }

        .import-row-errors-title {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #991b1b;
        }

        .import-row-errors-title i {
            margin-top: 3px;
        }

        .import-row-errors-title strong {
            display: block;
            font-size: 14px;
            font-weight: 900;
        }

        .import-row-errors-title span {
            display: block;
            margin-top: 3px;
            color: #b91c1c;
            font-size: 11px;
        }

        .import-errors-list {
            max-height: 230px;
            overflow-y: auto;
            margin-top: 12px;
            padding-right: 4px;
        }

        .import-row-error {
            margin-bottom: 9px;
            padding: 11px;
            border: 1px solid #fee2e2;
            border-radius: 9px;
            background: #ffffff;
            color: #7f1d1d;
            font-size: 12px;
        }

        .import-row-error:last-child {
            margin-bottom: 0;
        }

        .import-row-error-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .import-row-error-header span {
            overflow: hidden;
            color: #64748b;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .import-row-error ul {
            margin: 7px 0 0;
            padding-left: 19px;
        }

        .import-modal-actions {
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
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .btn-cancel-import {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .btn-cancel-import:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .btn-confirm-import {
            border: none;
            background: linear-gradient(
                135deg,
                #15803d 0%,
                #16a34a 100%
            );
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(21, 128, 61, 0.22);
        }

        .btn-confirm-import span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-confirm-import:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(21, 128, 61, 0.28);
        }

        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
        |--------------------------------------------------------------------------
        */

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
            transition:
                background 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease;
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
        | TABLA
        |--------------------------------------------------------------------------
        */

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

        .marcas-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .marcas-table thead th {
            padding: 14px 20px;
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .marcas-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #0f172a;
            font-size: 14px;
        }

        .marcas-table tbody tr {
            transition:
                background 0.16s ease,
                transform 0.16s ease;
        }

        .marcas-table tbody tr:hover {
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

        .marca-name {
            color: #111827;
            font-weight: 800;
            letter-spacing: 0.01em;
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
        | ESTADO VACÍO
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
        | PAGINACIÓN
        |--------------------------------------------------------------------------
        */

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        /*
        |--------------------------------------------------------------------------
        | SWEETALERT
        |--------------------------------------------------------------------------
        */

        .btn-ieesspp {
            background: #171C63 !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            padding: 9px 20px !important;
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
            .marcas-header {
                align-items: stretch;
                flex-direction: column;
                padding: 20px;
            }

            .header-actions,
            .btn-tour-module,
            .btn-import-marcas,
            .btn-add-marca,
            .btn-outline-success{
                width: 100%;
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
        | RESPONSIVE MÓVIL
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {
            .marcas-page {
                margin-top: 12px !important;
                padding-left: 12px !important;
                padding-right: 12px !important;
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
                background: linear-gradient(
                    135deg,
                    #171C63 0%,
                    #26318f 100%
                );
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

            .marcas-header {
                margin-top: 4px;
            }

            .ieesspp-modal-dialog {
                margin: 12px;
            }

            .import-summary {
                grid-template-columns: 1fr;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE MÓVIL PEQUEÑO
        |--------------------------------------------------------------------------
        */

        @media (max-width: 576px) {
            .marcas-header {
                padding: 18px;
                border-radius: 15px;
            }

            .marcas-title {
                font-size: 23px;
            }

            .import-marcas-body {
                padding: 18px;
            }

            .import-instructions {
                align-items: flex-start;
                padding: 14px;
            }

            .import-example-header {
                flex-direction: column;
            }

            .import-modal-actions {
                flex-direction: column-reverse;
            }

            .btn-cancel-import,
            .btn-confirm-import {
                width: 100%;
                justify-content: center;
            }

            .selected-file-check {
                display: none;
            }

            .marcas-table thead th,
            .marcas-table tbody td {
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>

</div>