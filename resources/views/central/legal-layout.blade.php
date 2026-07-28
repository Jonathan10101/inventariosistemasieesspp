<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <meta name="theme-color" content="#171C63">
    <title>@yield('title') | INTEVI</title>
    <link rel="stylesheet" href="{{ asset('css/intevi-landing.css') }}">
</head>
<body>
<header class="site-header">
    <div class="container navbar">
        <a href="{{ url('/') }}" class="brand" aria-label="Volver a INTEVI">
            <img src="{{ asset('images/intevi logo.png') }}" alt="INTEVI" class="brand-logo" width="48" height="48">
            <span class="brand-text"><span class="brand-name">INTEVI</span><span class="brand-description">Inventario y resguardo institucional</span></span>
        </a>
        <a class="button button-outline nav-cta" href="{{ url('/') }}">Volver a la landing</a>
    </div>
</header>

<main class="legal-page">
    <div class="container">
        <article class="legal-card">
            @yield('content')
        </article>
    </div>
</main>
</body>
</html>
