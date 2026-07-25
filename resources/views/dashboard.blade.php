@extends('adminlte::page')

@section('title', 'Panel de Control | INTEVI')

@section('content_header')
@stop

@section('content')

<div class="intevi-dashboard">

    <div
        data-tour-page="dashboard"
        data-tour-version="1"
        data-tour-general="true"
        data-tour-general-version="3"
        data-tour-autostart="true"
        hidden
    ></div>

    {{-- HERO PRINCIPAL --}}
    <section class="dash-hero">
        <div class="dash-hero-content">
            <div class="dash-kicker">
                <!--
                <i class="fas fa-shield-alt"></i>
                -->
                INTEVI · Inventario y resguardo institucional
            </div>

            <h1>Panel de Control</h1>

            <p>
                Administra inventarios, resguardos, responsables, áreas y ubicaciones desde un entorno claro,
                moderno y fácil de usar.
            </p>

            <div class="dash-hero-actions">
                <a href="{{ url('/inventario') }}" class="btn dash-btn-primary">
                    <i class="fas fa-plus"></i>
                    Agregar inventario
                </a>

                {{--
                <a href="{{ url('/resguardos') }}" class="btn dash-btn-secondary">
                    <i class="fas fa-chart-area"></i>
                    Ver gráficos estadísticos 
                </a>
                --}}
            </div>
        </div>

        <div class="dash-hero-panel">
            <div class="dash-system-card">

                <div class="dash-system-icon">
                    <img
                        src="{{ asset('images/intevi logo.png') }}"
                        alt="Logo de INTEVI"
                        class="dash-intevi-logo"
                    >
                </div>

                <h3>INTEVI</h3>
                <p>Inventario y resguardo institucional</p>

                <!--
                <div class="dash-status">
                    <span></span>
                </div>
                -->

            </div>
        </div>
    </section>

    <x-tenant-storage-card :storage="$storage" />

    {{-- MÉTRICAS --}}
    <section class="dash-metrics">

        <div class="dash-stat">
            <div class="dash-stat-icon blue">
                <i class="fas fa-boxes"></i>
            </div>

            <div>
                <span>Inventarios</span>
                <strong>{{ $totalInventarios ?? 0  }}</strong>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-icon green">
                <i class="fas fa-tags"></i>
            </div>

            <div>
                <span>Marcas</span>
                <strong>{{ $totalMarcas ?? 0 }}</strong>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-icon purple">
                <i class="fas fa-user-shield"></i>
            </div>

            <div>
                <span>Resguardantes</span>
                <strong>{{ $totalResguardantes ?? 0 }}</strong>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-icon orange">
                <i class="fas fa-sitemap"></i>
            </div>

            <div>
                <span>Áreas</span>
                <strong>{{ $totalAreas ?? 0 }}</strong>
            </div>
        </div>

    </section>

    {{-- MÓDULOS PRINCIPALES --}}
    <section class="dash-section">
        <div class="dash-section-header">
            <div>
                <h2>Módulos principales</h2>
                <p>Accesos directos para operar el sistema.</p>
            </div>
        </div>

        <div class="dash-module-grid">

            <a href="{{ url('/inventario') }}" class="dash-module-card">
                <div class="dash-module-icon primary">
                    <i class="fas fa-box-open"></i>
                </div>

                <div>
                    <h3>Inventario</h3>
                    <p>Registra, consulta y administra bienes institucionales.</p>
                </div>

                <span class="dash-module-arrow">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>

            <a href="{{ url('/marcas') }}" class="dash-module-card">
                <div class="dash-module-icon success">
                    <i class="fas fa-tags"></i>
                </div>
            
                <div>
                    <h3>Marcas</h3>
                    <p>Consulta las marcas registradas.</p>
                </div>

                <span class="dash-module-arrow">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>

            <a href="{{ url('/resguardante') }}" class="dash-module-card">
                <div class="dash-module-icon purple">
                    <i class="fas fa-user-tie"></i>
                </div>

                <div>
                    <h3>Resguardantes</h3>
                    <p>Gestiona las personas responsables de los bienes.</p>
                </div>

                <span class="dash-module-arrow">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>

        </div>
    </section>

    <div class="row">

        {{-- PANEL DESPLEGABLE --}}
        <div class="col-lg-5 mb-4">
            <div class="dash-card">

                <div class="dash-card-header">
                    <div>
                        <h3>Centro de operación</h3>
                        <p>Secciones desplegables para navegar rápido.</p>
                    </div>
                </div>

                {{-- DESPLEGABLE 1 --}}
                <div class="dash-accordion-item">
                    <button
                        class="dash-accordion-button"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseGestion"
                        aria-expanded="true"
                        aria-controls="collapseGestion"
                    >
                        <span>
                            <i class="fas fa-layer-group"></i>
                            Gestión principal
                        </span>

                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div id="collapseGestion" class="collapse show">
                        <div class="dash-accordion-body">

                            <a href="{{ url('/inventario') }}" class="dash-mini-link">
                                <i class="fas fa-boxes"></i>
                                <div>
                                    <strong>Inventario</strong>
                                    <span>Bienes y activos registrados.</span>
                                </div>
                            </a>
                            <!--
                            <a href="{{ url('/resguardos') }}" class="dash-mini-link">
                                <i class="fas fa-file-signature"></i>
                                <div>
                                    <strong>Resguardos</strong>
                                    <span>Documentación y movimientos.</span>
                                </div>
                            </a>
                            -->
                            <a href="{{ url('/resguardante') }}" class="dash-mini-link">
                                <i class="fas fa-user-shield"></i>
                                <div>
                                    <strong>Resguardantes</strong>
                                    <span>Responsables institucionales.</span>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                {{-- DESPLEGABLE 2 --}}
                <div class="dash-accordion-item">
                    <button
                        class="dash-accordion-button collapsed"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseCatalogos"
                        aria-expanded="false"
                        aria-controls="collapseCatalogos"
                    >
                        <span>
                            <i class="fas fa-folder-open"></i>
                            Catálogos
                        </span>

                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div id="collapseCatalogos" class="collapse">
                        <div class="dash-accordion-body">

                            <a href="{{ url('/marcas') }}" class="dash-mini-link">
                                <i class="fas fa-tags"></i>
                                <div>
                                    <strong>Marcas</strong>
                                    <span>Catálogo de fabricantes.</span>
                                </div>
                            </a>

                            <a href="{{ url('/puestos') }}" class="dash-mini-link">
                                <i class="fas fa-briefcase"></i>
                                <div>
                                    <strong>Puestos</strong>
                                    <span>Cargos de resguardantes.</span>
                                </div>
                            </a>

                            <a href="{{ url('/areadeasignacion') }}" class="dash-mini-link">
                                <i class="fas fa-sitemap"></i>
                                <div>
                                    <strong>Áreas de asignación</strong>
                                    <span>Áreas institucionales.</span>
                                </div>
                            </a>

                            <a href="{{ url('/ubicacionfisica') }}" class="dash-mini-link">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Ubicaciones físicas</strong>
                                    <span>Espacios y lugares físicos.</span>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                {{-- DESPLEGABLE 3 --}}
                {{--
                <div class="dash-accordion-item">
                    <button
                        class="dash-accordion-button collapsed"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseAdministracion"
                        aria-expanded="false"
                        aria-controls="collapseAdministracion"
                    >
                        <span>
                            <i class="fas fa-user-lock"></i>
                            Administración
                        </span>

                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div id="collapseAdministracion" class="collapse">
                        <div class="dash-accordion-body">

                            <a href="{{ url('/usuarios') }}" class="dash-mini-link">
                                <i class="fas fa-users-cog"></i>
                                <div>
                                    <strong>Usuarios</strong>
                                    <span>Gestión de accesos.</span>
                                </div>
                            </a>

                            <!--
                            <a href="{{ url('/roles') }}" class="dash-mini-link">
                                <i class="fas fa-key"></i>
                                <div>
                                    <strong>Roles y permisos</strong>
                                    <span>Control de privilegios.</span>
                                </div>
                            </a>
                            -->
                        </div>
                    </div>
                </div>
                --}}

            </div>
        </div>

        {{-- ACTIVIDAD RECIENTE --}}
        {{--
        <div class="col-lg-7 mb-4">
            <div class="dash-card h-100">

                <div class="dash-card-header">
                    <div>
                        <h3>Actividad reciente</h3>
                        <p>Últimos movimientos del sistema.</p>
                    </div>

                    <a href="{{ url('/inventario') }}" class="dash-card-link">
                        Ver todo
                    </a>
                </div>

                <div class="dash-table-wrapper">
                    <table class="table dash-table mb-0">
                        <thead>
                            <tr>
                                <th>Bien</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($ultimosResguardos) && $ultimosResguardos->count())
                                @foreach($ultimosResguardos as $resguardo)
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $resguardo->descripcion ?? 'Bien registrado' }}
                                            </strong>
                                            <span>
                                                {{ $resguardo->nserie ?? 'Sin serie' }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $resguardo->resguardante->nombre1 ?? 'Sin responsable' }}
                                        </td>

                                        <td>
                                            <span class="dash-badge-success">
                                                Activo
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        <div class="dash-empty">
                                            <div class="dash-empty-icon">
                                                <i class="fas fa-inbox"></i>
                                            </div>

                                            <strong>Sin actividad reciente</strong>
                                            <span>Cuando registres inventarios o resguardos aparecerán aquí.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        --}}

    </div>

