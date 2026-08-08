@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid')
@endif

{{-- Default Content Wrapper --}}

{{-- Preloader Animation (cwrapper mode) --}}
@if($preloaderHelper->isPreloaderEnabled('cwrapper'))
    @include('adminlte::partials.common.preloader')
@endif


{{-- ========================================================= --}}
{{-- INTEVI - PERIODO DE PRUEBA                               --}}
{{-- ========================================================= --}}
@if (tenant() && tenant()->isOnTrial())

    @php
        $trialDays = tenant()->trialDaysRemaining();
        $trialHours = tenant()->trialHoursRemaining();
    @endphp

    <div
        class="intevi-trial-banner"
        style="
            width: 100%;
            background: linear-gradient(
                90deg,
                #fff8d7 0%,
                #fffdf3 100%
            );
            border-bottom: 1px solid #eadb91;
            color: #514300;
            padding: 10px 0;
        "
    >
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">

            <div class="d-flex align-items-center justify-content-between flex-wrap">

                {{-- Información del periodo de prueba --}}
                <div class="d-flex align-items-center">

                    <div
                        class="d-flex align-items-center justify-content-center mr-3"
                        style="
                            width: 36px;
                            height: 36px;
                            min-width: 36px;
                            border-radius: 10px;
                            background: rgba(23, 28, 99, 0.10);
                            color: #171C63;
                            font-size: 15px;
                        "
                    >
                        <i class="fas fa-hourglass-half"></i>
                    </div>

                    <div
                        style="
                            font-size: 14px;
                            line-height: 1.4;
                        "
                    >
                        <strong
                            style="
                                color: #171C63;
                                font-weight: 800;
                            "
                        >
                            Periodo de prueba:
                        </strong>

                        @if ($trialDays > 1)

                            <span>
                                le quedan
                                <strong>
                                    {{ $trialDays }} días
                                </strong>
                                para utilizar INTEVI.
                            </span>

                        @elseif ($trialHours > 1)

                            <span>
                                le quedan aproximadamente
                                <strong>
                                    {{ $trialHours }} horas
                                </strong>
                                para utilizar INTEVI.
                            </span>

                        @elseif ($trialHours === 1)

                            <span>
                                le queda aproximadamente
                                <strong>
                                    1 hora
                                </strong>
                                para utilizar INTEVI.
                            </span>

                        @else

                            <span>
                                su periodo de prueba está por finalizar.
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Botón de activación --}}
                <div class="mt-2 mt-md-0">

                    <a
                        href="https://intevi.app/"
                        class="btn btn-sm text-white"
                        style="
                            background: #171C63;
                            border-color: #171C63;
                            border-radius: 9px;
                            padding: 7px 14px;
                            font-weight: 700;
                            box-shadow: 0 5px 12px rgba(23, 28, 99, 0.15);
                        "
                    >
                        <i class="fas fa-unlock-alt mr-1"></i>
                        Activar licencia
                    </a>

                </div>

            </div>

        </div>
    </div>

@endif
{{-- ========================================================= --}}
{{-- FIN PERIODO DE PRUEBA                                    --}}
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