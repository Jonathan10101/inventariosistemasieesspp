@if(tenant() && tenant()->isOnTrial())

    @php
        $trialDays = tenant()->trialDaysRemaining();
        $trialHours = tenant()->trialHoursRemaining();
    @endphp

    <style>
        .intevi-trial {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            margin-bottom: 18px;
            padding: 12px 14px 12px 16px;

            background: #ffffff;
            border: 1px solid #e4e8f0;
            border-left: 4px solid #171C63;
            border-radius: 10px;

            box-shadow:
                0 3px 10px rgba(15, 23, 42, 0.035);
        }

        .intevi-trial-left {
            display: flex;
            align-items: center;
            min-width: 0;
            gap: 12px;
        }

        .intevi-trial-icon {
            width: 34px;
            height: 34px;
            min-width: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #f1f3fb;
            color: #171C63;

            font-size: 14px;
        }

        .intevi-trial-copy {
            min-width: 0;
        }

        .intevi-trial-title {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;

            margin-bottom: 2px;

            font-size: 13px;
            font-weight: 800;
            color: #172033;
        }

        .intevi-trial-label {
            display: inline-flex;
            align-items: center;

            padding: 2px 7px;

            border-radius: 5px;

            background: #eef0fa;
            color: #171C63;

            font-size: 9px;
            font-weight: 900;

            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .intevi-trial-text {
            margin: 0;

            color: #6b7280;

            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
        }

        .intevi-trial-text strong {
            color: #171C63;
            font-weight: 800;
        }

        .intevi-trial-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .intevi-trial-counter {
            display: flex;
            align-items: baseline;
            gap: 4px;

            white-space: nowrap;
        }

        .intevi-trial-counter-number {
            color: #171C63;

            font-size: 18px;
            font-weight: 900;
            line-height: 1;
        }

        .intevi-trial-counter-label {
            color: #8a94a6;

            font-size: 10px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .intevi-trial-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            height: 34px;
            padding: 0 13px;

            border: 1px solid #171C63;
            border-radius: 8px;

            background: #171C63;

            color: #ffffff !important;

            font-size: 11px;
            font-weight: 800;

            text-decoration: none !important;

            transition: all .15s ease;
        }

        .intevi-trial-action:hover {
            background: #20277e;
            border-color: #20277e;
            color: #ffffff !important;
            text-decoration: none !important;
        }

        @media (max-width: 767.98px) {
            .intevi-trial {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            .intevi-trial-right {
                width: 100%;
                justify-content: space-between;
                padding-left: 46px;
            }
        }

        @media (max-width: 480px) {
            .intevi-trial-right {
                padding-left: 0;
            }

            .intevi-trial-icon {
                display: none;
            }

            .intevi-trial-action {
                padding: 0 10px;
            }
        }
    </style>


    <div class="intevi-trial">

        <div class="intevi-trial-left">

            <div class="intevi-trial-icon">
                <i class="far fa-clock"></i>
            </div>

            <div class="intevi-trial-copy">

                <div class="intevi-trial-title">

                    <span class="intevi-trial-label">
                        Prueba
                    </span>

                    Periodo de evaluación de INTEVI

                </div>

                <p class="intevi-trial-text">

                    @if($trialDays > 1)

                        Acceso completo habilitado durante
                        <strong>{{ $trialDays }} días más.</strong>

                    @elseif($trialHours > 1)

                        Su periodo de prueba finaliza en aproximadamente
                        <strong>{{ $trialHours }} horas.</strong>

                    @elseif($trialHours === 1)

                        Su periodo de prueba finaliza en aproximadamente
                        <strong>1 hora.</strong>

                    @else

                        Su periodo de prueba está por finalizar.

                    @endif

                </p>

            </div>

        </div>


        <div class="intevi-trial-right">

            <div class="intevi-trial-counter">

                @if($trialDays > 1)

                    <span class="intevi-trial-counter-number">
                        {{ $trialDays }}
                    </span>

                    <span class="intevi-trial-counter-label">
                        días
                    </span>

                @else

                    <span class="intevi-trial-counter-number">
                        {{ $trialHours }}
                    </span>

                    <span class="intevi-trial-counter-label">
                        horas
                    </span>

                @endif

            </div>


            <a
                href="https://intevi.app/"
                class="intevi-trial-action"
            >
                Activar licencia

                <i class="fas fa-chevron-right" style="font-size: 8px;"></i>
            </a>

        </div>

    </div>

@endif