</div>

@stop

@section('css')
<style>
    :root {
        --dash-primary: #171C63;
        --dash-primary-2: #26318f;
        --dash-bg: #f4f7fb;
        --dash-card: #ffffff;
        --dash-text: #0f172a;
        --dash-muted: #64748b;
        --dash-border: #e2e8f0;
        --dash-blue: #2563eb;
        --dash-green: #059669;
        --dash-purple: #7c3aed;
        --dash-orange: #d97706;
    }

    body {
        background: var(--dash-bg) !important;
    }

    .content-wrapper {
        background:
            radial-gradient(circle at top left, rgba(23, 28, 99, 0.10), transparent 30%),
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 35%),
            linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%) !important;
    }

    .intevi-dashboard {
        padding: 24px 0 28px;
    }

    .dash-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        margin-bottom: 22px;
        padding: 28px;
        border-radius: 30px;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.14), transparent 38%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .dash-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(23, 28, 99, 0.08);
        color: var(--dash-primary);
        font-size: 12px;
        font-weight: 950;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .dash-hero h1 {
        margin: 16px 0 8px;
        color: var(--dash-text);
        font-size: 36px;
        font-weight: 950;
        letter-spacing: -0.06em;
        line-height: 1.05;
    }

    .dash-hero p {
        max-width: 740px;
        margin: 0;
        color: var(--dash-muted);
        font-size: 15px;
        font-weight: 650;
        line-height: 1.65;
    }

    .dash-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .dash-btn-primary,
    .dash-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 15px;
        font-weight: 950;
        border: none;
        transition: all 0.18s ease;
    }

    .dash-btn-primary {
        background: linear-gradient(135deg, var(--dash-primary), var(--dash-primary-2));
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(23, 28, 99, 0.24);
    }

    .dash-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 20px 38px rgba(23, 28, 99, 0.32);
    }

    .dash-btn-secondary {
        background: #ffffff;
        color: var(--dash-primary) !important;
        border: 1px solid var(--dash-border);
    }

    .dash-btn-secondary:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .dash-hero-panel {
        display: flex;
        align-items: stretch;
    }

    .dash-system-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .dash-system-icon {
        width: 82px;
        height: 82px;
        margin: 14px auto 2px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dash-intevi-logo {
        display: block;
        width: 64px;
        height: 64px;
        object-fit: contain;
    }

    .dash-system-card h3 {
        margin: 0;
        color: #171c63;
        font-size: 24px;
        font-weight: 800;
        line-height: 1.1;
    }

    .dash-system-card p {
        margin: 7px 0 14px;
    }

    .dash-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #047857;
        font-size: 12px;
        font-weight: 950;
    }

    .dash-status span {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #10b981;
    }

    .dash-metrics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .dash-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid var(--dash-border);
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.055);
        transition: all 0.18s ease;
    }

    .dash-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 44px rgba(15, 23, 42, 0.075);
    }

    .dash-stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .dash-stat-icon.blue {
        background: rgba(37, 99, 235, 0.10);
        color: var(--dash-blue);
    }

    .dash-stat-icon.green {
        background: rgba(5, 150, 105, 0.10);
        color: var(--dash-green);
    }

    .dash-stat-icon.purple {
        background: rgba(124, 58, 237, 0.10);
        color: var(--dash-purple);
    }

    .dash-stat-icon.orange {
        background: rgba(217, 119, 6, 0.12);
        color: var(--dash-orange);
    }

    .dash-stat span {
        display: block;
        color: var(--dash-muted);
        font-size: 12px;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .dash-stat strong {
        display: block;
        margin-top: 2px;
        color: var(--dash-text);
        font-size: 28px;
        font-weight: 950;
        letter-spacing: -0.045em;
    }

    .dash-section {
        margin-bottom: 22px;
    }

    .dash-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 14px;
    }

    .dash-section-header h2 {
        margin: 0;
        color: var(--dash-text);
        font-size: 20px;
        font-weight: 950;
        letter-spacing: -0.04em;
    }

    .dash-section-header p {
        margin: 3px 0 0;
        color: var(--dash-muted);
        font-size: 13px;
        font-weight: 650;
    }

    .dash-module-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .dash-module-card {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        min-height: 145px;
        padding: 22px;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid var(--dash-border);
        color: inherit;
        text-decoration: none !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.055);
        transition: all 0.18s ease;
        overflow: hidden;
    }

    .dash-module-card::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        border-radius: 999px;
        background: rgba(23, 28, 99, 0.05);
        transition: all 0.18s ease;
    }

    .dash-module-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08);
    }

    .dash-module-card:hover::after {
        transform: scale(1.25);
        background: rgba(23, 28, 99, 0.075);
    }

    .dash-module-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        z-index: 1;
    }

    .dash-module-icon.primary {
        background: rgba(23, 28, 99, 0.08);
        color: var(--dash-primary);
    }

    .dash-module-icon.success {
        background: rgba(5, 150, 105, 0.10);
        color: var(--dash-green);
    }

    .dash-module-icon.purple {
        background: rgba(124, 58, 237, 0.10);
        color: var(--dash-purple);
    }

    .dash-module-card h3 {
        margin: 2px 0 5px;
        color: var(--dash-text);
        font-size: 17px;
        font-weight: 950;
    }

    .dash-module-card p {
        margin: 0;
        color: var(--dash-muted);
        font-size: 13px;
        font-weight: 650;
        line-height: 1.45;
    }

    .dash-module-arrow {
        position: absolute;
        right: 18px;
        bottom: 18px;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: #f8fafc;
        color: var(--dash-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .dash-card {
        padding: 22px;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid var(--dash-border);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .dash-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
    }

    .dash-card-header h3 {
        margin: 0;
        color: var(--dash-text);
        font-size: 18px;
        font-weight: 950;
        letter-spacing: -0.035em;
    }

    .dash-card-header p {
        margin: 4px 0 0;
        color: var(--dash-muted);
        font-size: 13px;
        font-weight: 650;
    }

    .dash-card-link {
        color: var(--dash-primary);
        font-size: 13px;
        font-weight: 950;
        text-decoration: none !important;
    }

    .dash-accordion-item {
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 10px;
        background: #ffffff;
    }

    .dash-accordion-button {
        width: 100%;
        min-height: 54px;
        padding: 0 15px;
        border: none;
        background: #f8fafc;
        color: var(--dash-text);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 950;
        outline: none !important;
        transition: all 0.18s ease;
    }

    .dash-accordion-button span {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .dash-accordion-button span i {
        color: var(--dash-primary);
    }

    .dash-accordion-button:hover {
        background: rgba(23, 28, 99, 0.06);
        color: var(--dash-primary);
    }

    .dash-accordion-button > .fa-chevron-down {
        transition: transform 0.18s ease;
        color: #94a3b8;
    }

    .dash-accordion-button[aria-expanded="true"] > .fa-chevron-down {
        transform: rotate(180deg);
        color: var(--dash-primary);
    }

    .dash-accordion-body {
        padding: 12px;
        display: grid;
        gap: 9px;
        background: #ffffff;
    }

    .dash-mini-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 15px;
        background: #ffffff;
        color: inherit;
        text-decoration: none !important;
        transition: all 0.18s ease;
    }

    .dash-mini-link:hover {
        background: #f8fafc;
        transform: translateX(2px);
    }

    .dash-mini-link > i {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        background: rgba(23, 28, 99, 0.08);
        color: var(--dash-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dash-mini-link strong {
        display: block;
        color: var(--dash-text);
        font-size: 13px;
        font-weight: 950;
    }

    .dash-mini-link span {
        display: block;
        color: var(--dash-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .dash-table-wrapper {
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        overflow: hidden;
    }

    .dash-table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-size: 12px;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 1px solid var(--dash-border) !important;
    }

    .dash-table td {
        vertical-align: middle;
        color: #334155;
        font-size: 13px;
        font-weight: 650;
        border-top: 1px solid #edf2f7 !important;
    }

    .dash-table td strong {
        display: block;
        color: var(--dash-text);
        font-size: 14px;
        font-weight: 950;
    }

    .dash-table td span {
        display: block;
        color: var(--dash-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .dash-badge-success {
        display: inline-flex !important;
        align-items: center;
        padding: 7px 11px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #047857 !important;
        font-size: 11px !important;
        font-weight: 950;
    }

    .dash-empty {
        padding: 44px 12px;
        text-align: center;
    }

    .dash-empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 12px;
        border-radius: 20px;
        background: #f8fafc;
        color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .dash-empty strong {
        display: block;
        color: var(--dash-text);
        font-size: 15px;
        font-weight: 950;
    }

    .dash-empty span {
        display: block;
        margin-top: 4px;
        color: var(--dash-muted);
        font-size: 13px;
        font-weight: 650;
    }

    @media (max-width: 1200px) {
        .dash-metrics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dash-module-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 992px) {
        .dash-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {

        .dash-hero-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .dash-system-card {
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .dash-system-icon {
            width: 82px;
            height: 82px;
            margin: 14px auto 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dash-intevi-logo {
            display: block;
            width: 64px;
            height: 64px;
            margin: 0 auto;
            object-fit: contain;
        }

        .dash-system-card h3,
        .dash-system-card p,
        .dash-status {
            width: 100%;
            text-align: center;
        }

        .dash-status {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .intevi-dashboard {
            padding-top: 14px;
        }

        .dash-hero {
            padding: 22px;
            border-radius: 24px;
        }

        .dash-hero h1 {
            font-size: 28px;
        }

        .dash-metrics {
            grid-template-columns: 1fr;
        }

        .dash-hero-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .dash-card {
            padding: 18px;
            border-radius: 22px;
        }
    }
</style>
@stop