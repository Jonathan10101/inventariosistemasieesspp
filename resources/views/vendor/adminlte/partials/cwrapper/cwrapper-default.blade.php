@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

{{-- Default Content Wrapper --}}

{{-- Preloader Animation (cwrapper mode) --}}
@if($preloaderHelper->isPreloaderEnabled('cwrapper'))
    @include('adminlte::partials.common.preloader')
@endif


{{-- ========================================================= --}}
{{-- INTEVI - AVISO DE PERIODO DE PRUEBA                      --}}
{{-- ========================================================= --}}

@if(tenant() && tenant()->isOnTrial())

    @php
        $trialDays = tenant()->trialDaysRemaining();
        $trialHours = tenant()->trialHoursRemaining();
    @endphp

    <div
        style="
            width: 100%;
            background: #fff8d7;
            border-bottom: 1px solid #eadb91;
            color: #514300;
            padding: 10px 15px;
        "
    >
        <div class="d-flex align-items-center justify-content-between flex-wrap">

            <div class="d-flex align-items-center">

                <div
                    class="d-flex align-items-center justify-content-center mr-2"
                    style="
                        width: 34px;
                        height: 34px;
                        min-width: 34px;
                        border-radius: 8px;
                        background: rgba(23, 28, 99, 0.10);
                        color: #171C63;
                    "
                >
                    <i class="fas fa-hourglass-half"></i>
                </div>

                <div>

                    <strong style="color: #171C63;">
                        Periodo de prueba:
                    </strong>

                    @if($trialDays > 1)

                        le quedan
                        <strong>{{ $trialDays }} días</strong>
                        para utilizar INTEVI.

                    @elseif($trialHours > 1)

                        le quedan aproximadamente
                        <strong>{{ $trialHours }} horas</strong>
                        para utilizar INTEVI.

                    @elseif($trialHours === 1)

                        le queda aproximadamente
                        <strong>1 hora</strong>
                        para utilizar INTEVI.

                    @else

                        su periodo de prueba está por finalizar.

                    @endif

                </div>

            </div>

            <a
                href="https://intevi.app/"
                class="btn btn-sm text-white mt-2 mt-md-0"
                style="
                    background-color: #171C63;
                    border-color: #171C63;
                    border-radius: 8px;
                    font-weight: 700;
                "
            >
                <i class="fas fa-unlock-alt mr-1"></i>
                Activar licencia
            </a>

        </div>
    </div>

@endif

{{-- ========================================================= --}}
{{-- FIN AVISO PERIODO DE PRUEBA                              --}}
{{-- ========================================================= --}}


{{-- Content Header --}}
@hasSection('content_header')
    <div class="content-header">
        <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
            @yield('content_header')
        </div>
    </div>
@endif

{{-- Main Content --}}
<div class="content">
    <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
        @stack('content')
        @yield('content')
    </div>
</div>