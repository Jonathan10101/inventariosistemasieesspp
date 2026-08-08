@if(tenant() && tenant()->isOnTrial())

    @php
        $trialDays = tenant()->trialDaysRemaining();
        $trialHours = tenant()->trialHoursRemaining();

        /*
        |--------------------------------------------------------------------------
        | Progreso visual de la prueba
        |--------------------------------------------------------------------------
        |
        | 7 días = 168 horas.
        | Solo se utiliza para la barra visual.
        |
        */
        $totalTrialHours = 7 * 24;

        $remainingHours = max(
            0,
            min($totalTrialHours, $trialHours)
        );

        $elapsedPercentage = 100 - (($remainingHours / $totalTrialHours) * 100);

        $elapsedPercentage = max(
            0,
            min(100, $elapsedPercentage)
        );
    @endphp


    <style>
        .intevi-trial-card {
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(23, 28, 99, 0.08),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8faff 100%
                );

            border: 1px solid rgba(23, 28, 99, 0.10);
            border-radius: 18px;

            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.055);

            color: #0f172a;
        }


        .intevi-trial-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;

            width: 4px;
            height: 100%;

            background:
                linear-gradient(
                    180deg,
                    #171C63 0%,
                    #3949ab 100%
                );
        }


        .intevi-trial-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 24px;

            padding: 18px 20px 16px 22px;
        }


        .intevi-trial-main {
            display: flex;
            align-items: center;

            gap: 15px;

            min-width: 0;
            flex: 1;
        }


        .intevi-trial-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #171C63 0%,
                    #2d3a9f 100%
                );

            color: #ffffff;

            font-size: 18px;

            box-shadow:
                0 10px 22px rgba(23, 28, 99, 0.20);
        }


        .intevi-trial-content {
            min-width: 0;
        }


        .intevi-trial-topline {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 8px;

            margin-bottom: 4px;
        }


        .intevi-trial-badge {
            display: inline-flex;
            align-items: center;

            padding: 4px 9px;

            border-radius: 999px;

            background:
                rgba(23, 28, 99, 0.08);

            color: #171C63;

            font-size: 10px;
            font-weight: 900;

            letter-spacing: 0.08em;

            text-transform: uppercase;
        }


        .intevi-trial-title {
            margin: 0;

            color: #0f172a;

            font-size: 15px;
            font-weight: 850;

            letter-spacing: -0.015em;
        }


        .intevi-trial-description {
            margin: 0;

            color: #64748b;

            font-size: 13px;
            font-weight: 600;

            line-height: 1.5;
        }


        .intevi-trial-description strong {
            color: #171C63;
            font-weight: 900;
        }


        .intevi-trial-actions {
            display: flex;
            align-items: center;

            gap: 14px;

            flex-shrink: 0;
        }


        .intevi-trial-time {
            text-align: right;
        }


        .intevi-trial-time-number {
            display: block;

            color: #171C63;

            font-size: 22px;
            font-weight: 950;

            line-height: 1;

            letter-spacing: -0.04em;
        }


        .intevi-trial-time-label {
            display: block;

            margin-top: 4px;

            color: #94a3b8;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 0.06em;

            text-transform: uppercase;
        }


        .intevi-trial-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-height: 40px;

            padding: 8px 16px;

            border: 1px solid #171C63;
            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #171C63 0%,
                    #26318f 100%
                );

            color: #ffffff !important;

            font-size: 12px;
            font-weight: 850;

            text-decoration: none !important;

            box-shadow:
                0 8px 18px rgba(23, 28, 99, 0.16);

            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease;
        }


        .intevi-trial-button:hover {
            color: #ffffff !important;

            transform: translateY(-1px);

            box-shadow:
                0 12px 24px rgba(23, 28, 99, 0.23);

            text-decoration: none !important;
        }


        .intevi-trial-progress-wrapper {
            padding:
                0 20px 14px 22px;
        }


        .intevi-trial-progress {
            width: 100%;
            height: 4px;

            overflow: hidden;

            border-radius: 999px;

            background: #e8ecf5;
        }


        .intevi-trial-progress-bar {
            height: 100%;

            border-radius: 999px;

            background:
                linear-gradient(
                    90deg,
                    #171C63 0%,
                    #5263da 100%
                );

            transition:
                width 0.35s ease;
        }


        .intevi-trial-progress-info {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-top: 6px;

            color: #94a3b8;

            font-size: 10px;
            font-weight: 700;
        }


        @media (max-width: 767.98px) {

            .intevi-trial-inner {
                align-items: flex-start;
                flex-direction: column;

                gap: 15px;

                padding:
                    16px 16px 14px 19px;
            }


            .intevi-trial-main {
                width: 100%;

                align-items: flex-start;
            }


            .intevi-trial-icon {
                width: 42px;
                height: 42px;
                min-width: 42px;

                border-radius: 13px;
            }


            .intevi-trial-actions {
                width: 100%;

                justify-content: space-between;

                padding-left: 57px;
            }


            .intevi-trial-time {
                text-align: left;
            }


            .intevi-trial-button {
                min-height: 38px;

                padding:
                    7px 13px;
            }


            .intevi-trial-progress-wrapper {
                padding:
                    0 16px 14px 19px;
            }

        }


        @media (max-width: 480px) {

            .intevi-trial-actions {
                padding-left: 0;
            }


            .intevi-trial-description {
                font-size: 12px;
            }


            .intevi-trial-time-number {
                font-size: 19px;
            }

        }
    </style>


    <div class="intevi-trial-card">

        <div class="intevi-trial-inner">


            {{-- ================================================= --}}
            {{-- INFORMACIÓN                                      --}}
            {{-- ================================================= --}}

            <div class="intevi-trial-main">

                <div class="intevi-trial-icon">

                    <i class="fas fa-gem"></i>

                </div>


                <div class="intevi-trial-content">

                    <div class="intevi-trial-topline">

                        <span class="intevi-trial-badge">
                            Prueba gratuita
                        </span>

                        <h6 class="intevi-trial-title">
                            Está explorando INTEVI
                        </h6>

                    </div>


                    <p class="intevi-trial-description">

                        @if($trialDays > 1)

                            Tiene acceso completo a la plataforma durante
                            <strong>
                                {{ $trialDays }}
                                {{ $trialDays === 1 ? 'día más' : 'días más' }}.
                            </strong>

                            Explore todas las funciones antes de activar su licencia.

                        @elseif($trialHours > 1)

                            Su periodo de prueba finaliza pronto.

                            Le quedan aproximadamente
                            <strong>
                                {{ $trialHours }} horas
                            </strong>
                            de acceso completo.

                        @elseif($trialHours === 1)

                            Su periodo de prueba está por finalizar.

                            Le queda aproximadamente
                            <strong>
                                1 hora
                            </strong>
                            de acceso completo.

                        @else

                            Su periodo de prueba está por finalizar.

                            Active su licencia para continuar utilizando
                            INTEVI sin interrupciones.

                        @endif

                    </p>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- CONTADOR + CTA                                   --}}
            {{-- ================================================= --}}

            <div class="intevi-trial-actions">

                <div class="intevi-trial-time">

                    @if($trialDays > 1)

                        <span class="intevi-trial-time-number">
                            {{ $trialDays }}
                        </span>

                        <span class="intevi-trial-time-label">
                            días restantes
                        </span>

                    @else

                        <span class="intevi-trial-time-number">
                            {{ $trialHours }}
                        </span>

                        <span class="intevi-trial-time-label">
                            horas restantes
                        </span>

                    @endif

                </div>


                <a
                    href="https://intevi.app/"
                    class="intevi-trial-button"
                >

                    <i class="fas fa-arrow-up"></i>

                    Activar licencia

                </a>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- PROGRESO                                             --}}
        {{-- ===================================================== --}}

        <div class="intevi-trial-progress-wrapper">

            <div class="intevi-trial-progress">

                <div
                    class="intevi-trial-progress-bar"
                    style="
                        width:
                        {{ number_format($elapsedPercentage, 2, '.', '') }}%;
                    "
                ></div>

            </div>


            <div class="intevi-trial-progress-info">

                <span>
                    Inicio de prueba
                </span>

                <span>
                    Periodo de 7 días
                </span>

            </div>

        </div>

    </div>

@endif