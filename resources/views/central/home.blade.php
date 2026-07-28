<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>INTEVI | Control de inventario y resguardo institucional</title>

    <meta
        name="description"
        content="INTEVI permite saber qué bienes existen, dónde están, quién los tiene asignados, qué evidencia respalda cada resguardo y qué movimientos se han realizado."
    >

    <meta
        name="theme-color"
        content="#171C63"
    >

    <meta
        property="og:title"
        content="INTEVI | Gestión inteligente de bienes institucionales"
    >

    <meta
        property="og:description"
        content="Controla inventarios, responsables, ubicaciones y resguardos desde una sola plataforma."
    >

    <meta
        property="og:type"
        content="website"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    @php
        /*
        |--------------------------------------------------------------------------
        | Datos comerciales
        |--------------------------------------------------------------------------
        */
        $contactEmail = 'contacto@intevi.app';

        $demoSubject = rawurlencode(
            'Solicitud de demostración de INTEVI'
        );

        $demoBody = rawurlencode(
            "Hola, me interesa solicitar una demostración de INTEVI.\n\n" .
            "Institución:\n" .
            "Nombre:\n" .
            "Cargo:\n" .
            "Teléfono:\n" .
            "Número aproximado de bienes:\n"
        );

        $demoMailto =
            "mailto:{$contactEmail}" .
            "?subject={$demoSubject}" .
            "&body={$demoBody}";
    @endphp

    <style>
        :root {
            --primary: #171c63;
            --primary-dark: #101447;
            --primary-soft: #eef0ff;
            --accent: #d5ad63;
            --accent-dark: #ae8540;
            --accent-soft: #f8f0df;
            --ink: #171923;
            --ink-soft: #555968;
            --muted: #767a87;
            --surface: #ffffff;
            --surface-soft: #f6f7f9;
            --surface-warm: #f4f1eb;
            --border: #e4e5e9;
            --success: #14745a;
            --shadow-sm: 0 12px 35px rgba(18, 24, 61, 0.07);
            --shadow-md: 0 24px 80px rgba(18, 24, 61, 0.12);
            --container: 1180px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--surface);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            overflow-x: hidden;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        body.menu-open {
            overflow: hidden;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img,
        svg {
            display: block;
            max-width: 100%;
        }

        .container {
            width: min(calc(100% - 40px), var(--container));
            margin-inline: auto;
        }

        .section {
            padding: 112px 0;
        }

        .section-soft {
            background: var(--surface-soft);
        }

        .section-dark {
            background: var(--primary-dark);
            color: white;
        }

        .eyebrow {
            align-items: center;
            color: var(--primary);
            display: inline-flex;
            font-size: 12px;
            font-weight: 700;
            gap: 9px;
            letter-spacing: 0.15em;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .eyebrow::before {
            background: var(--accent);
            content: "";
            height: 2px;
            width: 25px;
        }

        .section-dark .eyebrow {
            color: #cdd1ff;
        }

        .heading {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(34px, 4vw, 56px);
            font-weight: 800;
            letter-spacing: -0.045em;
            line-height: 1.08;
        }

        .heading-medium {
            font-size: clamp(30px, 3.2vw, 46px);
        }

        .section-copy {
            color: var(--ink-soft);
            font-size: 18px;
            line-height: 1.75;
            margin-top: 22px;
            max-width: 650px;
        }

        .section-dark .section-copy {
            color: rgba(255, 255, 255, 0.72);
        }

        .section-heading {
            align-items: flex-end;
            display: flex;
            gap: 40px;
            justify-content: space-between;
            margin-bottom: 58px;
        }

        .section-heading > div:first-child {
            max-width: 730px;
        }

        .section-heading .section-copy {
            margin-top: 0;
            max-width: 410px;
        }

        .button {
            align-items: center;
            border: 1px solid transparent;
            cursor: pointer;
            display: inline-flex;
            font-size: 14px;
            font-weight: 700;
            gap: 10px;
            justify-content: center;
            min-height: 52px;
            padding: 0 24px;
            transition:
                transform 180ms ease,
                background-color 180ms ease,
                border-color 180ms ease,
                color 180ms ease,
                box-shadow 180ms ease;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .button-primary {
            background: var(--primary);
            box-shadow: 0 14px 30px rgba(23, 28, 99, 0.2);
            color: white;
        }

        .button-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 18px 38px rgba(23, 28, 99, 0.25);
        }

        .button-light {
            background: white;
            color: var(--primary);
        }

        .button-light:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.14);
        }

        .button-outline {
            border-color: var(--border);
            color: var(--ink);
        }

        .button-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .button svg {
            height: 18px;
            width: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        .site-header {
            background: rgba(255, 255, 255, 0.91);
            border-bottom: 1px solid rgba(228, 229, 233, 0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 100;
        }

        .navbar {
            align-items: center;
            display: flex;
            height: 82px;
            justify-content: space-between;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo {
            width: 52px;
            height: 52px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .brand-name {
            display: block;
            color: #171c63;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .brand-description {
            display: block;
            margin-top: 4px;
            color: #64748b;
            font-size: 0.76rem;
            font-weight: 500;
        }

        .nav-area {
            align-items: center;
            display: flex;
            gap: 36px;
        }

        .nav-links {
            align-items: center;
            display: flex;
            gap: 31px;
            list-style: none;
        }

        .nav-link {
            color: #464958;
            font-size: 14px;
            font-weight: 600;
            position: relative;
        }

        .nav-link::after {
            background: var(--primary);
            bottom: -8px;
            content: "";
            height: 1px;
            left: 0;
            position: absolute;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 180ms ease;
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-cta {
            min-height: 44px;
            padding-inline: 20px;
        }

        .menu-button {
            align-items: center;
            background: transparent;
            border: 0;
            cursor: pointer;
            display: none;
            height: 44px;
            justify-content: center;
            width: 44px;
        }

        .menu-button span,
        .menu-button span::before,
        .menu-button span::after {
            background: var(--primary);
            content: "";
            display: block;
            height: 2px;
            position: relative;
            transition: 180ms ease;
            width: 24px;
        }

        .menu-button span::before {
            position: absolute;
            top: -7px;
        }

        .menu-button span::after {
            position: absolute;
            top: 7px;
        }

        .menu-button[aria-expanded="true"] span {
            background: transparent;
        }

        .menu-button[aria-expanded="true"] span::before {
            top: 0;
            transform: rotate(45deg);
        }

        .menu-button[aria-expanded="true"] span::after {
            top: 0;
            transform: rotate(-45deg);
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .hero {
            background:
                radial-gradient(
                    circle at 82% 25%,
                    rgba(213, 173, 99, 0.14),
                    transparent 25%
                ),
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #f7f7f9 100%
                );
            min-height: 860px;
            overflow: hidden;
            padding: 180px 0 105px;
            position: relative;
        }

        .hero::before {
            border: 1px solid rgba(23, 28, 99, 0.06);
            content: "";
            height: 560px;
            position: absolute;
            right: -240px;
            top: 115px;
            transform: rotate(14deg);
            width: 560px;
        }

        .hero-grid {
            align-items: center;
            display: grid;
            gap: 52px;
            grid-template-columns: minmax(390px, 0.8fr) minmax(600px, 1.2fr);
        }

        .hero-copy {
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            align-items: center;
            background: white;
            border: 1px solid var(--border);
            color: var(--primary);
            display: inline-flex;
            font-size: 12px;
            font-weight: 700;
            gap: 9px;
            letter-spacing: 0.07em;
            margin-bottom: 28px;
            padding: 9px 13px;
            text-transform: uppercase;
        }

        .hero-tag-dot {
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(20, 116, 90, 0.1);
            height: 7px;
            width: 7px;
        }

        .hero-title {
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            font-size: clamp(45px, 5.5vw, 73px);
            font-weight: 800;
            letter-spacing: -0.058em;
            line-height: 0.99;
            max-width: 690px;
        }

        .hero-title span {
            color: var(--primary);
        }

        .hero-description {
            color: var(--ink-soft);
            font-size: 19px;
            line-height: 1.72;
            margin-top: 28px;
            max-width: 605px;
        }

        .hero-actions {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 38px;
        }

        .hero-note {
            align-items: center;
            color: var(--muted);
            display: flex;
            font-size: 13px;
            gap: 8px;
            margin-top: 22px;
        }

        .hero-note svg {
            color: var(--success);
            height: 17px;
            width: 17px;
        }

        /*
        |--------------------------------------------------------------------------
        | Vista real del sistema
        |--------------------------------------------------------------------------
        */

        .product-preview {
            filter: drop-shadow(0 35px 70px rgba(22, 27, 67, 0.16));
            position: relative;
            width: 108%;
            z-index: 2;
        }

        .preview-label {
            align-items: center;
            background: var(--primary);
            box-shadow: 0 12px 30px rgba(23, 28, 99, 0.22);
            color: white;
            display: flex;
            font-size: 10px;
            font-weight: 700;
            gap: 8px;
            left: -18px;
            letter-spacing: 0.1em;
            padding: 11px 16px;
            position: absolute;
            text-transform: uppercase;
            top: 38px;
            z-index: 5;
        }

        .preview-label::before {
            background: var(--accent);
            border-radius: 50%;
            content: "";
            height: 6px;
            width: 6px;
        }

        .system-browser {
            background: #ffffff;
            border: 1px solid rgba(23, 28, 99, 0.12);
            box-shadow:
                0 40px 90px rgba(22, 27, 67, 0.18),
                0 12px 30px rgba(22, 27, 67, 0.08);
            overflow: hidden;
            position: relative;
        }

        .system-browser::after {
            border: 1px solid rgba(255, 255, 255, 0.48);
            content: "";
            inset: 0;
            pointer-events: none;
            position: absolute;
            z-index: 3;
        }

        .system-browser-bar {
            align-items: center;
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fb 100%);
            border-bottom: 1px solid #e6e8ee;
            display: grid;
            gap: 18px;
            grid-template-columns: auto minmax(0, 1fr) auto;
            min-height: 52px;
            padding: 0 17px;
        }

        .system-browser-controls {
            align-items: center;
            display: flex;
            gap: 7px;
        }

        .system-browser-controls span {
            background: #d9dce4;
            border-radius: 50%;
            display: block;
            height: 8px;
            width: 8px;
        }

        .system-browser-controls span:nth-child(1) {
            background: #c9cbd3;
        }

        .system-browser-controls span:nth-child(2) {
            background: #d8d9df;
        }

        .system-browser-controls span:nth-child(3) {
            background: #e3e4e8;
        }

        .system-browser-address {
            align-items: center;
            background: #f0f2f7;
            color: #73798a;
            display: flex;
            font-size: 10px;
            gap: 7px;
            justify-self: center;
            max-width: 340px;
            min-height: 29px;
            overflow: hidden;
            padding: 0 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        .system-browser-address svg {
            color: #687083;
            flex: 0 0 auto;
            height: 12px;
            width: 12px;
        }

        .system-browser-menu {
            align-items: center;
            display: flex;
            gap: 3px;
        }

        .system-browser-menu span {
            background: #7d8290;
            border-radius: 50%;
            display: block;
            height: 3px;
            width: 3px;
        }

        .system-screen {
            aspect-ratio: 1915 / 920;
            background: #edf0f5;
            overflow: hidden;
            position: relative;
        }

        .system-screen::before {
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.05),
                transparent 18%
            );
            content: "";
            inset: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }

        .system-screen img {
            display: block;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition:
                transform 500ms ease,
                filter 500ms ease;
            width: 100%;
        }

        .system-browser:hover .system-screen img {
            filter: saturate(1.03) contrast(1.01);
            transform: scale(1.008);
        }

        .product-floating-card {
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid var(--border);
            bottom: -28px;
            box-shadow: 0 20px 50px rgba(22, 27, 67, 0.14);
            padding: 17px 20px;
            position: absolute;
            right: -20px;
            width: 215px;
            z-index: 5;
        }

        .floating-card-label {
            color: var(--muted);
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .floating-card-value {
            align-items: center;
            color: var(--success);
            display: flex;
            font-size: 13px;
            font-weight: 800;
            gap: 7px;
            margin-top: 6px;
        }

        .floating-card-value::before {
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(20, 116, 90, 0.1);
            content: "";
            height: 7px;
            width: 7px;
        }

        /*
        |--------------------------------------------------------------------------
        | Audience strip
        |--------------------------------------------------------------------------
        */

        .audience-strip {
            background: white;
            border-bottom: 1px solid var(--border);
            border-top: 1px solid var(--border);
        }

        .audience-content {
            align-items: center;
            display: flex;
            gap: 45px;
            justify-content: space-between;
            min-height: 118px;
        }

        .audience-title {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .audience-list {
            align-items: center;
            display: flex;
            flex: 1;
            gap: 45px;
            justify-content: flex-end;
        }

        .audience-item {
            align-items: center;
            color: #444756;
            display: inline-flex;
            font-size: 14px;
            font-weight: 700;
            gap: 10px;
        }

        .audience-item svg {
            color: var(--primary);
            height: 21px;
            width: 21px;
        }

        /*
        |--------------------------------------------------------------------------
        | Problem
        |--------------------------------------------------------------------------
        */

        .problem-layout {
            align-items: center;
            display: grid;
            gap: 90px;
            grid-template-columns: 0.9fr 1.1fr;
        }

        .problem-statement {
            background: var(--surface-warm);
            padding: 55px;
            position: relative;
        }

        .problem-statement::before {
            background: var(--accent);
            content: "";
            height: 4px;
            left: 55px;
            position: absolute;
            top: 0;
            width: 85px;
        }

        .problem-quote {
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            font-size: clamp(27px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.035em;
            line-height: 1.25;
        }

        .problem-quote span {
            color: var(--primary);
        }

        .problem-caption {
            color: var(--muted);
            font-size: 14px;
            margin-top: 28px;
        }

        .problem-list {
            display: grid;
            gap: 0;
            margin-top: 34px;
        }

        .problem-item {
            align-items: flex-start;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: 18px;
            padding: 21px 0;
        }

        .problem-item:first-child {
            border-top: 1px solid var(--border);
        }

        .problem-number {
            color: var(--accent);
            flex: 0 0 auto;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 800;
            padding-top: 3px;
        }

        .problem-item strong {
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            margin-bottom: 4px;
        }

        .problem-item p {
            color: var(--ink-soft);
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Features
        |--------------------------------------------------------------------------
        */

        .feature-grid {
            display: grid;
            gap: 1px;
            grid-template-columns: repeat(3, 1fr);
            background: var(--border);
            border: 1px solid var(--border);
        }

        .feature-card {
            background: white;
            min-height: 315px;
            padding: 38px;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease;
        }

        .feature-card:hover {
            box-shadow: var(--shadow-md);
            position: relative;
            transform: translateY(-5px);
            z-index: 2;
        }

        .feature-icon {
            align-items: center;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            height: 50px;
            justify-content: center;
            margin-bottom: 30px;
            width: 50px;
        }

        .feature-icon svg {
            height: 24px;
            width: 24px;
        }

        .feature-card h3 {
            font-family: 'Manrope', sans-serif;
            font-size: 20px;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .feature-card p {
            color: var(--ink-soft);
            font-size: 15px;
            line-height: 1.7;
            margin-top: 15px;
        }

        .feature-link {
            align-items: center;
            color: var(--primary);
            display: inline-flex;
            font-size: 13px;
            font-weight: 700;
            gap: 8px;
            margin-top: 23px;
        }

        .feature-link svg {
            height: 15px;
            transition: transform 180ms ease;
            width: 15px;
        }

        .feature-card:hover .feature-link svg {
            transform: translateX(4px);
        }

        /*
        |--------------------------------------------------------------------------
        | Workflow
        |--------------------------------------------------------------------------
        */

        .workflow {
            counter-reset: workflow;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .workflow-step {
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            counter-increment: workflow;
            padding: 15px 46px 15px 36px;
            position: relative;
        }

        .workflow-step:last-child {
            border-right: 1px solid rgba(255, 255, 255, 0.15);
        }

        .workflow-step::before {
            color: var(--accent);
            content: "0" counter(workflow);
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.12em;
            margin-bottom: 48px;
        }

        .workflow-step h3 {
            font-family: 'Manrope', sans-serif;
            font-size: 23px;
            line-height: 1.25;
        }

        .workflow-step p {
            color: rgba(255, 255, 255, 0.66);
            font-size: 15px;
            line-height: 1.75;
            margin-top: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | Multitenancy
        |--------------------------------------------------------------------------
        */

        .organization-layout {
            align-items: center;
            display: grid;
            gap: 95px;
            grid-template-columns: 1.02fr 0.98fr;
        }

        .organization-preview {
            background: var(--surface-soft);
            border: 1px solid var(--border);
            padding: 34px;
        }

        .browser-bar {
            align-items: center;
            background: white;
            border: 1px solid var(--border);
            display: flex;
            gap: 12px;
            padding: 12px 15px;
        }

        .browser-points {
            display: flex;
            gap: 5px;
        }

        .browser-points span {
            background: #d7d8dd;
            border-radius: 50%;
            height: 6px;
            width: 6px;
        }

        .browser-address {
            background: var(--surface-soft);
            color: #747885;
            flex: 1;
            font-size: 11px;
            padding: 7px 12px;
        }

        .browser-address strong {
            color: var(--primary);
        }

        .organization-card {
            background: white;
            border: 1px solid var(--border);
            border-top: 0;
            padding: 42px 38px;
        }

        .organization-brand {
            align-items: center;
            display: flex;
            gap: 18px;
        }

        .organization-logo {
            align-items: center;
            background: var(--primary);
            color: white;
            display: flex;
            height: 54px;
            justify-content: center;
            width: 54px;
        }

        .organization-logo svg {
            height: 27px;
            width: 27px;
        }

        .organization-brand small {
            color: var(--muted);
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .organization-brand strong {
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 18px;
            margin-top: 4px;
        }

        .organization-lines {
            display: grid;
            gap: 11px;
            margin-top: 35px;
        }

        .organization-line {
            background: #eeeff2;
            height: 9px;
        }

        .organization-line:nth-child(1) {
            width: 88%;
        }

        .organization-line:nth-child(2) {
            width: 67%;
        }

        .organization-line:nth-child(3) {
            width: 78%;
        }

        .benefit-list {
            display: grid;
            gap: 18px;
            margin-top: 34px;
        }

        .benefit {
            align-items: flex-start;
            display: flex;
            gap: 14px;
        }

        .benefit-icon {
            align-items: center;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            flex: 0 0 auto;
            height: 31px;
            justify-content: center;
            margin-top: 1px;
            width: 31px;
        }

        .benefit-icon svg {
            height: 16px;
            width: 16px;
        }

        .benefit strong {
            display: block;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .benefit p {
            color: var(--ink-soft);
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Benefits statement
        |--------------------------------------------------------------------------
        */

        .value-section {
            background: var(--surface-warm);
            border-bottom: 1px solid #e7e1d7;
            border-top: 1px solid #e7e1d7;
            padding: 72px 0;
        }

        .value-layout {
            align-items: center;
            display: grid;
            gap: 55px;
            grid-template-columns: 0.8fr 1.2fr;
        }

        .value-title {
            color: var(--primary);
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .value-message {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(25px, 3.1vw, 42px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.22;
        }

        /*
        |--------------------------------------------------------------------------
        | CTA
        |--------------------------------------------------------------------------
        */

        .cta {
            background:
                linear-gradient(
                    90deg,
                    rgba(213, 173, 99, 0.09),
                    transparent 32%
                ),
                var(--primary);
            color: white;
            overflow: hidden;
            padding: 95px 0;
            position: relative;
        }

        .cta::after {
            border: 1px solid rgba(255, 255, 255, 0.11);
            content: "";
            height: 420px;
            position: absolute;
            right: -180px;
            top: -130px;
            transform: rotate(18deg);
            width: 420px;
        }

        .cta-layout {
            align-items: center;
            display: flex;
            gap: 70px;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .cta-copy {
            max-width: 720px;
        }

        .cta-copy h2 {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(34px, 4vw, 55px);
            font-weight: 800;
            letter-spacing: -0.045em;
            line-height: 1.08;
        }

        .cta-copy p {
            color: rgba(255, 255, 255, 0.72);
            font-size: 17px;
            line-height: 1.7;
            margin-top: 20px;
            max-width: 630px;
        }

        .cta-action {
            flex: 0 0 auto;
        }

        .cta-email {
            color: rgba(255, 255, 255, 0.62);
            display: block;
            font-size: 12px;
            margin-top: 13px;
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .site-footer {
            background: #0c0f30;
            color: white;
            padding: 68px 0 30px;
        }

        .footer-grid {
            display: grid;
            gap: 70px;
            grid-template-columns: 1.2fr 0.8fr 0.8fr;
            padding-bottom: 58px;
        }

        .footer-brand .brand-name {
            color: white;
        }

        .footer-brand .brand-description {
            color: rgba(255, 255, 255, 0.47);
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.57);
            font-size: 14px;
            line-height: 1.75;
            margin-top: 23px;
            max-width: 410px;
        }

        .footer-heading {
            color: white;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.11em;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .footer-links {
            display: grid;
            gap: 12px;
            list-style: none;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.58);
            font-size: 14px;
            transition: color 160ms ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.42);
            display: flex;
            font-size: 12px;
            gap: 30px;
            justify-content: space-between;
            padding-top: 28px;
        }

        .footer-signature {
            letter-spacing: 0.04em;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {
            .hero-grid {
                gap: 38px;
                grid-template-columns: minmax(360px, 0.82fr) minmax(520px, 1.18fr);
            }

            .feature-card {
                padding: 31px;
            }

            .organization-layout,
            .problem-layout {
                gap: 60px;
            }
        }

        @media (max-width: 940px) {
            .section {
                padding: 88px 0;
            }

            .nav-links,
            .nav-area .nav-cta {
                display: none;
            }

            .menu-button {
                display: flex;
            }

            .nav-area {
                gap: 10px;
            }

            .nav-area.mobile-visible {
                align-items: stretch;
                background: white;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
                display: flex;
                flex-direction: column;
                gap: 0;
                left: 0;
                padding: 22px 20px 28px;
                position: fixed;
                right: 0;
                top: 82px;
            }

            .nav-area.mobile-visible .nav-links {
                align-items: stretch;
                display: grid;
                gap: 0;
            }

            .nav-area.mobile-visible .nav-link {
                border-bottom: 1px solid var(--border);
                display: block;
                font-size: 15px;
                padding: 16px 4px;
            }

            .nav-area.mobile-visible .nav-cta {
                display: flex;
                margin-top: 20px;
            }

            .hero {
                min-height: auto;
                padding: 150px 0 90px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero-copy {
                max-width: 750px;
            }

            .product-preview {
                margin: 10px auto 0;
                max-width: 700px;
                width: 100%;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 20px;
            }

            .section-heading .section-copy {
                max-width: 680px;
            }

            .problem-layout,
            .organization-layout {
                grid-template-columns: 1fr;
            }

            .problem-statement {
                order: 2;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .workflow {
                grid-template-columns: 1fr;
            }

            .workflow-step,
            .workflow-step:last-child {
                border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                border-left: 0;
                border-right: 0;
                padding: 38px 0;
            }

            .workflow-step::before {
                margin-bottom: 18px;
            }

            .value-layout {
                gap: 25px;
                grid-template-columns: 1fr;
            }

            .cta-layout {
                align-items: flex-start;
                flex-direction: column;
                gap: 34px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-brand {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 720px) {
            .container {
                width: min(calc(100% - 30px), var(--container));
            }

            .navbar {
                height: 74px;
            }

            .brand-description {
                display: none;
            }

            .nav-area.mobile-visible {
                top: 74px;
            }

            .hero {
                padding-top: 128px;
            }

            .hero-title {
                font-size: clamp(41px, 12vw, 58px);
            }

            .hero-description {
                font-size: 17px;
            }

            .hero-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .hero-actions .button {
                width: 100%;
            }

            .audience-content {
                align-items: flex-start;
                flex-direction: column;
                gap: 24px;
                padding: 32px 0;
            }

            .audience-list {
                align-items: flex-start;
                display: grid;
                gap: 17px;
                grid-template-columns: 1fr 1fr;
                justify-content: flex-start;
                width: 100%;
            }

            .preview-label {
                left: -8px;
                top: 28px;
            }

            .product-floating-card {
                bottom: -35px;
                right: 8px;
            }

            .problem-statement {
                padding: 42px 28px;
            }

            .problem-statement::before {
                left: 28px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .feature-card {
                min-height: auto;
            }

            .organization-preview {
                padding: 17px;
            }

            .organization-card {
                padding: 32px 23px;
            }

            .cta {
                padding: 75px 0;
            }

            .cta-action,
            .cta-action .button {
                width: 100%;
            }

            .footer-grid {
                gap: 42px;
                grid-template-columns: 1fr;
            }

            .footer-brand {
                grid-column: auto;
            }

            .footer-bottom {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .section {
                padding: 75px 0;
            }

            .audience-list {
                grid-template-columns: 1fr;
            }

            .product-floating-card {
                display: none;
            }

            .hero-note {
                align-items: flex-start;
            }
        }


        @media (max-width: 720px) {
            .system-browser-bar {
                gap: 10px;
                grid-template-columns: auto minmax(0, 1fr);
                min-height: 44px;
                padding: 0 12px;
            }

            .system-browser-address {
                font-size: 8px;
                min-height: 25px;
            }

            .system-browser-menu {
                display: none;
            }

            .system-browser-controls {
                gap: 5px;
            }

            .system-browser-controls span {
                height: 7px;
                width: 7px;
            }
        }

        @media (max-width: 480px) {
            .system-browser-address {
                padding-inline: 9px;
            }

            .system-browser-address span {
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | Landing comercial INTEVI - bloques adicionales
        |--------------------------------------------------------------------------
        */

        .section-warm {
            background: var(--surface-warm);
        }

        .offer-section .eyebrow {
            color: #cdd1ff;
        }

        .offer-section .section-copy {
            color: rgba(255, 255, 255, .72);
        }

        .hero-kicker-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            margin-top: 22px;
        }

        .hero-kicker-item {
            align-items: center;
            color: var(--muted);
            display: inline-flex;
            font-size: 13px;
            gap: 7px;
        }

        .hero-kicker-item svg {
            color: var(--success);
            height: 16px;
            width: 16px;
        }

        .pain-grid {
            display: grid;
            gap: 1px;
            grid-template-columns: repeat(4, 1fr);
            margin-top: 48px;
            background: var(--border);
            border: 1px solid var(--border);
        }

        .pain-card {
            background: white;
            min-height: 230px;
            padding: 30px;
        }

        .pain-card-number {
            color: var(--accent-dark);
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .12em;
            margin-bottom: 30px;
        }

        .pain-card h3 {
            font-family: 'Manrope', sans-serif;
            font-size: 18px;
            line-height: 1.3;
        }

        .pain-card p {
            color: var(--ink-soft);
            font-size: 14px;
            line-height: 1.7;
            margin-top: 12px;
        }

        .method-header {
            align-items: start;
            display: grid;
            gap: 70px;
            grid-template-columns: .8fr 1.2fr;
            margin-bottom: 55px;
        }

        .method-summary {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .14);
            padding: 31px;
        }

        .method-summary strong {
            color: var(--accent);
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            margin-bottom: 10px;
        }

        .method-summary p {
            color: rgba(255, 255, 255, .72);
            font-size: 15px;
            line-height: 1.7;
        }

        .method-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }

        .method-card {
            border-left: 1px solid rgba(255, 255, 255, .15);
            min-height: 315px;
            padding: 27px 22px;
        }

        .method-card:last-child {
            border-right: 1px solid rgba(255, 255, 255, .15);
        }

        .method-card-number {
            color: var(--accent);
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .13em;
            margin-bottom: 44px;
        }

        .method-card h3 {
            font-family: 'Manrope', sans-serif;
            font-size: 21px;
            line-height: 1.2;
        }

        .method-card strong {
            display: block;
            font-size: 13px;
            margin-top: 13px;
        }

        .method-card p {
            color: rgba(255, 255, 255, .64);
            font-size: 14px;
            line-height: 1.7;
            margin-top: 10px;
        }

        .feature-grid.feature-grid-nine {
            grid-template-columns: repeat(3, 1fr);
        }

        .feature-result {
            align-items: center;
            color: var(--primary);
            display: inline-flex;
            font-size: 12px;
            font-weight: 800;
            gap: 7px;
            letter-spacing: .04em;
            margin-top: 22px;
            text-transform: uppercase;
        }

        .feature-result::before {
            background: var(--accent);
            content: '';
            height: 2px;
            width: 17px;
        }

        .demo-layout {
            align-items: center;
            display: grid;
            gap: 75px;
            grid-template-columns: 1.15fr .85fr;
        }

        .demo-points {
            display: grid;
            gap: 16px;
            margin-top: 30px;
        }

        .demo-point {
            align-items: flex-start;
            display: flex;
            gap: 12px;
        }

        .demo-point svg {
            color: var(--success);
            flex: 0 0 auto;
            height: 19px;
            margin-top: 2px;
            width: 19px;
        }

        .demo-point strong {
            display: block;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .demo-point p {
            color: var(--ink-soft);
            font-size: 14px;
        }

        .implementation-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(4, 1fr);
        }

        .implementation-card {
            background: white;
            border: 1px solid var(--border);
            min-height: 275px;
            padding: 30px;
        }

        .implementation-number {
            color: var(--accent-dark);
            display: block;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .12em;
            margin-bottom: 33px;
        }

        .implementation-card h3 {
            font-family: 'Manrope', sans-serif;
            font-size: 19px;
            line-height: 1.3;
        }

        .implementation-card p {
            color: var(--ink-soft);
            font-size: 14px;
            line-height: 1.7;
            margin-top: 13px;
        }

        .story-layout {
            align-items: center;
            display: grid;
            gap: 72px;
            grid-template-columns: .82fr 1.18fr;
        }

        .story-card {
            background: var(--primary);
            color: white;
            padding: 46px;
            position: relative;
        }

        .story-card::before {
            color: rgba(255, 255, 255, .12);
            content: '“';
            font-family: Georgia, serif;
            font-size: 140px;
            left: 23px;
            line-height: 1;
            position: absolute;
            top: 8px;
        }

        .story-card p {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(23px, 2.5vw, 32px);
            font-weight: 700;
            letter-spacing: -.03em;
            line-height: 1.35;
            position: relative;
            z-index: 2;
        }

        .story-card span {
            color: rgba(255, 255, 255, .68);
            display: block;
            font-size: 13px;
            margin-top: 25px;
            position: relative;
            z-index: 2;
        }

        .roi-section {
            background:
                linear-gradient(90deg, rgba(213, 173, 99, .12), transparent 38%),
                var(--surface-warm);
            border-bottom: 1px solid #e7e1d7;
            border-top: 1px solid #e7e1d7;
            padding: 85px 0;
        }

        .roi-layout {
            align-items: center;
            display: grid;
            gap: 60px;
            grid-template-columns: .82fr 1.18fr;
        }

        .roi-questions {
            display: grid;
            gap: 10px;
            margin-top: 24px;
        }

        .roi-question {
            align-items: flex-start;
            color: var(--ink-soft);
            display: flex;
            font-size: 14px;
            gap: 10px;
        }

        .roi-question::before {
            background: var(--accent);
            content: '';
            flex: 0 0 auto;
            height: 6px;
            margin-top: 8px;
            width: 6px;
        }

        .roi-message {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(27px, 3.1vw, 42px);
            font-weight: 700;
            letter-spacing: -.04em;
            line-height: 1.22;
        }

        .offer-section {
            background:
                radial-gradient(circle at 8% 15%, rgba(213, 173, 99, .12), transparent 24%),
                #0b0e31;
            color: white;
            padding: 112px 0;
        }

        .offer-layout {
            align-items: center;
            display: grid;
            gap: 72px;
            grid-template-columns: .92fr 1.08fr;
        }

        .offer-product {
            position: relative;
        }

        .offer-product img {
            filter: drop-shadow(0 35px 65px rgba(0, 0, 0, .32));
            margin-inline: auto;
            max-height: 520px;
            object-fit: contain;
        }

        .offer-badge {
            background: var(--accent);
            color: #0b0e31;
            font-size: 11px;
            font-weight: 800;
            left: 0;
            letter-spacing: .11em;
            padding: 11px 15px;
            position: absolute;
            text-transform: uppercase;
            top: 15px;
        }

        .offer-card {
            background: white;
            box-shadow: 0 35px 90px rgba(0, 0, 0, .25);
            color: var(--ink);
            padding: 44px;
        }

        .offer-card-label {
            color: var(--primary);
            display: block;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .offer-card h3 {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(27px, 2.8vw, 39px);
            letter-spacing: -.04em;
            line-height: 1.14;
            margin-top: 10px;
        }

        .offer-list {
            border-top: 1px solid var(--border);
            display: grid;
            gap: 16px;
            margin-top: 25px;
            padding-top: 25px;
        }

        .offer-item {
            align-items: flex-start;
            display: flex;
            gap: 12px;
        }

        .offer-item svg {
            color: var(--success);
            flex: 0 0 auto;
            height: 20px;
            margin-top: 2px;
            width: 20px;
        }

        .offer-item strong {
            display: block;
            font-size: 15px;
        }

        .offer-item p {
            color: var(--ink-soft);
            font-size: 13px;
            margin-top: 2px;
        }

        .price-box {
            background: #f5f6ff;
            border: 1px solid #e1e4ff;
            margin-top: 28px;
            padding: 25px;
        }

        .price-label {
            color: var(--primary);
            display: block;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .price-main {
            align-items: baseline;
            color: var(--primary);
            display: flex;
            flex-wrap: wrap;
            font-family: 'Manrope', sans-serif;
            font-size: clamp(43px, 5vw, 63px);
            font-weight: 800;
            gap: 9px;
            letter-spacing: -.06em;
            line-height: 1;
            margin-top: 12px;
        }

        .price-main small {
            color: var(--ink-soft);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .renewal-note {
            border-top: 1px solid #dfe2f9;
            color: var(--ink-soft);
            font-size: 14px;
            margin-top: 19px;
            padding-top: 17px;
        }

        .renewal-note strong {
            color: var(--ink);
        }

        .offer-actions {
            display: grid;
            gap: 11px;
            margin-top: 24px;
        }

        .offer-actions .button {
            width: 100%;
        }

        .offer-note {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.55;
            margin-top: 15px;
            text-align: center;
        }

        .guarantee-layout {
            align-items: center;
            display: grid;
            gap: 68px;
            grid-template-columns: .72fr 1.28fr;
        }

        .guarantee-image {
            display: flex;
            justify-content: center;
        }

        .guarantee-image img {
            filter: drop-shadow(0 24px 40px rgba(18, 24, 61, .14));
            max-width: 275px;
        }

        .guarantee-list {
            display: grid;
            gap: 12px;
            margin-top: 24px;
        }

        .guarantee-item {
            align-items: flex-start;
            display: flex;
            font-size: 14px;
            gap: 10px;
        }

        .guarantee-item svg {
            color: var(--success);
            flex: 0 0 auto;
            height: 18px;
            margin-top: 2px;
            width: 18px;
        }

        .faq-layout {
            display: grid;
            gap: 62px;
            grid-template-columns: .72fr 1.28fr;
        }

        .faq-intro {
            align-self: start;
            position: sticky;
            top: 115px;
        }

        .faq-list {
            border-top: 1px solid var(--border);
        }

        .faq-item {
            border-bottom: 1px solid var(--border);
        }

        .faq-question {
            align-items: center;
            background: transparent;
            border: 0;
            color: var(--ink);
            cursor: pointer;
            display: flex;
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            font-weight: 700;
            justify-content: space-between;
            line-height: 1.35;
            padding: 24px 0;
            text-align: left;
            width: 100%;
        }

        .faq-symbol {
            color: var(--primary);
            flex: 0 0 auto;
            font-size: 25px;
            font-weight: 400;
            margin-left: 20px;
            transition: transform 180ms ease;
        }

        .faq-item.open .faq-symbol {
            transform: rotate(45deg);
        }

        .faq-answer {
            color: var(--ink-soft);
            display: grid;
            font-size: 15px;
            grid-template-rows: 0fr;
            line-height: 1.75;
            transition: grid-template-rows 220ms ease;
        }

        .faq-answer > div {
            overflow: hidden;
        }

        .faq-answer p {
            padding: 0 44px 23px 0;
        }

        .faq-item.open .faq-answer {
            grid-template-rows: 1fr;
        }

        .mobile-sticky-cta {
            background: rgba(255, 255, 255, .96);
            border-top: 1px solid var(--border);
            bottom: 0;
            display: none;
            left: 0;
            padding: 10px 15px;
            position: fixed;
            right: 0;
            z-index: 90;
        }

        .mobile-sticky-cta .button {
            min-height: 48px;
            width: 100%;
        }

        @media (max-width: 960px) {
            .method-header,
            .demo-layout,
            .story-layout,
            .offer-layout,
            .guarantee-layout,
            .faq-layout {
                grid-template-columns: 1fr;
            }

            .pain-grid,
            .implementation-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .method-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .method-card,
            .method-card:last-child {
                border-bottom: 1px solid rgba(255, 255, 255, .15);
                border-left: 0;
                border-right: 0;
                min-height: 245px;
            }

            .method-card:last-child {
                grid-column: 1 / -1;
                min-height: auto;
            }

            .method-card-number {
                margin-bottom: 22px;
            }

            .roi-layout {
                gap: 28px;
                grid-template-columns: 1fr;
            }

            .offer-product {
                margin-inline: auto;
                max-width: 650px;
            }

            .offer-card {
                margin-inline: auto;
                max-width: 690px;
                width: 100%;
            }

            .faq-intro {
                position: static;
            }
        }

        @media (max-width: 720px) {
            body {
                padding-bottom: 68px;
            }

            .hero-kicker-list {
                align-items: flex-start;
                flex-direction: column;
            }

            .pain-grid,
            .method-grid,
            .feature-grid.feature-grid-nine,
            .implementation-grid {
                grid-template-columns: 1fr;
            }

            .method-card:last-child {
                grid-column: auto;
            }

            .method-card,
            .method-card:last-child {
                min-height: auto;
                padding: 30px 3px;
            }

            .story-card,
            .offer-card {
                padding: 34px 27px;
            }

            .offer-product img {
                max-height: 390px;
            }

            .price-main {
                align-items: flex-start;
                flex-direction: column;
                gap: 11px;
            }

            .faq-answer p {
                padding-right: 0;
            }

            .mobile-sticky-cta {
                display: block;
            }
        }

    </style>
        <script
        src="{{ asset('js/intevi-clarity.js') }}"
        defer>
    </script>
</head>

<body>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6a5ad85b940f101d5323a8b6/1jtpdq9oo';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCLM28B2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NETSEPFHTT"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NETSEPFHTT');
</script>
 
<header class="site-header">
    <div class="container navbar">
        <a href="#inicio" class="brand">
            <img
                src="{{ asset('images/intevi logo.png') }}"
                alt="Logo de INTEVI"
                class="brand-logo"
                width="52"
                height="52"
            >

            <span class="brand-text">
                <span class="brand-name">INTEVI</span>
                <span class="brand-description">
                    Inventario y resguardo institucional
                </span>
            </span>
        </a>

        <div class="nav-area" id="navigation">
            <ul class="nav-links">
                <li><a class="nav-link" href="#metodo">Control 5X</a></li>
                <li><a class="nav-link" href="#plataforma">Plataforma</a></li>
                <li><a class="nav-link" href="#implementacion">Implementación</a></li>
                <li><a class="nav-link" href="#oferta">Precio</a></li>
                <li><a class="nav-link" href="#preguntas">Preguntas</a></li>
            </ul>

            <button
                class="button button-primary nav-cta"
                type="button"
                data-open-chat
            >
                Solicitar demostración
            </button>
        </div>

        <button
            class="menu-button"
            id="menuButton"
            type="button"
            aria-expanded="false"
            aria-controls="navigation"
            aria-label="Abrir menú"
        >
            <span></span>
        </button>
    </div>
</header>

<main>
    {{-- HERO --}}
    <section class="hero" id="inicio">
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="hero-tag">
                    <span class="hero-tag-dot"></span>
                    Control de resguardos institucionales
                </div>

                <h1 class="hero-title">
                    No basta con saber qué bienes tienes.
                    <span>
                        Debes saber dónde están, quién responde por ellos
                        y qué lo comprueba.
                    </span>
                </h1>

                <p class="hero-description">
                    INTEVI conecta inventario, responsables, ubicaciones,
                    documentos e historiales para que cada bien institucional
                    permanezca identificado, localizado y respaldado desde una
                    sola plataforma.
                </p>

                <div class="hero-actions">
                    <button
                        class="button button-primary"
                        type="button"
                        data-open-chat
                    >
                        Solicitar una demostración

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </button>

                    <a class="button button-outline" href="#metodo">
                        Conocer el Control 5X
                    </a>
                </div>

                <div class="hero-kicker-list">
                    <span class="hero-kicker-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        Funciona desde el navegador
                    </span>

                    <span class="hero-kicker-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        Sin instalación en cada equipo
                    </span>

                    <span class="hero-kicker-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        Demostración sin compromiso
                    </span>
                </div>
            </div>

            <div class="product-preview">
                <div class="preview-label">
                    Vista real de INTEVI
                </div>

                <div class="system-browser">
                    <div class="system-browser-bar">
                        <div class="system-browser-controls">
                            <span></span><span></span><span></span>
                        </div>

                        <div class="system-browser-address">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>
                            <span>tuinstitucion.intevi.app/inventario</span>
                        </div>

                        <div class="system-browser-menu">
                            <span></span><span></span><span></span>
                        </div>
                    </div>

                    <div class="system-screen">
                        <img
                            src="{{ asset('images/intevi-dashboard.webp') }}"
                            alt="Vista del sistema INTEVI para control de inventario institucional"
                            width="1915"
                            height="920"
                            loading="eager"
                            fetchpriority="high"
                        >
                    </div>
                </div>

                <div class="product-floating-card">
                    <span class="floating-card-label">Control institucional</span>
                    <span class="floating-card-value">Información centralizada</span>
                </div>
            </div>
        </div>
    </section>

    {{-- PÚBLICO OBJETIVO --}}
    <section class="audience-strip">
        <div class="container audience-content">
            <span class="audience-title">Diseñado para</span>

            <div class="audience-list">
                <span class="audience-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M3 21h18M5 21V8l7-4 7 4v13"/>
                        <path d="M9 12h1M14 12h1M9 16h1M14 16h1"/>
                    </svg>
                    Instituciones públicas
                </span>

                <span class="audience-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M8 12h8M12 8v8"/>
                    </svg>
                    Organismos
                </span>

                <span class="audience-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M4 20V6h8v14M12 10h8v10"/>
                        <path d="M7 9h2M7 13h2M7 17h2M15 13h2M15 17h2"/>
                    </svg>
                    Empresas con bienes bajo resguardo
                </span>
            </div>
        </div>
    </section>

    {{-- PROBLEMA --}}
    <section class="section" id="problema">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">El costo del descontrol</span>

                    <h2 class="heading heading-medium">
                        Puedes tener una lista de todos tus bienes y aun así
                        no tener el control.
                    </h2>
                </div>

                <p class="section-copy">
                    El control comienza cuando cada activo puede localizarse,
                    comprobarse y relacionarse con un responsable sin depender
                    de archivos dispersos o de la memoria del personal.
                </p>
            </div>

            <div class="pain-grid">
                <article class="pain-card">
                    <span class="pain-card-number">01</span>
                    <h3>Horas buscando información</h3>
                    <p>
                        Localizar un bien, un documento o al responsable correcto
                        deja de ser inmediato.
                    </p>
                </article>

                <article class="pain-card">
                    <span class="pain-card-number">02</span>
                    <h3>Trabajo repetido</h3>
                    <p>
                        El personal captura, compara y corrige la misma información
                        en diferentes hojas y formatos.
                    </p>
                </article>

                <article class="pain-card">
                    <span class="pain-card-number">03</span>
                    <h3>Responsabilidad poco clara</h3>
                    <p>
                        Se dificulta comprobar quién recibió un bien, dónde quedó
                        y qué evidencia existe.
                    </p>
                </article>

                <article class="pain-card">
                    <span class="pain-card-number">04</span>
                    <h3>Pérdida de continuidad</h3>
                    <p>
                        Cuando cambia el personal, parte del control puede irse
                        con quien conocía los archivos.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- MÉTODO 5X --}}
    <section class="section section-dark" id="metodo">
        <div class="container">
            <div class="method-header">
                <div>
                    <span class="eyebrow">Control Institucional 5X</span>

                    <h2 class="heading heading-medium">
                        Cada bien debe responder cinco preguntas.
                    </h2>

                    <p class="section-copy">
                        INTEVI no se limita a guardar una lista. Conecta la
                        información necesaria para demostrar que un activo está
                        realmente bajo control.
                    </p>
                </div>

                <div class="method-summary">
                    <strong>Método Resguardos Fáciles de Controlar 5X</strong>
                    <p>
                        La metodología está integrada en la plataforma y organiza
                        el proceso alrededor de cinco elementos: existencia,
                        ubicación, responsable, evidencia e historial.
                    </p>
                </div>
            </div>

            <div class="method-grid">
                <article class="method-card">
                    <span class="method-card-number">01</span>
                    <h3>Existencia</h3>
                    <strong>¿Qué bien existe?</strong>
                    <p>
                        Identifica el activo mediante descripción, marca, serie,
                        características, estado y datos institucionales.
                    </p>
                </article>

                <article class="method-card">
                    <span class="method-card-number">02</span>
                    <h3>Ubicación</h3>
                    <strong>¿Dónde se encuentra?</strong>
                    <p>
                        Relaciona el bien con su área de asignación y su ubicación
                        física actual.
                    </p>
                </article>

                <article class="method-card">
                    <span class="method-card-number">03</span>
                    <h3>Responsable</h3>
                    <strong>¿Quién responde por él?</strong>
                    <p>
                        Vincula cada bien con la persona, puesto y área que lo
                        utiliza o mantiene bajo resguardo.
                    </p>
                </article>

                <article class="method-card">
                    <span class="method-card-number">04</span>
                    <h3>Evidencia</h3>
                    <strong>¿Qué lo comprueba?</strong>
                    <p>
                        Conserva documentos, imágenes y datos relacionados con
                        la entrega y el resguardo.
                    </p>
                </article>

                <article class="method-card">
                    <span class="method-card-number">05</span>
                    <h3>Historial</h3>
                    <strong>¿Qué ha sucedido?</strong>
                    <p>
                        Consulta asignaciones, cambios y liberaciones para
                        mantener continuidad sobre cada movimiento.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- FUNCIONES --}}
    <section class="section section-soft" id="plataforma">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Una plataforma conectada</span>

                    <h2 class="heading heading-medium">
                        Herramientas para llevar el control sin depender de
                        procesos dispersos.
                    </h2>
                </div>

                <p class="section-copy">
                    Cada módulo comparte información con los demás para reducir
                    capturas repetidas y facilitar la consulta.
                </p>
            </div>

            <div class="feature-grid feature-grid-nine">
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 7h16v13H4z"/><path d="m4 7 3-3h10l3 3M9 11h6"/>
                        </svg>
                    </div>
                    <h3>Inventario de bienes</h3>
                    <p>
                        Registra descripción, marca, serie, cantidad,
                        características, estado y datos de identificación.
                    </p>
                    <span class="feature-result">Registro central</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="8" r="3"/><path d="M5 20c0-4 3-7 7-7s7 3 7 7"/>
                        </svg>
                    </div>
                    <h3>Resguardantes y puestos</h3>
                    <p>
                        Organiza responsables y relaciona su información con
                        puestos, áreas y bienes asignados.
                    </p>
                    <span class="feature-result">Responsabilidad definida</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 20V9l8-5 8 5v11"/><path d="M8 20v-7h8v7"/>
                        </svg>
                    </div>
                    <h3>Áreas y ubicaciones físicas</h3>
                    <p>
                        Clasifica los activos por dirección, departamento,
                        oficina, almacén o espacio físico.
                    </p>
                    <span class="feature-result">Localización rápida</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4z"/><path d="M14 14h2v2h-2zM18 14h2v6h-6v-2"/>
                        </svg>
                    </div>
                    <h3>Etiquetas escaneables</h3>
                    <p>
                        Genera etiquetas para identificar bienes y consultar
                        rápidamente la información de su resguardo.
                    </p>
                    <span class="feature-result">Identificación práctica</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M5 4h10l4 4v12H5z"/><path d="M15 4v5h5M8 13h8M8 16h6"/>
                        </svg>
                    </div>
                    <h3>Documentos e imágenes</h3>
                    <p>
                        Integra archivos PDF e imágenes como apoyo documental
                        de ubicaciones y resguardos.
                    </p>
                    <span class="feature-result">Evidencia organizada</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 4v6h6"/><path d="M5.5 15a7 7 0 1 0 1.2-8.2L4 10"/>
                        </svg>
                    </div>
                    <h3>Historial de resguardos</h3>
                    <p>
                        Conserva asignaciones, cambios y liberaciones para
                        consultar movimientos anteriores.
                    </p>
                    <span class="feature-result">Trazabilidad</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 19V9M10 19V5M16 19v-7M22 19H2"/>
                        </svg>
                    </div>
                    <h3>Consultas y reportes</h3>
                    <p>
                        Filtra por responsable, área, ubicación, estado u otros
                        criterios para agilizar revisiones.
                    </p>
                    <span class="feature-result">Información útil</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M4 5h16v14H4z"/><path d="M8 9h8M8 13h5M8 17h3"/><path d="m16 14 2 2 3-4"/>
                        </svg>
                    </div>
                    <h3>Carga de catálogos</h3>
                    <p>
                        Importa marcas, puestos y áreas desde Excel para reducir
                        captura manual.
                    </p>
                    <span class="feature-result">Implementación ágil</span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M12 3 5 6v5c0 5 3 8 7 10 4-2 7-5 7-10V6z"/><path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3>Usuarios, roles y permisos</h3>
                    <p>
                        Define quién puede consultar, registrar o administrar
                        según sus responsabilidades.
                    </p>
                    <span class="feature-result">Acceso controlado</span>
                </article>
            </div>
        </div>
    </section>

    {{-- DEMOSTRACIÓN --}}
    <section class="section">
        <div class="container demo-layout">
            <div class="system-browser">
                <div class="system-browser-bar">
                    <div class="system-browser-controls">
                        <span></span><span></span><span></span>
                    </div>

                    <div class="system-browser-address">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="5" y="10" width="14" height="10" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        </svg>
                        <span>Vista real del entorno institucional</span>
                    </div>

                    <div class="system-browser-menu">
                        <span></span><span></span><span></span>
                    </div>
                </div>

                <div class="system-screen">
                    <img
                        src="{{ asset('images/intevi-dashboard.webp') }}"
                        alt="Panel real de la plataforma INTEVI"
                        width="1915"
                        height="920"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
            </div>

            <div>
                <span class="eyebrow">No es una promesa abstracta</span>

                <h2 class="heading heading-medium">
                    Conoce la plataforma antes de tomar una decisión.
                </h2>

                <p class="section-copy">
                    Durante la demostración podrás revisar los módulos, explicar
                    cómo trabaja actualmente tu institución y comprobar si
                    INTEVI responde a tus necesidades reales.
                </p>

                <div class="demo-points">
                    <div class="demo-point">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <div>
                            <strong>Vista del sistema funcionando</strong>
                            <p>No necesitas comprar para descubrir cómo opera.</p>
                        </div>
                    </div>

                    <div class="demo-point">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <div>
                            <strong>Revisión de tu proceso actual</strong>
                            <p>
                                Identificamos cómo administras bienes,
                                responsables y resguardos.
                            </p>
                        </div>
                    </div>

                    <div class="demo-point">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <div>
                            <strong>Sin compromiso de contratación</strong>
                            <p>Evalúa primero y decide con información.</p>
                        </div>
                    </div>
                </div>

                <button
                    class="button button-primary"
                    type="button"
                    data-open-chat
                    style="margin-top: 31px;"
                >
                    Solicitar demostración
                </button>
            </div>
        </div>
    </section>

    {{-- IMPLEMENTACIÓN --}}
    <section class="section section-warm" id="implementacion">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Implementación acompañada</span>

                    <h2 class="heading heading-medium">
                        No te entregamos el acceso y te dejamos solo.
                    </h2>
                </div>

                <p class="section-copy">
                    La adopción se organiza para que el personal comprenda la
                    plataforma y pueda comenzar con una estructura clara.
                </p>
            </div>

            <div class="implementation-grid">
                <article class="implementation-card">
                    <span class="implementation-number">01</span>
                    <h3>Conocemos tu operación</h3>
                    <p>
                        Revisamos cómo administra la institución sus bienes,
                        áreas, responsables y resguardos.
                    </p>
                </article>

                <article class="implementation-card">
                    <span class="implementation-number">02</span>
                    <h3>Preparamos tu entorno</h3>
                    <p>
                        Configuramos un acceso institucional independiente para
                        comenzar a organizar usuarios e información.
                    </p>
                </article>

                <article class="implementation-card">
                    <span class="implementation-number">03</span>
                    <h3>Orientamos a tu equipo</h3>
                    <p>
                        La plataforma incluye tutoriales guiados y acompañamiento
                        inicial para facilitar su uso.
                    </p>
                </article>

                <article class="implementation-card">
                    <span class="implementation-number">04</span>
                    <h3>Comienzas a controlar</h3>
                    <p>
                        El personal registra, asigna, consulta y actualiza la
                        información desde un mismo entorno.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- ENTORNO INDEPENDIENTE --}}
    <section class="section" id="instituciones">
        <div class="container organization-layout">
            <div class="organization-preview">
                <div class="browser-bar">
                    <div class="browser-points">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="browser-address">
                        https://<strong>tuinstitucion</strong>.intevi.app
                    </div>
                </div>

                <div class="organization-card">
                    <div class="organization-brand">
                        <div class="organization-logo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M3 21h18M5 21V8l7-4 7 4v13"/>
                                <path d="M9 12h1M14 12h1M9 16h1M14 16h1"/>
                            </svg>
                        </div>
                        <div>
                            <small>Entorno institucional</small>
                            <strong>Nombre de la institución</strong>
                        </div>
                    </div>

                    <div class="organization-lines">
                        <div class="organization-line"></div>
                        <div class="organization-line"></div>
                        <div class="organization-line"></div>
                    </div>
                </div>
            </div>

            <div>
                <span class="eyebrow">Entorno independiente</span>

                <h2 class="heading heading-medium">
                    La operación de cada organización permanece separada.
                </h2>

                <p class="section-copy">
                    Cada institución cuenta con su propio acceso, usuarios,
                    información y configuración dentro de un entorno identificado
                    con su nombre.
                </p>

                <div class="benefit-list">
                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>
                        <div>
                            <strong>Dirección web personalizada</strong>
                            <p>Un acceso identificable para ingresar al sistema.</p>
                        </div>
                    </div>

                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>
                        <div>
                            <strong>Información independiente</strong>
                            <p>
                                Los registros de una institución no se mezclan
                                con los de otra.
                            </p>
                        </div>
                    </div>

                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>
                        <div>
                            <strong>Roles y permisos</strong>
                            <p>
                                La visibilidad y administración se organizan
                                según las responsabilidades del personal.
                            </p>
                        </div>
                    </div>

                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>
                        <div>
                            <strong>Acceso mediante conexión segura</strong>
                            <p>
                                La plataforma se utiliza desde la web dentro del
                                entorno asignado a la organización.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HISTORIA --}}
    <section class="section section-soft">
        <div class="container story-layout">
            <div class="story-card">
                <p>
                    INTEVI nació de una necesidad observada en la operación
                    institucional, no de una lista genérica de funciones.
                </p>
                <span>Jonathan Bedolla · Informático y creador de INTEVI</span>
            </div>

            <div>
                <span class="eyebrow">Creado desde la experiencia real</span>

                <h2 class="heading heading-medium">
                    Una solución pensada para el trabajo administrativo que
                    existe detrás de cada resguardo.
                </h2>

                <p class="section-copy">
                    Después de trabajar en una institución gubernamental y
                    conocer de cerca la dificultad de administrar numerosos
                    bienes, responsables, ubicaciones y documentos, se desarrolló
                    INTEVI para convertir ese proceso disperso en una operación
                    más clara y consultable.
                </p>

                <p class="section-copy">
                    Por eso la plataforma no se limita al inventario: conecta el
                    bien con la persona, el lugar, la evidencia y su historial.
                </p>
            </div>
        </div>
    </section>

    {{-- VALOR --}}
    <section class="roi-section">
        <div class="container roi-layout">
            <div>
                <span class="value-title">El valor real</span>

                <div class="roi-questions">
                    <span class="roi-question">
                        ¿Cuántas horas dedica el personal a buscar y comparar
                        información?
                    </span>
                    <span class="roi-question">
                        ¿Cuánto cuesta repetir capturas y corregir inconsistencias?
                    </span>
                    <span class="roi-question">
                        ¿Qué ocurre cuando un bien no puede relacionarse con una
                        ubicación o un responsable?
                    </span>
                </div>
            </div>

            <p class="roi-message">
                INTEVI no se vende únicamente como software. Se implementa para
                reducir incertidumbre, trabajo manual y dependencia de archivos
                dispersos.
            </p>
        </div>
    </section>

    {{-- OFERTA --}}
    <section class="offer-section" id="oferta">
        <div class="container offer-layout">
            <div class="offer-product">
                <span class="offer-badge">Lanzamiento</span>

                <img
                    src="{{ asset('images/intevi-caja.png') }}"
                    alt="Presentación de la plataforma INTEVI y el Método Resguardos Fáciles de Controlar 5X"
                    loading="lazy"
                    decoding="async"
                    style="heigth:500px;"
                >
            </div>

            <div>
                <span class="eyebrow">Oferta transparente</span>

                <h2 class="heading heading-medium">
                    Todo lo necesario para comenzar con una sola licencia.
                </h2>

                <p class="section-copy">
                    Sin valores inflados ni productos separados que después debas
                    comprar. La metodología, la orientación y las herramientas
                    forman parte de la implementación.
                </p>

                <div class="offer-card">
                    <span class="offer-card-label">Instituciones fundadoras</span>
                    <h3>Implementación anual de INTEVI</h3>

                    <div class="offer-list">
                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Licencia anual de la plataforma</strong>
                                <p>Acceso al entorno institucional y a los módulos contratados.</p>
                            </div>
                        </div>

                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Método Resguardos Fáciles de Controlar 5X</strong>
                                <p>Metodología integrada, no un curso adicional.</p>
                            </div>
                        </div>

                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Configuración institucional inicial</strong>
                                <p>Preparación del entorno estándar para comenzar.</p>
                            </div>
                        </div>

                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Capacitación y tutoriales guiados</strong>
                                <p>Orientación inicial y recorridos dentro de los módulos.</p>
                            </div>
                        </div>

                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Asistente especializado INTEVI</strong>
                                <p>Apoyo para preguntas frecuentes sobre el uso de la plataforma.</p>
                            </div>
                        </div>

                        <div class="offer-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                            <div>
                                <strong>Actualizaciones y mantenimiento</strong>
                                <p>La institución usa el sistema sin mantener servidores locales.</p>
                            </div>
                        </div>
                    </div>

                    <div class="price-box">
                        <span class="price-label">🚀 Precio especial de lanzamiento</span>

                        <div class="price-main">
                            $4,999 MXN 
                            <small>durante el primer año</small>
                        </div>

                        <p class="renewal-note">
                            <strong>Renovación:</strong> $10,000 MXN al año a partir
                            del segundo año. El precio se informa desde el inicio
                            para que la institución conozca su inversión futura.
                        </p>
                    </div>

                    <div class="offer-actions">
                        <button class="button button-primary" type="button" data-open-chat>
                            Solicitar una demostración
                        </button>
                        <!--
                        <a class="button button-outline" href="{{ $demoMailto }}">
                            Solicitar por correo
                        </a>
                        -->
                        <iframe width="540" height="500"  src="https://c9015cf0.sibforms.com/v2/serve/MUIFAKBtKumOeQ_vSPH4Fxc7sj3KkltZg_HQSUsH-CugU2MCkC8ZHdbYq2Zch6Z44BMj5yndHZmM3XoVk-ljtgcKxi77ZjEDjiDqvHslUhQXB0s8XYnRCYeTP2cGeFJ9MwXBF8UfHc5Yd4TvrMY7pGXQOn_gKXYPqdaEWzv6hoPLSi9KUxLXG_OuKz2fZlTvY8TrUTI9kPpx0b95aw==" frameborder="0" scrolling="auto" allowfullscreen style="display: block;margin-left: auto;margin-right: auto;max-width: 100%;"></iframe>
                    </div>

                    <p class="offer-note">
                        Precio sujeto al alcance estándar de la implementación.
                        Desarrollos especiales, integraciones o personalizaciones
                        adicionales se cotizan por separado. Impuestos aplicables
                        no incluidos.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- GARANTÍA --}}
    <section class="section">
        <div class="container guarantee-layout">
            <div class="guarantee-image">
                <img
                    src="{{ asset('images/garantia.png') }}"
                    alt="Garantía de evaluación durante 30 días"
                    loading="lazy"
                    decoding="async"
                >
            </div>

            <div>
                <span class="eyebrow">Compra protegida</span>

                <h2 class="heading heading-medium">
                    Evalúa INTEVI con mayor tranquilidad.
                </h2>

                <p class="section-copy">
                    Primero conoces la plataforma mediante una demostración.
                    Después de contratar, cuentas con 30 días para confirmar que
                    el servicio corresponde con el alcance presentado.
                </p>

                <div class="guarantee-list">
                    <span class="guarantee-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Condiciones claras antes de contratar.
                    </span>
                    <span class="guarantee-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        Solicitud de cancelación dentro de los primeros 30 días,
                        conforme a los términos de la garantía.
                    </span>
                    <span class="guarantee-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        La demostración permite comprobar el sistema antes de decidir.
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- PREGUNTAS FRECUENTES --}}
    <section class="section section-soft" id="preguntas">
        <div class="container faq-layout">
            <div class="faq-intro">
                <span class="eyebrow">Preguntas frecuentes</span>

                <h2 class="heading heading-medium">
                    Resuelve las principales dudas antes de solicitar una
                    demostración.
                </h2>

                <p class="section-copy">
                    También puedes utilizar el chat para plantear una necesidad
                    específica de tu institución.
                </p>
            </div>

            <div class="faq-list">
                @php
                    $faqs = [
                        [
                            'question' => '¿INTEVI es un sistema de almacén?',
                            'answer' => 'No exactamente. Está especializado en el control de bienes institucionales y en su relación con responsables, áreas, ubicaciones, documentos e historiales de resguardo.',
                        ],
                        [
                            'question' => '¿Qué tipo de bienes se pueden registrar?',
                            'answer' => 'Equipos tecnológicos, mobiliario, herramientas, activos administrativos y otros bienes que la organización necesite identificar y asignar.',
                        ],
                        [
                            'question' => '¿Podemos conocer quién tiene cada bien?',
                            'answer' => 'Sí. Cada activo puede relacionarse con su resguardante, puesto, área de asignación y ubicación física.',
                        ],
                        [
                            'question' => '¿Se conserva el historial cuando cambia el responsable?',
                            'answer' => 'Sí. INTEVI contempla historiales de asignación y liberación para consultar movimientos anteriores del resguardo.',
                        ],
                        [
                            'question' => '¿Se pueden agregar imágenes y documentos?',
                            'answer' => 'Sí. La plataforma permite relacionar imágenes y archivos PDF con procesos de ubicación y resguardo, de acuerdo con el módulo correspondiente.',
                        ],
                        [
                            'question' => '¿Podemos cargar información desde Excel?',
                            'answer' => 'La plataforma incluye carga masiva para determinados catálogos, como marcas, puestos y áreas de asignación.',
                        ],
                        [
                            'question' => '¿Todos los usuarios tienen el mismo acceso?',
                            'answer' => 'No. Los roles y permisos permiten organizar qué puede consultar o administrar cada usuario según sus responsabilidades.',
                        ],
                        [
                            'question' => '¿La información de las instituciones se mezcla?',
                            'answer' => 'No. Cada organización trabaja dentro de un entorno independiente con su propio acceso, usuarios e información.',
                        ],
                        [
                            'question' => '¿Hay que instalar INTEVI en cada computadora?',
                            'answer' => 'No. INTEVI funciona como una plataforma web y se utiliza mediante un navegador compatible con conexión a Internet.',
                        ],
                        [
                            'question' => '¿Qué incluye el precio del primer año?',
                            'answer' => 'Incluye la licencia anual dentro del alcance estándar, el entorno institucional, la metodología 5X, configuración inicial, orientación, tutoriales, asistente de preguntas frecuentes y mantenimiento de la plataforma. Los desarrollos especiales se cotizan por separado.',
                        ],
                        [
                            'question' => '¿Cuánto cuesta renovar?',
                            'answer' => 'El precio especial es de $250 USD durante el primer año. A partir del segundo año, la renovación anual es de $500 USD, dentro del alcance contratado.',
                        ],
                        [
                            'question' => '¿Cómo podemos conocer el sistema?',
                            'answer' => 'Solicita una demostración. Revisaremos la plataforma y podrás explicar las necesidades actuales de tu organización antes de decidir.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <article class="faq-item {{ $index === 0 ? 'open' : '' }}">
                        <button
                            class="faq-question"
                            type="button"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                        >
                            <span>{{ $faq['question'] }}</span>
                            <span class="faq-symbol" aria-hidden="true">+</span>
                        </button>

                        <div class="faq-answer">
                            <div>
                                <p>{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="cta" id="contacto">
        <div class="container cta-layout">
            <div class="cta-copy">
                <h2>
                    Descubre si INTEVI puede darte el control que hoy depende
                    de archivos, tiempo y conocimiento disperso.
                </h2>

                <p>
                    Solicita una demostración, conoce la plataforma y evalúa
                    cómo puede adaptarse al proceso de resguardos de tu
                    institución. Sin compromiso de contratación.
                </p>
            </div>

            <div class="cta-action">
                <button class="button button-light" type="button" data-open-chat>
                    Solicitar demostración

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </button>

                <a class="cta-email" href="{{ $demoMailto }}">
                    O escribe a {{ $contactEmail }}
                </a>
            </div>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#inicio" class="brand">
                    <img
                        src="{{ asset('images/intevi logo.png') }}"
                        alt=""
                        class="brand-logo"
                        width="52"
                        height="52"
                    >

                    <span class="brand-text">
                        <span class="brand-name">INTEVI</span>
                        <span class="brand-description">
                            Inventario y resguardo institucional
                        </span>
                    </span>
                </a>

                <p class="footer-description">
                    Gestión inteligente de resguardos e inventario de bienes
                    institucionales.
                </p>
            </div>

            <div>
                <h3 class="footer-heading">Plataforma</h3>
                <ul class="footer-links">
                    <li><a href="#metodo">Control 5X</a></li>
                    <li><a href="#plataforma">Funciones</a></li>
                    <li><a href="#implementacion">Implementación</a></li>
                    <li><a href="#oferta">Precio</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-heading">Contacto</h3>
                <ul class="footer-links">
                    <li><a href="{{ $demoMailto }}">{{ $contactEmail }}</a></li>
                    <li><a href="#preguntas">Preguntas frecuentes</a></li>
                    <li><a href="#contacto">Solicitar demostración</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© {{ now()->year }} INTEVI. Todos los derechos reservados.</p>
            <p class="footer-signature">Inventario Tecnológico Institucional</p>
        </div>
    </div>
</footer>

<div class="mobile-sticky-cta">
    <button class="button button-primary" type="button" data-open-chat>
        Solicitar demostración
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('menuButton');
        const navigation = document.getElementById('navigation');
        const navigationLinks = navigation.querySelectorAll('a');
        const chatButtons = document.querySelectorAll('[data-open-chat]');
        const faqQuestions = document.querySelectorAll('.faq-question');

        function closeMenu() {
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Abrir menú');
            navigation.classList.remove('mobile-visible');
            document.body.classList.remove('menu-open');
        }

        function openChat() {
            if (
                window.Tawk_API &&
                typeof window.Tawk_API.maximize === 'function'
            ) {
                window.Tawk_API.maximize();
                return;
            }

            window.location.href = @json($demoMailto);
        }

        menuButton.addEventListener('click', function () {
            const isOpen =
                menuButton.getAttribute('aria-expanded') === 'true';

            menuButton.setAttribute('aria-expanded', String(!isOpen));
            menuButton.setAttribute(
                'aria-label',
                isOpen ? 'Abrir menú' : 'Cerrar menú'
            );

            navigation.classList.toggle('mobile-visible', !isOpen);
            document.body.classList.toggle('menu-open', !isOpen);
        });

        navigationLinks.forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        chatButtons.forEach(function (button) {
            button.addEventListener('click', openChat);
        });

        faqQuestions.forEach(function (question) {
            question.addEventListener('click', function () {
                const item = question.closest('.faq-item');
                const isOpen = item.classList.contains('open');

                item.classList.toggle('open', !isOpen);
                question.setAttribute('aria-expanded', String(!isOpen));
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 940) {
                closeMenu();
            }
        });
    });
</script>

</body>
</html>
