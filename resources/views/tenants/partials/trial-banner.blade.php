@if(tenant() && tenant()->isOnTrial())

    @php
        $trialDays = tenant()->trialDaysRemaining();
        $trialHours = tenant()->trialHoursRemaining();
        $trialEndsAt = tenant()->trial_ends_at;
    @endphp

    <style>
        /* =========================================================
           INTEVI — ESTADO DE LICENCIA / PRUEBA
        ========================================================= */

        .intevi-license-status {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 24px;

            width: 100%;

            margin-bottom: 22px;

            padding: 16px 18px;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(23, 28, 99, 0.045),
                    transparent 34%
                ),
                #ffffff;

            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 16px;

            box-shadow:
                0 8px 24px rgba(15, 23, 42, 0.045);

            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | Línea institucional
        |--------------------------------------------------------------------------
        */

        .intevi-license-status::before {
            content: "";

            position: absolute;

            left: 0;
            top: 14px;
            bottom: 14px;

            width: 3px;

            border-radius: 0 999px 999px 0;

            background: #171C63;
        }


        /*
        |--------------------------------------------------------------------------
        | Lado izquierdo
        |--------------------------------------------------------------------------
        */

        .intevi-license-left {
            display: flex;
            align-items: center;

            gap: 14px;

            min-width: 0;
            flex: 1;
        }


        .intevi-license-icon {
            width: 44px;
            height: 44px;
            min-width: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    rgba(23, 28, 99, 0.10),
                    rgba(38, 49, 143, 0.055)
                );

            border:
                1px solid rgba(23, 28, 99, 0.08);

            color: #171C63;

            font-size: 16px;
        }


        .intevi-license-info {
            min-width: 0;
        }


        .intevi-license-heading {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 8px;

            margin-bottom: 4px;
        }


        .intevi-license-title {
            margin: 0;

            color: #0f172a;

            font-size: 14px;
            font-weight: 900;

            letter-spacing: -0.018em;
        }


        .intevi-license-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            min-height: 22px;

            padding: 3px 8px;

            border-radius: 999px;

            background: rgba(23, 28, 99, 0.07);

            border:
                1px solid rgba(23, 28, 99, 0.07);

            color: #171C63;

            font-size: 9px;
            font-weight: 900;

            letter-spacing: 0.055em;

            text-transform: uppercase;
        }


        .intevi-license-badge-dot {
            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: #171C63;
        }


        .intevi-license-description {
            margin: 0;

            color: #64748b;

            font-size: 12px;
            font-weight: 600;

            line-height: 1.5;
        }


        .intevi-license-description strong {
            color: #334155;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | Lado derecho
        |--------------------------------------------------------------------------
        */

        .intevi-license-right {
            display: flex;
            align-items: center;

            gap: 20px;

            flex-shrink: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Tiempo restante
        |--------------------------------------------------------------------------
        */

        .intevi-license-remaining {
            display: flex;
            align-items: center;

            gap: 11px;

            padding-right: 20px;

            border-right:
                1px solid #e9edf3;
        }


        .intevi-license-number {
            min-width: 35px;

            color: #171C63;

            font-size: 26px;
            font-weight: 950;

            line-height: 1;

            letter-spacing: -0.055em;

            text-align: right;
        }


        .intevi-license-time-copy {
            display: flex;
            flex-direction: column;

            line-height: 1.25;
        }


        .intevi-license-time-label {
            color: #334155;

            font-size: 10px;
            font-weight: 900;

            letter-spacing: 0.04em;

            text-transform: uppercase;
        }


        .intevi-license-time-date {
            margin-top: 3px;

            color: #94a3b8;

            font-size: 10px;
            font-weight: 650;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | CTA
        |--------------------------------------------------------------------------
        */

        .intevi-license-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 39px;

            padding: 0 15px;

            background:
                linear-gradient(
                    135deg,
                    #171C63 0%,
                    #26318f 100%
                );

            border:
                1px solid #171C63;

            border-radius: 10px;

            color: #ffffff !important;

            font-size: 11px;
            font-weight: 850;

            text-decoration: none !important;

            white-space: nowrap;

            box-shadow:
                0 7px 16px rgba(23, 28, 99, 0.16);

            transition:
                transform 0.16s ease,
                box-shadow 0.16s ease,
                background 0.16s ease;
        }


        .intevi-license-button:hover {
            color: #ffffff !important;

            text-decoration: none !important;

            transform: translateY(-1px);

            box-shadow:
                0 10px 22px rgba(23, 28, 99, 0.22);
        }


        .intevi-license-button i {
            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            .intevi-license-status {
                align-items: flex-start;

                flex-direction: column;

                gap: 15px;
            }


            .intevi-license-right {
                width: 100%;

                justify-content: flex-end;

                padding-left: 58px;
            }

        }


        @media (max-width: 767.98px) {

            .intevi-license-status {
                padding: 15px;
            }


            .intevi-license-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;

                border-radius: 11px;
            }


            .intevi-license-right {
                padding-left: 54px;

                gap: 14px;
            }


            .intevi-license-number {
                font-size: 22px;
            }

        }


        @media (max-width: 575.98px) {

            .intevi-license-status {
                border-radius: 14px;
            }


            .intevi-license-left {
                align-items: flex-start;
            }


            .intevi-license-right {
                padding-left: 0;

                align-items: stretch;

                flex-direction: column;

                gap: 12px;
            }


            .intevi-license-remaining {
                width: 100%;

                padding-right: 0;
                padding-bottom: 11px;

                border-right: 0;

                border-bottom:
                    1px solid #e9edf3;
            }


            .intevi-license-number {
                text-align: left;
            }


            .intevi-license-button {
                width: 100%;
            }

        }

    </style>


    <div class="intevi-license-status">


        {{-- =====================================================
             INFORMACIÓN
        ====================================================== --}}

        <div class="intevi-license-left">

            <div class="intevi-license-icon">
                <i class="fas fa-key"></i>
            </div>


            <div class="intevi-license-info">

                <div class="intevi-license-heading">

                    <h6 class="intevi-license-title">
                        Licencia de INTEVI
                    </h6>


                    <span class="intevi-license-badge">

                        <span class="intevi-license-badge-dot"></span>

                        Prueba activa

                    </span>

                </div>


                <p class="intevi-license-description">

                    @if($trialDays > 1)

                        Su institución cuenta con
                        <strong>acceso completo a todas las funciones</strong>
                        durante el periodo de evaluación.

                    @elseif($trialHours > 1)

                        El periodo de evaluación está próximo a finalizar.
                        Active su licencia para mantener
                        <strong>el acceso completo al sistema.</strong>

                    @elseif($trialHours === 1)

                        Su periodo de evaluación finaliza aproximadamente
                        en una hora.

                    @else

                        Su periodo de evaluación está por finalizar.
                        Active su licencia para continuar utilizando INTEVI.

                    @endif

                </p>

            </div>

        </div>



        {{-- =====================================================
             ESTADO + ACCIÓN
        ====================================================== --}}

        <div class="intevi-license-right">


            <div class="intevi-license-remaining">

                @if($trialDays > 1)

                    <div class="intevi-license-number">
                        {{ $trialDays }}
                    </div>


                    <div class="intevi-license-time-copy">

                        <span class="intevi-license-time-label">
                            Días restantes
                        </span>


                        @if($trialEndsAt)

                            <span class="intevi-license-time-date">
                                Finaliza
                                {{ $trialEndsAt->translatedFormat('d M Y') }}
                            </span>

                        @endif

                    </div>

                @else

                    <div class="intevi-license-number">
                        {{ $trialHours }}
                    </div>


                    <div class="intevi-license-time-copy">

                        <span class="intevi-license-time-label">
                            Horas restantes
                        </span>


                        @if($trialEndsAt)

                            <span class="intevi-license-time-date">
                                Finaliza
                                {{ $trialEndsAt->translatedFormat('d M Y') }}
                            </span>

                        @endif

                    </div>

                @endif

            </div>



            <a
                href="https://intevi.app/"
                class="intevi-license-button"
            >

                Activar licencia

                <i class="fas fa-arrow-right"></i>

            </a>

        </div>

    </div>

@endif