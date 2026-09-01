@extends('adminlte::page')

@section('title', 'Resguardos de '.$resguardante->nombre1.' '.$resguardante->nombre2.' '.$resguardante->apellido1.' '.$resguardante->apellido2)

@section('content_header')
@stop

@section('content')

@php
    $nombreCompleto = trim(
        ($resguardante->nombre1 ?? '') . ' ' .
        ($resguardante->nombre2 ?? '') . ' ' .
        ($resguardante->apellido1 ?? '') . ' ' .
        ($resguardante->apellido2 ?? '')
    );
@endphp

<div class="container-fluid mt-4 historial-resguardos-page">

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

    {{-- HERO --}}
    <div class="historial-hero mb-4">
        <div class="historial-hero-content">
            <div class="historial-kicker">
                <i class="fas fa-file-signature"></i>
                Inventario institucional
            </div>

            <h1 class="historial-title">
                Resguardos asignados
            </h1>

            <p class="historial-subtitle">
                Consulta los bienes actualmente vinculados al resguardante seleccionado.
            </p>

            <div class="resguardante-card">
                <div class="resguardante-avatar">
                    {{ strtoupper(substr($resguardante->nombre1 ?? 'R', 0, 1)) }}{{ strtoupper(substr($resguardante->apellido1 ?? 'G', 0, 1)) }}
                </div>

                <div>
                    <span>Resguardante</span>
                    <strong>{{ $nombreCompleto }}</strong>
                </div>
            </div>
        </div>

        <div class="historial-hero-actions">
            <button
                type="button"
                onclick="window.history.back()"
                class="btn btn-back-desktop"
            >
                <i class="fas fa-arrow-left"></i>
                Regresar
            </button>

            <a href="{{ url('/dashboard') }}" class="btn btn-dashboard-desktop">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </div>
    </div>

    {{-- RESUMEN --}}
    <div class="summary-grid mb-4">
        <div class="summary-card">
            <div class="summary-icon primary">
                <i class="fas fa-boxes"></i>
            </div>

            <div>
                <span>Total de resguardos</span>
                <strong>{{ $historiales->total() }}</strong>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon success">
                <i class="fas fa-user-shield"></i>
            </div>

            <div>
                <span>Responsable</span>
                <strong>Activo</strong>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon dark">
                <i class="fas fa-clipboard-check"></i>
            </div>

            <div>
                <span>Consulta</span>
                <strong>Historial</strong>
            </div>
        </div>
    </div>

    {{-- TABLA ESCRITORIO --}}
    <div class="historial-table-card desktop-table-card">
        <div class="historial-table-header">
            <div>
                <h5>Listado de bienes asignados</h5>
                <p>Información general de cada bien relacionado al resguardante.</p>
            </div>

            <div class="table-counter">
                {{ $historiales->total() }} registros
            </div>
        </div>

        <div class="table-responsive">
            <table class="table historial-table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>No. Serie</th>
                        <th>Fecha asignación</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($historiales as $historial)
                        @php
                            $resguardo = $historial->resguardo;
                        @endphp

                        <tr>
                            <td>
                                <span class="id-badge">
                                    #{{ $historial->id }}
                                </span>
                            </td>

                            <td>
                                <div class="asset-info">
                                    <div class="asset-icon">
                                        <i class="fas fa-box"></i>
                                    </div>

                                    <div>
                                        <strong>{{ $resguardo->descripcion ?? 'Sin descripción' }}</strong>
                                        <span>Bien institucional</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $resguardo->marca->nombre ?? 'Sin marca' }}
                            </td>

                            <td>
                                {{ $resguardo->modelo ?? 'Sin modelo' }}
                            </td>

                            <td>
                                <span class="soft-badge">
                                    {{ $resguardo->nserie ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                {{ $historial->fecha_asignacion_formatted ?? 'No registrada' }}
                            </td>

                            <td class="text-center">
                                @if($resguardo)
                                    <a
                                        href="{{ route('inventario.index', ['search' => $resguardo->id]) }}"
                                        class="btn-view-resguardo"
                                        title="Ver resguardo"
                                    >
                                        <i class="fas fa-eye"></i>
                                        <span>Ver</span>
                                    </a>
                                @else
                                    <span class="disabled-action">
                                        <i class="fas fa-ban"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>

                                    <h6>No tiene resguardos asignados</h6>

                                    <p>
                                        Cuando este resguardante tenga bienes asignados, aparecerán en esta sección.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TARJETAS MÓVIL --}}
    <div class="mobile-cards-list">
        @forelse($historiales as $historial)
            @php
                $resguardo = $historial->resguardo;
            @endphp

            <div class="mobile-resguardo-card">
                <div class="mobile-card-top">
                    <div class="mobile-card-icon">
                        <i class="fas fa-box"></i>
                    </div>

                    <div>
                        <span class="mobile-card-id">
                            #{{ $historial->id }}
                        </span>

                        <h5>
                            {{ $resguardo->descripcion ?? 'Sin descripción' }}
                        </h5>
                    </div>
                </div>

                <div class="mobile-card-grid">
                    <div>
                        <span>Marca</span>
                        <strong>{{ $resguardo->marca->nombre ?? 'Sin marca' }}</strong>
                    </div>

                    <div>
                        <span>Modelo</span>
                        <strong>{{ $resguardo->modelo ?? 'Sin modelo' }}</strong>
                    </div>

                    <div>
                        <span>No. serie</span>
                        <strong>{{ $resguardo->nserie ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <span>No. inventario</span>
                        <strong>{{ $resguardo->nresguardo ?? 'N/A' }}</strong>
                    </div>

                    <div class="full">
                        <span>Fecha de asignación</span>
                        <strong>{{ $historial->fecha_asignacion_formatted ?? 'No registrada' }}</strong>
                    </div>
                </div>

                @if($resguardo)
                    <a
                        href="{{ route('inventario.index', ['search' => $resguardo->id]) }}"
                        class="mobile-view-btn"
                    >
                        <i class="fas fa-eye"></i>
                        Ver resguardo
                    </a>
                @endif
            </div>
        @empty
            <div class="mobile-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>

                <h6>No tiene resguardos asignados</h6>

                <p>
                    Cuando este resguardante tenga bienes asignados, aparecerán aquí.
                </p>
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col">
            <a
                href="{{ route('resguardantes.etiquetas', $resguardante->id) }}"
                class="btn btn-primary"
            >
                <i class="fas fa-print mr-1"></i>
                Imprimir todas las etiquetas
            </a>
        </div>
    </div>


    {{-- PAGINACIÓN --}}
    <div class="pagination-wrapper mt-4">
        {{ $historiales->links() }}
    </div>

</div>

@stop

@section('css')
<style>
    .historial-resguardos-page {
        color: #111827;
        padding-bottom: 28px;
    }

    .mobile-page-nav {
        display: none;
    }

    .historial-hero {
        display: flex;
        align-items: stretch;
        justify-content: space-between;
        gap: 22px;
        padding: 26px;
        border-radius: 26px;
        background:
            radial-gradient(circle at top left, rgba(23, 28, 99, 0.13), transparent 34%),
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.10), transparent 34%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.075);
    }

    .historial-hero-content {
        min-width: 0;
    }

    .historial-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(23, 28, 99, 0.08);
        color: #171C63;
        font-size: 12px;
        font-weight: 950;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .historial-title {
        margin: 0;
        color: #0f172a;
        font-size: 32px;
        font-weight: 950;
        letter-spacing: -0.055em;
        line-height: 1.05;
    }

    .historial-subtitle {
        margin: 8px 0 0;
        max-width: 720px;
        color: #64748b;
        font-size: 14px;
        font-weight: 650;
        line-height: 1.6;
    }

    .resguardante-card {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
        padding: 12px 14px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
    }

    .resguardante-avatar {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(23, 28, 99, 0.12), rgba(37, 99, 235, 0.12));
        color: #171C63;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 950;
        flex-shrink: 0;
    }

    .resguardante-card span {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .resguardante-card strong {
        display: block;
        margin-top: 2px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 950;
        line-height: 1.25;
    }

    .historial-hero-actions {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        flex-shrink: 0;
    }

    .btn-back-desktop,
    .btn-dashboard-desktop {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 16px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 950;
        transition: all 0.18s ease;
    }

    .btn-back-desktop {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .btn-back-desktop:hover {
        background: #f8fafc;
        color: #171C63;
        transform: translateY(-1px);
    }

    .btn-dashboard-desktop {
        background: linear-gradient(135deg, #171C63 0%, #26318f 100%);
        color: #ffffff !important;
        border: none;
        box-shadow: 0 14px 28px rgba(23, 28, 99, 0.22);
    }

    .btn-dashboard-desktop:hover {
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 18px 34px rgba(23, 28, 99, 0.30);
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.055);
    }

    .summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .summary-icon.primary {
        background: rgba(23, 28, 99, 0.08);
        color: #171C63;
    }

    .summary-icon.success {
        background: #ecfdf5;
        color: #047857;
    }

    .summary-icon.dark {
        background: #f1f5f9;
        color: #0f172a;
    }

    .summary-card span {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .summary-card strong {
        display: block;
        margin-top: 2px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 950;
        letter-spacing: -0.035em;
    }

    .historial-table-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.065);
    }

    .historial-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 19px 22px;
        border-bottom: 1px solid #edf2f7;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .historial-table-header h5 {
        margin: 0;
        color: #0f172a;
        font-size: 16px;
        font-weight: 950;
    }

    .historial-table-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
        font-weight: 650;
    }

    .table-counter {
        padding: 7px 12px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .historial-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .historial-table thead th {
        padding: 14px 18px;
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        font-size: 11px;
        font-weight: 950;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .historial-table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #0f172a;
        font-size: 14px;
        font-weight: 650;
    }

    .historial-table tbody tr {
        transition: background 0.16s ease;
    }

    .historial-table tbody tr:hover {
        background: #fbfdff;
    }

    .id-badge,
    .soft-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 48px;
        padding: 6px 9px;
        border-radius: 999px;
        background: rgba(23, 28, 99, 0.08);
        color: #171C63;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .soft-badge {
        min-width: auto;
        background: #f8fafc;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .soft-badge.dark {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .asset-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 260px;
    }

    .asset-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(23, 28, 99, 0.08);
        color: #171C63;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .asset-info strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 950;
        line-height: 1.25;
    }

    .asset-info span {
        display: block;
        margin-top: 2px;
        color: #64748b;
        font-size: 12px;
        font-weight: 650;
    }

    .btn-view-resguardo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 36px;
        padding: 0 13px;
        border-radius: 12px;
        background: #0f172a;
        color: #ffffff;
        font-size: 13px;
        font-weight: 900;
        text-decoration: none;
        transition: all 0.18s ease;
        white-space: nowrap;
    }

    .btn-view-resguardo:hover {
        color: #ffffff;
        background: #171C63;
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(23, 28, 99, 0.22);
        text-decoration: none;
    }

    .disabled-action {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f1f5f9;
        color: #94a3b8;
    }

    .empty-state,
    .mobile-empty-state {
        padding: 44px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 12px;
        border-radius: 20px;
        background: rgba(23, 28, 99, 0.08);
        color: #171C63;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .empty-state h6,
    .mobile-empty-state h6 {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 950;
    }

    .empty-state p,
    .mobile-empty-state p {
        margin: 6px 0 0;
        font-size: 13px;
        font-weight: 650;
    }

    .mobile-cards-list {
        display: none;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 992px) {
        .historial-hero {
            flex-direction: column;
        }

        .historial-hero-actions {
            width: 100%;
        }

        .btn-back-desktop,
        .btn-dashboard-desktop {
            flex: 1;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .historial-table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .pagination-wrapper {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .historial-resguardos-page {
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
            background: rgba(255, 255, 255, 0.94);
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

        .historial-hero {
            padding: 22px;
            border-radius: 24px;
        }

        .historial-title {
            font-size: 26px;
        }

        .historial-subtitle {
            font-size: 13px;
        }

        .resguardante-card {
            width: 100%;
            align-items: flex-start;
        }

        .historial-hero-actions {
            display: none;
        }

        .desktop-table-card {
            display: none;
        }

        .mobile-cards-list {
            display: grid;
            gap: 14px;
        }

        .mobile-resguardo-card {
            padding: 18px;
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
        }

        .mobile-card-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }

        .mobile-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .mobile-card-id {
            display: inline-flex;
            margin-bottom: 4px;
            padding: 5px 9px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 11px;
            font-weight: 950;
        }

        .mobile-card-top h5 {
            margin: 0;
            color: #0f172a;
            font-size: 16px;
            font-weight: 950;
            line-height: 1.25;
        }

        .mobile-card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 14px;
        }

        .mobile-card-grid div {
            padding: 11px;
            border-radius: 15px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        .mobile-card-grid div.full {
            grid-column: 1 / -1;
        }

        .mobile-card-grid span {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .mobile-card-grid strong {
            display: block;
            margin-top: 3px;
            color: #0f172a;
            font-size: 13px;
            font-weight: 900;
            word-break: break-word;
        }

        .mobile-view-btn {
            min-height: 42px;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 14px;
            background: #0f172a;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 950;
            text-decoration: none !important;
        }

        .mobile-view-btn:hover {
            background: #171C63;
            color: #ffffff !important;
        }
    }

    @media (max-width: 420px) {
        .mobile-card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@stop

@section('js')
<script>
    console.log("Vista de historial de resguardos cargada correctamente");
</script>
@stop