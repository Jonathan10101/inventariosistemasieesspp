<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "xsj75iy4ae");
    </script>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
            @break

            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
            @break

            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
            @break

            @default
                <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

                @if(config('adminlte.google_fonts.allowed', true))
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                @endif
        @endswitch
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')


    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

    {{-- INTEVI ADMINLTE THEME --}}
<style>
    :root {
        --intevi-primary: #171C63;
        --intevi-primary-2: #26318f;
        --intevi-bg: #f5f7fb;
        --intevi-text: #0f172a;
        --intevi-muted: #64748b;
        --intevi-border: #e2e8f0;
    }

    body {
        background: var(--intevi-bg) !important;
        color: var(--intevi-text) !important;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
    }

    .content-wrapper {
        background:
            radial-gradient(circle at top left, rgba(23, 28, 99, 0.08), transparent 32%),
            linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%) !important;
    }

    .main-header.navbar {
        min-height: 64px;
        background: rgba(255, 255, 255, 0.94) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.95) !important;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.05);
        backdrop-filter: blur(12px);
    }

    .main-header .nav-link {
        color: #334155 !important;
        font-weight: 800;
    }

    .main-header .nav-link:hover {
        color: var(--intevi-primary) !important;
    }

    .brand-link {
        min-height: 64px;
        background: #ffffff !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.95) !important;
        color: var(--intevi-primary) !important;
        font-weight: 950 !important;
    }

    .brand-link .brand-text {
        color: var(--intevi-primary) !important;
        font-size: 18px;
        font-weight: 950 !important;
        letter-spacing: -0.03em;
    }

    .brand-image {
        max-height: 38px !important;
        object-fit: contain;
    }

    .main-sidebar {
        background: #ffffff !important;
        border-right: 1px solid rgba(226, 232, 240, 0.95);
        box-shadow: 10px 0 30px rgba(15, 23, 42, 0.04) !important;
    }

    .sidebar {
        padding-top: 14px;
    }

    .user-panel {
        margin: 0 10px 14px !important;
        padding: 13px !important;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(23, 28, 99, 0.08), rgba(37, 99, 235, 0.05));
        border: 1px solid rgba(226, 232, 240, 0.95);
    }

    .user-panel .info a {
        color: var(--intevi-text) !important;
        font-weight: 900;
    }

    .nav-sidebar {
        padding: 0 10px;
    }

    .nav-sidebar .nav-item {
        margin-bottom: 5px;
    }

    .nav-sidebar .nav-link {
        min-height: 44px;
        border-radius: 14px !important;
        color: #475569 !important;
        font-size: 14px;
        font-weight: 800;
        transition: all 0.16s ease;
    }

    .nav-sidebar .nav-link i {
        color: #64748b !important;
        transition: all 0.16s ease;
    }

    .nav-sidebar .nav-link:hover {
        background: rgba(23, 28, 99, 0.07) !important;
        color: var(--intevi-primary) !important;
        transform: translateX(2px);
    }

    .nav-sidebar .nav-link:hover i {
        color: var(--intevi-primary) !important;
    }

    .nav-sidebar .nav-link.active {
        background: linear-gradient(135deg, var(--intevi-primary), var(--intevi-primary-2)) !important;
        color: #ffffff !important;
        box-shadow: 0 12px 24px rgba(23, 28, 99, 0.22);
    }

    .nav-sidebar .nav-link.active i {
        color: #ffffff !important;
    }

    .nav-treeview {
        padding-left: 7px;
    }

    .nav-treeview .nav-link {
        min-height: 38px;
        font-size: 13px;
        border-radius: 12px !important;
    }

    .nav-treeview .nav-link.active {
        background: rgba(23, 28, 99, 0.10) !important;
        color: var(--intevi-primary) !important;
        box-shadow: none !important;
    }

    .nav-treeview .nav-link.active i {
        color: var(--intevi-primary) !important;
    }

    .content-header {
        padding: 18px 1rem 0.5rem;
    }

    .content-header h1 {
        color: var(--intevi-text) !important;
        font-weight: 950 !important;
        letter-spacing: -0.04em;
    }

    .card {
        border: 1px solid rgba(226, 232, 240, 0.95) !important;
        border-radius: 22px !important;
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06) !important;
        overflow: hidden;
    }

    .card-header {
        background: #ffffff !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.95) !important;
        padding: 17px 20px;
    }

    .card-title {
        color: var(--intevi-text) !important;
        font-weight: 950 !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--intevi-primary), var(--intevi-primary-2)) !important;
        border-color: var(--intevi-primary) !important;
        color: #ffffff !important;
        border-radius: 13px !important;
        font-weight: 900 !important;
        box-shadow: 0 12px 24px rgba(23, 28, 99, 0.20);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(23, 28, 99, 0.28);
    }

    .table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        border-bottom: 1px solid var(--intevi-border) !important;
        font-size: 12px;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .table td {
        vertical-align: middle;
        border-top: 1px solid #edf2f7 !important;
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .form-control {
        border-radius: 13px !important;
        border: 1px solid #dbe3ef !important;
        background: #f8fafc !important;
        color: #0f172a !important;
        font-weight: 700;
    }

    .form-control:focus {
        background: #ffffff !important;
        border-color: rgba(23, 28, 99, 0.48) !important;
        box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09) !important;
    }

    .modal-content {
        border: none !important;
        border-radius: 22px !important;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.22) !important;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--intevi-primary), var(--intevi-primary-2)) !important;
        color: #ffffff !important;
        border-bottom: none !important;
    }

    .modal-title {
        font-weight: 950 !important;
    }

    .modal-header .close {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .main-footer {
        background: #ffffff !important;
        border-top: 1px solid rgba(226, 232, 240, 0.95) !important;
        color: #64748b !important;
        font-size: 13px;
        font-weight: 700;
    }

    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* =========================================================
    INTEVI BRAND / LOGO PROFESIONAL
    ========================================================= */

    .brand-link {
        height: 74px !important;
        min-height: 74px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 16px !important;
        background:
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.95) !important;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.045) !important;
        text-decoration: none !important;
    }

    .brand-link:hover {
        background:
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
        text-decoration: none !important;
    }

    .brand-link .brand-text {
        width: 100% !important;
        margin-left: 0 !important;
        color: inherit !important;
    }

    .intevi-brand {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .intevi-brand-mark {
        width: 44px;
        height: 44px;
        border-radius: 16px;
        background:
            radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.35), transparent 35%),
            linear-gradient(135deg, #171C63 0%, #26318f 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: 0 14px 28px rgba(23, 28, 99, 0.24);
        flex-shrink: 0;
    }

    .intevi-brand-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        line-height: 1.05;
    }

    .intevi-brand-text strong {
        color: #0f172a;
        font-size: 19px;
        font-weight: 950;
        letter-spacing: 0.08em;
    }

    .intevi-brand-text span {
        margin-top: 4px;
        color: #64748b;
        font-size: 11px;
        font-weight: 850;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* Cuando el sidebar se contrae */
    .sidebar-collapse .brand-link {
        justify-content: center !important;
        padding: 0 !important;
    }

    .sidebar-collapse .intevi-brand {
        justify-content: center;
    }

    .sidebar-collapse .intevi-brand-text {
        display: none !important;
    }

    .sidebar-collapse .intevi-brand-mark {
        width: 42px;
        height: 42px;
        border-radius: 15px;
    }

    @media (max-width: 768px) {
        .main-header.navbar {
            min-height: 58px;
        }

        .brand-link {
            min-height: 58px;
        }

        .content-header h1 {
            font-size: 23px;
        }
    }
</style>

</head>
<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
            @break

            @case('vite')
            @case('vite_js_only')
            @break

            @default
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
                <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
