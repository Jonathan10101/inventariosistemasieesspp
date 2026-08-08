@extends('adminlte::page')

@section('title', 'Periodo de prueba finalizado')

@section('content')

<div class="container-fluid intevi-expired-page">

    <div class="intevi-expired-shell">

        {{-- =========================================================
             COLUMNA PRINCIPAL
        ========================================================== --}}
        <div class="intevi-expired-main">

            {{-- Estado --}}
            <div class="intevi-expired-status">
                <span class="intevi-expired-status-dot"></span>
                Periodo de evaluación finalizado
            </div>


            {{-- Encabezado --}}
            <div class="intevi-expired-brand">

                <div class="intevi-expired-icon">
                    <i class="fas fa-lock"></i>
                </div>

                <div>
                    <span class="intevi-expired-eyebrow">
                        INTEVI
                    </span>

                    <h1>
                        Su periodo de prueba ha finalizado
                    </h1>
                </div>

            </div>


            {{-- Descripción --}}
            <p class="intevi-expired-description">
                Los 7 días de evaluación de INTEVI han concluido.
                Su información permanece disponible y protegida.
                Active una licencia para continuar trabajando con
                sus inventarios y resguardos institucionales.
            </p>


            {{-- Datos protegidos --}}
            <div class="intevi-expired-protected">

                <div class="intevi-expired-protected-title">
                    <i class="fas fa-shield-alt"></i>

                    <span>
                        Su información permanece almacenada
                    </span>
                </div>

                <div class="intevi-expired-items">

                    <div class="intevi-expired-item">
                        <span class="intevi-expired-check">
                            <i class="fas fa-check"></i>
                        </span>

                        Inventarios registrados
                    </div>


                    <div class="intevi-expired-item">
                        <span class="intevi-expired-check">
                            <i class="fas fa-check"></i>
                        </span>

                        Resguardos institucionales
                    </div>


                    <div class="intevi-expired-item">
                        <span class="intevi-expired-check">
                            <i class="fas fa-check"></i>
                        </span>

                        Ubicaciones y asignaciones
                    </div>


                    <div class="intevi-expired-item">
                        <span class="intevi-expired-check">
                            <i class="fas fa-check"></i>
                        </span>

                        Documentos y configuraciones
                    </div>

                </div>

            </div>


            {{-- Acciones --}}
            <div class="intevi-expired-actions">

                <a
                    href="https://intevi.app/"
                    class="intevi-expired-primary"
                >
                    <span>
                        Solicitar activación
                    </span>

                    <i class="fas fa-arrow-right"></i>
                </a>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="m-0"
                >
                    @csrf

                    <button
                        type="submit"
                        class="intevi-expired-secondary"
                    >
                        <i class="fas fa-sign-out-alt"></i>

                        Cerrar sesión
                    </button>
                </form>

            </div>

        </div>



        {{-- =========================================================
             PANEL DERECHO
        ========================================================== --}}
        <aside class="intevi-expired-side">

            <div class="intevi-expired-side-top">

                <span class="intevi-expired-side-label">
                    Estado de licencia
                </span>

                <span class="intevi-expired-side-badge">
                    Vencida
                </span>

            </div>


            <div class="intevi-expired-side-content">

                <div class="intevi-expired-days">

                    <span class="intevi-expired-days-number">
                        7
                    </span>

                    <div>
                        <strong>
                            días de prueba
                        </strong>

                        <span>
                            completados
                        </span>
                    </div>

                </div>


                <div class="intevi-expired-divider"></div>


                <div class="intevi-expired-license-info">

                    <div class="intevi-expired-license-row">

                        <div class="intevi-expired-mini-icon">
                            <i class="fas fa-database"></i>
                        </div>

                        <div>
                            <strong>
                                Datos conservados
                            </strong>

                            <span>
                                No hemos eliminado su información.
                            </span>
                        </div>

                    </div>


                    <div class="intevi-expired-license-row">

                        <div class="intevi-expired-mini-icon">
                            <i class="fas fa-key"></i>
                        </div>

                        <div>
                            <strong>
                                Licencia requerida
                            </strong>

                            <span>
                                Active INTEVI para recuperar el acceso.
                            </span>
                        </div>

                    </div>


                    <div class="intevi-expired-license-row">

                        <div class="intevi-expired-mini-icon">
                            <i class="fas fa-bolt"></i>
                        </div>

                        <div>
                            <strong>
                                Reactivación de acceso
                            </strong>

                            <span>
                                Continúe desde donde dejó su trabajo.
                            </span>
                        </div>

                    </div>

                </div>

            </div>


            <div class="intevi-expired-side-footer">

                <i class="fas fa-shield-alt"></i>

                <span>
                    Inventario y resguardo institucional
                </span>

            </div>

        </aside>

    </div>

