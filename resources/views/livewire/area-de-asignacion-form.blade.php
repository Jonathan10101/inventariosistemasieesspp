<div class="container mt-4 areas-page">

    {{-- ========================================================= --}}
    {{-- MARCADOR DEL TUTORIAL                                     --}}
    {{-- ========================================================= --}}
    <div
        data-tour-page="areas-de-asignacion"
        data-tour-version="1"
        data-tour-autostart="false"
        hidden
    ></div>

    {{-- ========================================================= --}}
    {{-- BARRA DE CARGA                                            --}}
    {{-- ========================================================= --}}
    <div
        wire:loading.delay
        wire:target="showModalNewAreaDeAsignacion,showModalImportAreas,archivoAreas,importarAreas,cambiarAccion,searchAreasDeAsignacion,clearSearch"
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
    {{-- SWEETALERT                                                --}}
    {{-- ========================================================= --}}
    <link
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>

    {{-- ========================================================= --}}
    {{-- ENCABEZADO                                                --}}
    {{-- ========================================================= --}}
    <div
        class="areas-header mb-4"
        data-tour-step
        data-tour-order="1"
        data-tour-title="Áreas de asignación"
        data-tour-description="En este módulo puedes consultar, importar y administrar las áreas institucionales utilizadas para asignar los bienes."
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
                Administra las áreas institucionales utilizadas
                para clasificar la asignación de bienes.
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
                    wire:click="showModalImportAreas"
                    wire:loading.attr="disabled"
                    wire:target="showModalImportAreas"
                    class="btn btn-import-areas"
                >
                    <span
                        wire:loading.remove
                        wire:target="showModalImportAreas"
                    >
                        <i class="fas fa-file-excel"></i>
                        Importar Excel
                    </span>

                    <span
                        wire:loading
                        wire:target="showModalImportAreas"
                    >
                        <i class="fas fa-spinner fa-spin"></i>
                        Abriendo...
                    </span>
                </button>

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

    {{-- ========================================================= --}}
    {{-- MODAL REGISTRAR O EDITAR                                  --}}
    {{-- ========================================================= --}}
    @if($showModal)
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

                    <div class="modal-header ieesspp-modal-header">
                        <div>
                            <span class="modal-label">
                                {{ $accionPrincipal === 'editar'
                                    ? 'Edición de registro'
                                    : 'Nuevo registro' }}
                            </span>

                            <h5 class="modal-title">
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

                            @case('editar')
                                @livewire(
                                    'update-area-de-asignacion',
                                    [
                                        'data' => $data_external_component
                                    ],
                                    key(
                                        'update-area-'
                                        . $data_external_component
                                    )
                                )
                            @break

                            @default
                                @livewire(
                                    'create-new-area-de-asignacion',
                                    [],
                                    key('create-new-area-de-asignacion')
                                )
                            @break

                        @endswitch
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- MODAL IMPORTAR EXCEL                                      --}}
    {{-- ========================================================= --}}
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

                    <div class="modal-header ieesspp-modal-header import-header">
                        <div>
                            <span class="modal-label">
                                Carga masiva del catálogo
                            </span>

                            <h5 class="modal-title">
                                Importar áreas desde Excel
                            </h5>
                        </div>

                        <button
                            type="button"
                            class="modal-close-btn"
                            wire:click="closeImportModal"
                            wire:loading.attr="disabled"
                            wire:target="importarAreas"
                            aria-label="Cerrar"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="import-body">

                        <div class="import-info">
                            <div class="import-info-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>

                            <div>
                                <strong>Formato requerido</strong>

                                <p>
                                    La primera celda del archivo debe
                                    llamarse exactamente
                                    <b>nombre</b>.
                                </p>
                            </div>
                        </div>

                        <form wire:submit.prevent="importarAreas">

                            <label
                                for="archivoAreas"
                                class="import-label"
                            >
                                Seleccionar archivo
                            </label>

                            <input
                                type="file"
                                id="archivoAreas"
                                wire:model="archivoAreas"
                                accept=".xlsx,.xls,.csv"
                                class="form-control import-input"
                            >

                            <p class="import-help">
                                Formatos permitidos: XLSX, XLS y CSV.
                                Tamaño máximo: 10 MB.
                            </p>

                            @error('archivoAreas')
                                <div class="import-error">
                                    <i class="fas fa-circle-exclamation"></i>

                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                            <div
                                wire:loading
                                wire:target="archivoAreas"
                                class="import-loading"
                            >
                                <i class="fas fa-spinner fa-spin"></i>
                                Cargando archivo...
                            </div>

                            @if($archivoAreas)
                                <div class="selected-file">
                                    <i class="fas fa-file-excel"></i>

                                    <div>
                                        <span>
                                            Archivo seleccionado
                                        </span>

                                        <strong>
                                            {{ $archivoAreas->getClientOriginalName() }}
                                        </strong>
                                    </div>
                                </div>
                            @endif

                            <div class="import-example">
                                <div class="import-example-header">
                                    Ejemplo del archivo
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>nombre</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>DIRECCIÓN GENERAL</td>
                                            </tr>

                                            <tr>
                                                <td>RECURSOS HUMANOS</td>
                                            </tr>

                                            <tr>
                                                <td>RECURSOS MATERIALES</td>
                                            </tr>

                                            <tr>
                                                <td>SISTEMAS</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if(
                                $areasImportadas > 0
                                || $areasDuplicadas > 0
                            )
                                <div class="import-summary">
                                    <div class="summary-item success">
                                        <span>Nuevas áreas</span>

                                        <strong>
                                            {{ $areasImportadas }}
                                        </strong>
                                    </div>

                                    <div class="summary-item warning">
                                        <span>Duplicadas</span>

                                        <strong>
                                            {{ $areasDuplicadas }}
                                        </strong>
                                    </div>
                                </div>
                            @endif

                            @if(count($erroresImportacion) > 0)
                                <div class="import-errors">
                                    <div class="import-errors-title">
                                        <i class="fas fa-triangle-exclamation"></i>
                                        Filas que no se importaron
                                    </div>

                                    @foreach(
                                        $erroresImportacion as $error
                                    )
                                        <div class="import-error-row">
                                            <strong>
                                                Fila {{ $error['fila'] }}
                                            </strong>

                                            @if(!empty($error['valor']))
                                                <div>
                                                    Valor:
                                                    {{ $error['valor'] }}
                                                </div>
                                            @endif

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
                                    wire:target="importarAreas"
                                    class="btn-cancel-import"
                                >
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="archivoAreas,importarAreas"
                                    class="btn-confirm-import"
                                >
                                    <span
                                        wire:loading.remove
                                        wire:target="importarAreas"
                                    >
                                        <i class="fas fa-file-import"></i>
                                        Importar áreas
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="importarAreas"
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
        data-tour-title="Buscar áreas"
        data-tour-description="Escribe el nombre del área para filtrar los resultados automáticamente."
        data-tour-side="bottom"
        data-tour-align="center"
    >
        <div class="search-panel-header">
            <div>
                <label
                    for="searchid"
                    class="search-title"
                >
                    Buscar área de asignación
                </label>

                <p class="search-description">
                    Escribe el nombre del área. Los resultados
                    se actualizan automáticamente.
                </p>
            </div>

            <div
                class="search-status"
                wire:loading
                wire:target="searchAreasDeAsignacion"
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

    {{-- ========================================================= --}}
    {{-- TABLA                                                     --}}
    {{-- ========================================================= --}}
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
                    Listado general de áreas de asignación
                    disponibles en el sistema.
                </p>
            </div>

            <div class="table-counter">
                {{ $areasdeasignacion->total() }}

                {{ $areasdeasignacion->total() === 1
                    ? 'registro'
                    : 'registros' }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table areas-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>

                        <th scope="col">
                            Área de asignación
                        </th>

                        @can('areadeasignacion.edit')
                            <th
                                scope="col"
                                class="text-center"
                            >
                                Acciones
                            </th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @forelse(
                        $areasdeasignacion
                        as $areadeasignacion
                    )
                        <tr
                            wire:key="area-{{ $areadeasignacion->id }}"
                        >
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

                            @can('areadeasignacion.edit')
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn-action-edit"
                                        wire:click="cambiarAccion('editar', {{ $areadeasignacion->id }})"
                                        title="Editar área"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-sitemap"></i>
                                    </div>

                                    <h6>
                                        No se encontraron áreas
                                    </h6>

                                    <p>
                                        Intenta con otro nombre o
                                        limpia la búsqueda.
                                    </p>

                                    @if($search)
                                        <button
                                            type="button"
                                            wire:click="clearSearch"
                                            class="btn-empty-clear"
                                        >
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
        data-tour-title="Navegar entre páginas"
        data-tour-description="Utiliza estos controles para consultar las demás áreas."
        data-tour-side="top"
        data-tour-align="end"
    >
        {{ $areasdeasignacion->links() }}
    </div>

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

                    Livewire.on(
                        'refresh-page',
                        function () {
                            location.reload();
                        }
                    );

                    Livewire.on(
                        'alumno-created',
                        function () {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: '¡Área de asignación registrada con éxito!',
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                customClass: {
                                    confirmButton: 'btn-ieesspp'
                                },
                                buttonsStyling: false
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    );

                    Livewire.on(
                        'alumno-updated',
                        function () {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: '¡Área de asignación actualizada con éxito!',
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                customClass: {
                                    confirmButton: 'btn-ieesspp'
                                },
                                buttonsStyling: false
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    );

                    Livewire.on(
                        'limpiar-archivo-areas',
                        function () {
                            const input =
                                document.getElementById(
                                    'archivoAreas'
                                );

                            if (input) {
                                input.value = '';
                            }
                        }
                    );

                    Livewire.on(
                        'areas-importadas',
                        function (event) {
                            Swal.fire({
                                title: '¡Importación terminada!',
                                text:
                                    event.mensaje
                                    ?? 'Las áreas fueron importadas correctamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                customClass: {
                                    confirmButton: 'btn-ieesspp'
                                },
                                buttonsStyling: false
                            });
                        }
                    );

                    Livewire.on(
                        'areas-importacion-advertencia',
                        function (event) {
                            Swal.fire({
                                title: 'Importación finalizada',
                                text:
                                    event.mensaje
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

                }
            );
        </script>
    @endpush

    {{-- ========================================================= --}}
    {{-- ESTILOS                                                   --}}
    {{-- ========================================================= --}}
    <style>
        .areas-page {
            color: #111827;
        }

        button:disabled {
            cursor: wait !important;
            opacity: .65;
        }

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

        .areas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px;
            border: 1px solid rgba(226, 232, 240, .9);
            border-radius: 18px;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(23, 28, 99, .12),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8fafc 100%
                );
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        .areas-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(23, 28, 99, .08);
            color: #171C63;
            font-size: 12px;
            font-weight: 700;
        }

        .areas-title {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 800;
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

        .btn-tour,
        .btn-import-areas,
        .btn-add-area {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 0 18px;
            border-radius: 12px;
            font-weight: 800;
        }

        .btn-tour {
            border: 1px solid rgba(23, 28, 99, .20);
            background: #ffffff;
            color: #171C63;
        }

        .btn-import-areas {
            border: 1px solid #15803d;
            background: #ffffff;
            color: #15803d;
        }

        .btn-import-areas span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-import-areas:hover {
            background: #15803d;
            color: #ffffff;
        }

        .btn-add-area {
            border: none;
            background: linear-gradient(
                135deg,
                #171C63,
                #26318f
            );
            color: #ffffff;
            box-shadow: 0 14px 28px rgba(23, 28, 99, .22);
        }

        .btn-add-area:hover {
            color: #ffffff;
        }

        .ieesspp-modal {
            background: rgba(15, 23, 42, .62);
            backdrop-filter: blur(5px);
        }

        .ieesspp-modal-dialog {
            z-index: 1055;
        }

        .ieesspp-modal-content {
            overflow: hidden;
            border: none;
            border-radius: 18px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, .28);
        }

        .ieesspp-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            background: linear-gradient(
                135deg,
                #171C63,
                #0f143f
            );
            color: #ffffff;
        }

        .import-header {
            background: linear-gradient(
                135deg,
                #14532d,
                #15803d
            );
        }

        .modal-label {
            display: block;
            color: rgba(255, 255, 255, .76);
            font-size: 12px;
        }

        .ieesspp-modal-header .modal-title {
            margin: 2px 0 0;
            font-size: 18px;
            font-weight: 800;
        }

        .modal-close-btn {
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, .12);
            color: #ffffff;
        }

        .ieesspp-modal-body {
            background: #ffffff;
        }

        .import-body {
            padding: 24px;
            background: #ffffff;
        }

        .import-info {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #bbf7d0;
            border-radius: 13px;
            background: #f0fdf4;
        }

        .import-info-icon {
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

        .import-info p {
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

        .import-input {
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

        .import-error {
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

        .import-loading {
            margin-top: 12px;
            color: #171C63;
            font-size: 13px;
            font-weight: 800;
        }

        .selected-file {
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

        .selected-file > i {
            font-size: 22px;
        }

        .selected-file span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .selected-file strong {
            display: block;
            margin-top: 2px;
        }

        .import-example {
            overflow: hidden;
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        .import-example-header {
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

        .summary-item {
            padding: 13px;
            border-radius: 11px;
        }

        .summary-item.success {
            background: #f0fdf4;
            color: #166534;
        }

        .summary-item.warning {
            background: #fffbeb;
            color: #92400e;
        }

        .summary-item span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .summary-item strong {
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

        .import-errors-title {
            font-size: 14px;
            font-weight: 800;
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

        .search-panel {
            padding: 18px;
            border: 1px solid rgba(226, 232, 240, .9);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 16px 42px rgba(15, 23, 42, .055);
        }

        .search-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .search-title {
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
            background: rgba(23, 28, 99, .08);
            color: #171C63;
            font-size: 12px;
            font-weight: 700;
        }

        .search-box {
            display: flex;
            min-height: 50px;
            align-items: center;
            overflow: hidden;
            border: 1px solid transparent;
            border-radius: 14px;
            background: #f8fafc;
        }

        .search-box:focus-within {
            border-color: rgba(23, 28, 99, .35);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(23, 28, 99, .09);
        }

        .search-icon {
            display: inline-flex;
            width: 48px;
            align-items: center;
            justify-content: center;
            color: #171C63;
        }

        .search-input {
            height: 50px;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            font-weight: 600;
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
        }

        .table-card {
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, .9);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f7;
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
        }

        .areas-table thead th {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .areas-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .area-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .area-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(23, 28, 99, .10);
            color: #171C63;
        }

        .area-name {
            color: #111827;
            font-weight: 800;
        }

        .area-meta {
            margin-top: 2px;
            color: #64748b;
            font-size: 12px;
        }

        .id-badge {
            display: inline-flex;
            min-width: 48px;
            align-items: center;
            justify-content: center;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(23, 28, 99, .08);
            color: #171C63;
            font-size: 12px;
            font-weight: 800;
        }

        .btn-action-edit {
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 11px;
            background: #fff7ed;
            color: #c2410c;
        }

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
            background: rgba(23, 28, 99, .08);
            color: #171C63;
        }

        .empty-state h6 {
            margin: 0;
            color: #0f172a;
            font-weight: 800;
        }

        .btn-empty-clear {
            margin-top: 14px;
            padding: 9px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            color: #171C63;
            font-weight: 800;
        }

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

        .mobile-page-nav {
            display: none;
        }

        @media (max-width: 992px) {
            .areas-header {
                align-items: stretch;
                flex-direction: column;
            }

            .header-actions,
            .btn-tour,
            .btn-import-areas,
            .btn-add-area {
                width: 100%;
            }

            .search-panel-header,
            .table-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .pagination-wrapper {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .areas-page {
                margin-top: 12px !important;
                padding-right: 12px !important;
                padding-left: 12px !important;
            }

            .mobile-page-nav {
                position: sticky;
                top: 8px;
                z-index: 1040;
                display: flex;
                gap: 10px;
                margin-bottom: 14px;
                padding: 10px;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                background: rgba(255, 255, 255, .92);
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
            }

            .mobile-nav-btn.primary {
                border-color: #171C63;
                background: #171C63;
                color: #ffffff !important;
            }

            .ieesspp-modal-dialog {
                margin: 12px;
            }
        }

        @media (max-width: 576px) {
            .import-body {
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