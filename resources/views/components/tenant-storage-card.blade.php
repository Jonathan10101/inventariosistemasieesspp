@props(['storage'])

@php
    $percentage = min(100, max(0, (float) $storage['percentage']));

    $statusClass = 'intevi-storage-normal';
    $statusText = 'Espacio disponible';

    if ($storage['is_critical']) {
        $statusClass = 'intevi-storage-critical';
        $statusText = 'Espacio casi agotado';
    } elseif ($storage['is_warning']) {
        $statusClass = 'intevi-storage-warning';
        $statusText = 'Espacio limitado';
    }

    if ($storage['is_full']) {
        $statusClass = 'intevi-storage-full';
        $statusText = 'Almacenamiento lleno';
    }
@endphp

<div class="intevi-storage-card">

    <div class="intevi-storage-header">
        <div>
            <span class="intevi-storage-kicker">
                ALMACENAMIENTO INSTITUCIONAL
            </span>

            <h3>Espacio de la organización</h3>

            <p>
                Consulta el almacenamiento utilizado por la base de datos.
            </p>
        </div>

        <div class="intevi-storage-icon" aria-hidden="true">
            <i class="fas fa-database"></i>
        </div>
    </div>

    <div class="intevi-storage-total">
        <div>
            <span>Disponible</span>

            <strong>
                {{ $storage['remaining_formatted'] }}
            </strong>
        </div>

        <div class="intevi-storage-percentage">
            {{ number_format($percentage, 1) }}%
            <small>utilizado</small>
        </div>
    </div>

    <div
        class="intevi-storage-progress"
        role="progressbar"
        aria-valuenow="{{ $percentage }}"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        <span
            class="{{ $statusClass }}"
            style="width: {{ $percentage }}%;"
        ></span>
    </div>

    <div class="intevi-storage-details">
        <div>
            <span>Utilizado</span>
            <strong>{{ $storage['used_formatted'] }}</strong>
        </div>

        <div>
            <span>Capacidad total</span>
            <strong>{{ $storage['limit_formatted'] }}</strong>
        </div>

        <div>
            <span>Estado</span>
            <strong class="{{ $statusClass }}">
                {{ $statusText }}
            </strong>
        </div>
    </div>

    @if ($storage['is_full'])
        <div class="intevi-storage-alert intevi-storage-alert-danger">
            <i class="fas fa-exclamation-circle"></i>

            <span>
                El almacenamiento está lleno. No se podrán registrar nuevos
                datos hasta liberar espacio.
            </span>
        </div>
    @elseif ($storage['is_critical'])
        <div class="intevi-storage-alert intevi-storage-alert-danger">
            <i class="fas fa-exclamation-triangle"></i>

            <span>
                Queda muy poco almacenamiento. Recomendamos liberar espacio.
            </span>
        </div>
    @elseif ($storage['is_warning'])
        <div class="intevi-storage-alert intevi-storage-alert-warning">
            <i class="fas fa-info-circle"></i>

            <span>
                Ya utilizaste más del 80% del almacenamiento disponible.
            </span>
        </div>
    @endif

</div>

@once
    <style>
        .intevi-storage-card {
            width: 100%;
            padding: 24px;
            margin-bottom: 24px;
            background: #ffffff;
            border: 1px solid #e7e9f2;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(23, 28, 99, 0.07);
        }

        .intevi-storage-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .intevi-storage-kicker {
            display: block;
            margin-bottom: 6px;
            color: #171c63;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .intevi-storage-header h3 {
            margin: 0 0 5px;
            color: #171c63;
            font-size: 21px;
            font-weight: 800;
        }

        .intevi-storage-header p {
            margin: 0;
            color: #71758a;
            font-size: 14px;
        }

        .intevi-storage-icon {
            display: flex;
            width: 48px;
            min-width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            background: #171c63;
            border-radius: 14px;
            font-size: 19px;
        }

        .intevi-storage-total {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 14px;
        }

        .intevi-storage-total span {
            display: block;
            margin-bottom: 3px;
            color: #797d91;
            font-size: 13px;
        }

        .intevi-storage-total strong {
            color: #171c63;
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
        }

        .intevi-storage-percentage {
            color: #171c63;
            font-size: 20px;
            font-weight: 800;
            text-align: right;
        }

        .intevi-storage-percentage small {
            display: block;
            color: #85899c;
            font-size: 11px;
            font-weight: 600;
        }

        .intevi-storage-progress {
            position: relative;
            width: 100%;
            height: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            background: #eceef5;
            border-radius: 999px;
        }

        .intevi-storage-progress span {
            display: block;
            height: 100%;
            border-radius: 999px;
            transition: width 0.35s ease;
        }

        .intevi-storage-progress .intevi-storage-normal {
            background: #171c63;
        }

        .intevi-storage-progress .intevi-storage-warning {
            background: #d98d00;
        }

        .intevi-storage-progress .intevi-storage-critical,
        .intevi-storage-progress .intevi-storage-full {
            background: #c62828;
        }

        .intevi-storage-details {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .intevi-storage-details > div {
            padding: 14px;
            background: #f7f8fc;
            border: 1px solid #eceef5;
            border-radius: 12px;
        }

        .intevi-storage-details span {
            display: block;
            margin-bottom: 4px;
            color: #85899c;
            font-size: 12px;
        }

        .intevi-storage-details strong {
            color: #25283a;
            font-size: 14px;
            font-weight: 800;
        }

        .intevi-storage-details strong.intevi-storage-warning {
            color: #b57400;
        }

        .intevi-storage-details strong.intevi-storage-critical,
        .intevi-storage-details strong.intevi-storage-full {
            color: #c62828;
        }

        .intevi-storage-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            margin-top: 16px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 600;
        }

        .intevi-storage-alert-warning {
            color: #805600;
            background: #fff7e6;
            border: 1px solid #ffe0a3;
        }

        .intevi-storage-alert-danger {
            color: #9e2020;
            background: #fff0f0;
            border: 1px solid #ffcaca;
        }

        @media (max-width: 767px) {
            .intevi-storage-card {
                padding: 18px;
            }

            .intevi-storage-details {
                grid-template-columns: 1fr;
            }

            .intevi-storage-total strong {
                font-size: 25px;
            }

            .intevi-storage-percentage {
                font-size: 17px;
            }
        }
    </style>
@endonce