</div>

@stop


@section('css')

<style>

    /* =========================================================
       INTEVI - PERIODO DE PRUEBA FINALIZADO
    ========================================================= */

    .intevi-expired-page {
        padding-top: 28px;
        padding-bottom: 40px;
    }


    .intevi-expired-shell {
        width: 100%;
        max-width: 1180px;

        margin: 0 auto;

        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(320px, .75fr);

        background: #ffffff;

        border: 1px solid rgba(226, 232, 240, .95);
        border-radius: 24px;

        overflow: hidden;

        box-shadow:
            0 24px 60px rgba(15, 23, 42, .08);
    }


    /* =========================================================
       COLUMNA PRINCIPAL
    ========================================================= */

    .intevi-expired-main {
        padding: 48px 52px 46px;
    }


    .intevi-expired-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 28px;

        padding: 6px 10px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;
        border-radius: 999px;

        color: #64748b;

        font-size: 10px;
        font-weight: 850;

        letter-spacing: .055em;
        text-transform: uppercase;
    }


    .intevi-expired-status-dot {
        width: 6px;
        height: 6px;

        background: #94a3b8;

        border-radius: 50%;
    }


    /* =========================================================
       BRAND / TITULO
    ========================================================= */

    .intevi-expired-brand {
        display: flex;
        align-items: center;

        gap: 18px;

        margin-bottom: 22px;
    }


    .intevi-expired-icon {
        width: 62px;
        height: 62px;
        min-width: 62px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                #171C63 0%,
                #26318f 100%
            );

        color: #ffffff;

        font-size: 21px;

        box-shadow:
            0 14px 30px rgba(23, 28, 99, .22);
    }


    .intevi-expired-eyebrow {
        display: block;

        margin-bottom: 5px;

        color: #171C63;

        font-size: 11px;
        font-weight: 950;

        letter-spacing: .13em;
    }


    .intevi-expired-brand h1 {
        margin: 0;

        max-width: 650px;

        color: #0f172a;

        font-size: 31px;
        line-height: 1.16;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .intevi-expired-description {
        max-width: 690px;

        margin: 0 0 30px;

        color: #64748b;

        font-size: 14px;
        line-height: 1.75;

        font-weight: 550;
    }


    /* =========================================================
       INFORMACION PROTEGIDA
    ========================================================= */

    .intevi-expired-protected {
        margin-bottom: 32px;

        padding: 20px;

        background:
            linear-gradient(
                135deg,
                rgba(23, 28, 99, .035),
                rgba(23, 28, 99, .012)
            );

        border: 1px solid rgba(23, 28, 99, .08);
        border-radius: 17px;
    }


    .intevi-expired-protected-title {
        display: flex;
        align-items: center;

        gap: 9px;

        margin-bottom: 16px;

        color: #171C63;

        font-size: 12px;
        font-weight: 900;
    }


    .intevi-expired-protected-title i {
        font-size: 13px;
    }


    .intevi-expired-items {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 11px 22px;
    }


    .intevi-expired-item {
        display: flex;
        align-items: center;

        gap: 9px;

        color: #475569;

        font-size: 12px;
        font-weight: 700;
    }


    .intevi-expired-check {
        width: 20px;
        height: 20px;
        min-width: 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 6px;

        background: #ffffff;

        border: 1px solid rgba(23, 28, 99, .10);

        color: #171C63;

        font-size: 8px;
    }


    /* =========================================================
       BOTONES
    ========================================================= */

    .intevi-expired-actions {
        display: flex;
        align-items: center;

        gap: 11px;
    }


    .intevi-expired-primary {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 14px;

        padding: 0 19px;

        background:
            linear-gradient(
                135deg,
                #171C63 0%,
                #26318f 100%
            );

        border: 1px solid #171C63;
        border-radius: 11px;

        color: #ffffff !important;

        font-size: 12px;
        font-weight: 850;

        text-decoration: none !important;

        box-shadow:
            0 10px 22px rgba(23, 28, 99, .18);

        transition:
            transform .16s ease,
            box-shadow .16s ease;
    }


    .intevi-expired-primary:hover {
        color: #ffffff !important;

        transform: translateY(-1px);

        box-shadow:
            0 14px 28px rgba(23, 28, 99, .24);
    }


    .intevi-expired-primary i {
        font-size: 9px;
    }


    .intevi-expired-secondary {
        min-height: 44px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 0 16px;

        background: #ffffff;

        border: 1px solid #dfe5ed;
        border-radius: 11px;

        color: #64748b;

        font-size: 11px;
        font-weight: 800;

        cursor: pointer;

        transition: all .15s ease;
    }


    .intevi-expired-secondary:hover {
        background: #f8fafc;
        color: #334155;
        border-color: #cfd8e5;
    }


    /* =========================================================
       PANEL DERECHO
    ========================================================= */

    .intevi-expired-side {
        display: flex;
        flex-direction: column;

        min-height: 100%;

        padding: 26px;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(78, 91, 190, .55),
                transparent 38%
            ),
            linear-gradient(
                150deg,
                #171C63 0%,
                #101447 100%
            );

        color: #ffffff;
    }


    .intevi-expired-side-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        margin-bottom: 44px;
    }


    .intevi-expired-side-label {
        color: rgba(255, 255, 255, .68);

        font-size: 10px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;
    }


    .intevi-expired-side-badge {
        display: inline-flex;
        align-items: center;

        padding: 5px 9px;

        background: rgba(255, 255, 255, .09);

        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 999px;

        color: #ffffff;

        font-size: 9px;
        font-weight: 900;

        text-transform: uppercase;
        letter-spacing: .06em;
    }


    .intevi-expired-side-content {
        flex: 1;
    }


    .intevi-expired-days {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    .intevi-expired-days-number {
        color: #ffffff;

        font-size: 54px;
        font-weight: 950;

        line-height: .9;

        letter-spacing: -.065em;
    }


    .intevi-expired-days div {
        display: flex;
        flex-direction: column;
    }


    .intevi-expired-days strong {
        color: #ffffff;

        font-size: 13px;
        font-weight: 850;
    }


    .intevi-expired-days div span {
        margin-top: 2px;

        color: rgba(255, 255, 255, .60);

        font-size: 11px;
        font-weight: 650;
    }


    .intevi-expired-divider {
        height: 1px;

        margin: 28px 0;

        background: rgba(255, 255, 255, .10);
    }


    .intevi-expired-license-info {
        display: flex;
        flex-direction: column;

        gap: 22px;
    }


    .intevi-expired-license-row {
        display: flex;
        align-items: flex-start;

        gap: 12px;
    }


    .intevi-expired-mini-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .09);

        color: #ffffff;

        font-size: 11px;
    }


    .intevi-expired-license-row > div:last-child {
        display: flex;
        flex-direction: column;
    }


    .intevi-expired-license-row strong {
        color: #ffffff;

        font-size: 11px;
        font-weight: 850;
    }


    .intevi-expired-license-row span {
        margin-top: 3px;

        color: rgba(255, 255, 255, .57);

        font-size: 10px;
        line-height: 1.45;

        font-weight: 550;
    }


    .intevi-expired-side-footer {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-top: 35px;
        padding-top: 17px;

        border-top: 1px solid rgba(255, 255, 255, .09);

        color: rgba(255, 255, 255, .50);

        font-size: 9px;
        font-weight: 750;

        letter-spacing: .035em;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .intevi-expired-shell {
            grid-template-columns: 1fr;
        }


        .intevi-expired-main {
            padding: 38px;
        }


        .intevi-expired-side {
            min-height: auto;
        }


        .intevi-expired-side-top {
            margin-bottom: 26px;
        }


        .intevi-expired-license-info {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 15px;
        }

    }


    @media (max-width: 767.98px) {

        .intevi-expired-page {
            padding-top: 15px;
        }


        .intevi-expired-shell {
            border-radius: 18px;
        }


        .intevi-expired-main {
            padding: 28px 24px;
        }


        .intevi-expired-brand {
            align-items: flex-start;
        }


        .intevi-expired-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;

            border-radius: 15px;

            font-size: 17px;
        }


        .intevi-expired-brand h1 {
            font-size: 24px;
        }


        .intevi-expired-items {
            grid-template-columns: 1fr;
        }


        .intevi-expired-license-info {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 575.98px) {

        .intevi-expired-main {
            padding: 24px 18px;
        }


        .intevi-expired-brand {
            flex-direction: column;
        }


        .intevi-expired-actions {
            align-items: stretch;
            flex-direction: column;
        }


        .intevi-expired-primary,
        .intevi-expired-secondary {
            width: 100%;
        }


        .intevi-expired-side {
            padding: 22px 18px;
        }

    }

</style>

@stop