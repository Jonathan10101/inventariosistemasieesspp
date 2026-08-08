@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
        {{-- Preloader Animation (fullscreen mode) --}}
        @if($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop
        <div class="content-wrapper">

            {{-- INTEVI - AVISO DE PERIODO DE PRUEBA --}}
            @if (tenant() && tenant()->isOnTrial())

                @php
                    $trialDays = tenant()->trialDaysRemaining();
                    $trialHours = tenant()->trialHoursRemaining();
                @endphp

                <div
                    class="alert alert-warning rounded-0 border-0 mb-0"
                    style="
                        background: #fff7d6;
                        border-bottom: 1px solid #f1d675 !important;
                        color: #5f4b00;
                    "
                >
                    <div
                        class="container-fluid d-flex align-items-center justify-content-between flex-wrap"
                    >

                        <div class="py-1">

                            <i class="fas fa-hourglass-half mr-2"></i>

                            <strong>
                                Periodo de prueba:
                            </strong>

                            @if ($trialDays > 1)

                                le quedan
                                <strong>{{ $trialDays }} días</strong>
                                para utilizar INTEVI.

                            @elseif ($trialHours > 0)

                                le quedan aproximadamente
                                <strong>{{ $trialHours }} horas</strong>.

                            @else

                                su periodo de prueba está por finalizar.

                            @endif

                        </div>

                        <a
                            href="https://intevi.app/"
                            class="btn btn-sm text-white mt-2 mt-md-0"
                            style="
                                background-color: #171C63;
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


            {{-- Content Header --}}
            <div class="content-header">
                @yield('content_header')
            </div>


            {{-- Main Content --}}
            <div class="content">
                @yield('content')
            </div>

        </div>


@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
