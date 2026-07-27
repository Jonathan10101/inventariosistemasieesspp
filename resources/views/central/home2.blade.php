<!DOCTYPE html>
<html lang="es">
<head>

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>INTEVI | Resguardos e inventario institucional</title>

    <meta
        name="description"
        content="INTEVI centraliza el inventario, los resguardos, responsables, ubicaciones y movimientos de los bienes institucionales."
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
        $contactEmail =  'contacto.aned@gmail.com';
    @endphp

    <style>
        :root {
            --primary: #171c63;
            --primary-dark: #101447;
            --primary-soft: #eef0ff;
            --accent: #d5ad63;
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
            --alert-height: 58px;
        }

        .intevi-alert {
    background: #b42318;
    border-bottom: 1px solid #8f1c13;
    box-shadow: 0 8px 24px rgba(127, 29, 29, 0.18);
    color: #ffffff;
    left: 0;
    min-height: var(--alert-height);
    position: fixed;
    right: 0;
    top: var(--header-height);
    z-index: 99;
}

.intevi-alert-content {
    align-items: center;
    display: flex;
    justify-content: center;
    min-height: var(--alert-height);
    text-align: center;
}

.intevi-alert-message {
    align-items: center;
    display: flex;
    justify-content: center;
    gap: 12px;
    text-align: center;
    width: 100%;
}

.intevi-alert-message p {
    font-size: 14px;
    line-height: 1.45;
    margin: 0;
    text-align: center;
}

.intevi-alert-message strong {
    font-weight: 800;
    letter-spacing: 0.04em;
    margin-right: 5px;
}

.intevi-alert-icon {
    align-items: center;
    background: rgba(255, 255, 255, 0.14);
    display: flex;
    flex: 0 0 auto;
    height: 34px;
    justify-content: center;
    width: 34px;
}

.intevi-alert-icon svg {
    height: 19px;
    width: 19px;
}

.intevi-alert-close {
    align-items: center;
    background: transparent;
    border: 0;
    color: #ffffff;
    cursor: pointer;
    display: flex;
    flex: 0 0 auto;
    font-size: 27px;
    height: 38px;
    justify-content: center;
    opacity: 0.8;
    transition:
        background-color 180ms ease,
        opacity 180ms ease;
    width: 38px;
}

.intevi-alert-close:hover {
    background: rgba(255, 255, 255, 0.12);
    opacity: 1;
}

/* Baja el contenido para que no quede oculto por la alerta */
body.has-intevi-alert .hero {
    padding-top: calc(178px + var(--alert-height));
}

@media (max-width: 960px) {
    body.has-intevi-alert .hero {
        padding-top: calc(145px + var(--alert-height));
    }
}

@media (max-width: 720px) {
    :root {
        --alert-height: 72px;
    }

    .intevi-alert-message {
        gap: 9px;
    }

    .intevi-alert-message p {
        font-size: 12px;
    }

    .intevi-alert-icon {
        height: 30px;
        width: 30px;
    }

    body.has-intevi-alert .hero {
        padding-top: calc(126px + var(--alert-height));
    }
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

         .intevi-testimonios {
        position: relative;
        overflow: hidden;
        padding: 100px 20px;
        background:
            radial-gradient(
                circle at 10% 10%,
                rgba(23, 28, 99, 0.09),
                transparent 32%
            ),
            linear-gradient(180deg, #ffffff 0%, #f7f8fc 100%);
    }

    .intevi-testimonios::before {
        content: "";
        position: absolute;
        top: -180px;
        right: -180px;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: rgba(23, 28, 99, 0.04);
        pointer-events: none;
    }

    .intevi-testimonios-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .intevi-testimonios-header {
        max-width: 760px;
        margin: 0 auto 54px;
        text-align: center;
    }

    .intevi-testimonios-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        margin-bottom: 18px;
        padding: 7px 15px;
        border: 1px solid rgba(23, 28, 99, 0.14);
        border-radius: 999px;
        background: rgba(23, 28, 99, 0.06);
        color: #171c63;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .intevi-testimonios-header h2 {
        margin: 0;
        color: #11152f;
        font-size: clamp(34px, 5vw, 55px);
        font-weight: 850;
        line-height: 1.08;
        letter-spacing: -0.04em;
    }

    .intevi-testimonios-header p {
        max-width: 670px;
        margin: 22px auto 0;
        color: #62697b;
        font-size: 18px;
        line-height: 1.75;
    }

    .intevi-testimonios-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 26px;
    }

    .intevi-testimonio-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 410px;
        padding: 34px;
        overflow: hidden;
        border: 1px solid rgba(17, 21, 47, 0.09);
        border-radius: 26px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow:
            0 22px 60px rgba(23, 28, 99, 0.08),
            0 4px 14px rgba(17, 21, 47, 0.04);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .intevi-testimonio-card::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -100px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(23, 28, 99, 0.035);
        pointer-events: none;
    }

    .intevi-testimonio-card:hover {
        transform: translateY(-6px);
        border-color: rgba(23, 28, 99, 0.18);
        box-shadow:
            0 30px 75px rgba(23, 28, 99, 0.13),
            0 5px 18px rgba(17, 21, 47, 0.05);
    }

    .intevi-testimonio-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .intevi-testimonio-logo {
        flex: 0 0 62px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        border-radius: 18px;
        background: #171c63;
        color: #ffffff;
        box-shadow: 0 13px 30px rgba(23, 28, 99, 0.22);
        font-size: 20px;
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .intevi-testimonio-logo-red {
        background: #a71930;
        box-shadow: 0 13px 30px rgba(167, 25, 48, 0.2);
    }

    .intevi-testimonio-tipo {
        display: block;
        margin-bottom: 6px;
        color: #7a8192;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .intevi-testimonio-top h3 {
        margin: 0;
        color: #171a2f;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.3;
    }

    .intevi-testimonio-quote {
        position: relative;
        z-index: 1;
        flex: 1;
        margin-top: 35px;
        padding: 29px 25px 25px;
        border: 1px solid rgba(23, 28, 99, 0.07);
        border-radius: 19px;
        background: #f8f9fd;
    }

    .intevi-comillas {
        position: absolute;
        top: -19px;
        left: 20px;
        color: #171c63;
        font-family: Georgia, serif;
        font-size: 63px;
        font-weight: 700;
        line-height: 1;
    }

    .intevi-testimonio-quote p {
        margin: 0;
        color: #444b5e;
        font-size: 16px;
        line-height: 1.8;
    }

    .intevi-testimonio-footer {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-top: 28px;
    }

    .intevi-testimonio-footer strong,
    .intevi-testimonio-footer span {
        display: block;
    }

    .intevi-testimonio-footer strong {
        margin-bottom: 4px;
        color: #171a2f;
        font-size: 14px;
        font-weight: 850;
    }

    .intevi-testimonio-footer > div > span {
        color: #818798;
        font-size: 12px;
        line-height: 1.45;
    }

    .intevi-testimonio-verificado {
        display: inline-flex !important;
        align-items: center;
        flex: 0 0 auto;
        gap: 7px;
        color: #171c63;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .intevi-testimonio-verificado svg {
        width: 21px;
        height: 21px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .intevi-testimonios-nota {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 13px;
        max-width: 760px;
        margin: 38px auto 0;
        padding: 18px 22px;
        border: 1px solid rgba(23, 28, 99, 0.1);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.82);
    }

    .intevi-testimonios-nota-icono {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(23, 28, 99, 0.08);
        color: #171c63;
    }

    .intevi-testimonios-nota-icono svg {
        width: 22px;
        height: 22px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .intevi-testimonios-nota p {
        margin: 0;
        color: #5d6475;
        font-size: 14px;
        line-height: 1.6;
    }

    .tachado-equis {
    position: relative;
    display: inline-block;
    background: 
        linear-gradient(to top left, transparent 45%, rgba(255, 0, 0, 0.35) 45%, rgba(255, 0, 0, 0.35) 55%, transparent 55%),
        linear-gradient(to top right, transparent 45%, rgba(255, 0, 0, 0.35) 45%, rgba(255, 0, 0, 0.35) 55%, transparent 55%);
    background-size: 100% 100%;
    background-repeat: no-repeat;
    }

    .og-garantia {
        position: relative;
        overflow: hidden;
        padding: 90px 24px;
        background:
            radial-gradient(
                circle at 10% 50%,
                rgba(254, 213, 36, 0.12),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #0d103a 0%,
                #101447 48%,
                #171c63 100%
            );
    }

    .og-garantia::before {
        content: "";
        position: absolute;
        top: -180px;
        right: -120px;
        width: 420px;
        height: 420px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .og-garantia::after {
        content: "";
        position: absolute;
        right: 30px;
        bottom: -260px;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: rgba(254, 213, 36, 0.035);
    }

    .og-garantia-container {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: minmax(280px, 1fr) minmax(0, 2fr);
        align-items: center;
        gap: clamp(45px, 7vw, 95px);
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /*
    |--------------------------------------------------------------------------
    | Logo — aproximadamente 1/3
    |--------------------------------------------------------------------------
    */

    .og-garantia-visual {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .og-garantia-sello {
        position: relative;
        width: 100%;
        max-width: 360px;
        padding: 18px;
        border: 1px solid rgba(255, 255, 255, 0.13);
        border-radius: 50%;
        background: #ffffff;
        box-shadow:
            0 30px 70px rgba(0, 0, 0, 0.3),
            0 0 0 10px rgba(255, 255, 255, 0.035);
    }

    .og-garantia-sello::before {
        content: "";
        position: absolute;
        inset: -17px;
        z-index: -1;
        border: 1px dashed rgba(254, 213, 36, 0.28);
        border-radius: 50%;
    }

    .og-garantia-sello img {
        display: block;
        width: 100%;
        height: auto;
        border-radius: 50%;
        object-fit: contain;
    }

    /*
    |--------------------------------------------------------------------------
    | Contenido — aproximadamente 2/3
    |--------------------------------------------------------------------------
    */

    .og-garantia-contenido {
        max-width: 720px;
    }

    .og-garantia-etiqueta {
        display: inline-flex;
        align-items: center;
        min-height: 34px;
        margin-bottom: 18px;
        padding: 7px 15px;
        border: 1px solid rgba(254, 213, 36, 0.28);
        border-radius: 999px;
        background: rgba(254, 213, 36, 0.09);
        color: #fed524;
        font-size: 12px;
        font-weight: 850;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .og-garantia-contenido h2 {
        max-width: 680px;
        margin: 0;
        color: #ffffff;
        font-size: clamp(36px, 5vw, 60px);
        font-weight: 850;
        line-height: 1.08;
        letter-spacing: -0.045em;
    }

    .og-garantia-contenido h2 span {
        color: #fed524;
    }

    .og-garantia-descripcion {
        max-width: 650px;
        margin: 24px 0 0;
        color: rgba(255, 255, 255, 0.77);
        font-size: 18px;
        line-height: 1.75;
    }

    .og-garantia-beneficio {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-top: 30px;
        padding: 21px 22px;
        border: 1px solid rgba(255, 255, 255, 0.11);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .og-garantia-check {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fed524;
        color: #101447;
        box-shadow: 0 10px 25px rgba(254, 213, 36, 0.2);
    }

    .og-garantia-check svg {
        width: 23px;
        height: 23px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .og-garantia-beneficio p {
        margin: 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
        line-height: 1.7;
    }

    .og-garantia-beneficio strong {
        color: #ffffff;
        font-weight: 850;
    }

    .og-garantia-mensaje {
        margin: 25px 0 0;
        color: rgba(255, 255, 255, 0.75);
        font-size: 16px;
        line-height: 1.65;
    }

    .og-garantia-mensaje strong {
        color: #ffffff;
    }

    .og-garantia-boton {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 56px;
        margin-top: 28px;
        padding: 15px 25px;
        border: 1px solid #fed524;
        border-radius: 12px;
        background: #fed524;
        color: #101447;
        box-shadow: 0 14px 32px rgba(254, 213, 36, 0.2);
        font-size: 15px;
        font-weight: 850;
        text-decoration: none;
        transition:
            transform 0.22s ease,
            background-color 0.22s ease,
            box-shadow 0.22s ease;
    }

    .og-garantia-boton svg {
        width: 21px;
        height: 21px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: transform 0.22s ease;
    }

    .og-garantia-boton:hover {
        transform: translateY(-3px);
        background: #ffe35c;
        color: #101447;
        box-shadow: 0 18px 38px rgba(254, 213, 36, 0.27);
        text-decoration: none;
    }

    .og-garantia-boton:hover svg {
        transform: translateX(4px);
    }

    .og-garantia-terminos {
        display: block;
        max-width: 620px;
        margin-top: 18px;
        color: rgba(255, 255, 255, 0.48);
        font-size: 11px;
        line-height: 1.6;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 900px) {
        .og-garantia {
            padding: 75px 20px;
        }

        .og-garantia-container {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .og-garantia-sello {
            max-width: 310px;
        }

        .og-garantia-contenido {
            max-width: 760px;
            margin: 0 auto;
            text-align: center;
        }

        .og-garantia-descripcion,
        .og-garantia-contenido h2,
        .og-garantia-terminos {
            margin-right: auto;
            margin-left: auto;
        }

        .og-garantia-beneficio {
            max-width: 680px;
            margin-right: auto;
            margin-left: auto;
            text-align: left;
        }
    }

    @media (max-width: 560px) {
        .og-garantia {
            padding: 60px 16px;
        }

        .og-garantia-container {
            gap: 38px;
        }

        .og-garantia-sello {
            max-width: 255px;
            padding: 12px;
        }

        .og-garantia-contenido h2 {
            font-size: 36px;
        }

        .og-garantia-descripcion {
            font-size: 16px;
        }

        .og-garantia-beneficio {
            padding: 18px;
        }

        .og-garantia-boton {
            width: 100%;
        }
    }



    @media (max-width: 850px) {
        .intevi-testimonios {
            padding: 78px 18px;
        }

        .intevi-testimonios-grid {
            grid-template-columns: 1fr;
        }

        .intevi-testimonio-card {
            min-height: auto;
        }
    }

    @media (max-width: 560px) {
        .intevi-testimonios {
            padding: 65px 15px;
        }

        .intevi-testimonios-header {
            margin-bottom: 38px;
        }

        .intevi-testimonios-header p {
            font-size: 16px;
        }

        .intevi-testimonio-card {
            padding: 24px;
            border-radius: 22px;
        }

        .intevi-testimonio-top {
            align-items: flex-start;
        }

        .intevi-testimonio-logo {
            flex-basis: 54px;
            width: 54px;
            height: 54px;
            border-radius: 15px;
            font-size: 17px;
        }

        .intevi-testimonio-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .intevi-testimonios-nota {
            align-items: flex-start;
        }
    }
    

        /* ================================================================
           INTEVI V2 · Página de ventas de respuesta directa
           ================================================================ */
        .og-section { padding: 108px 0; }
        .og-soft { background: #f6f7f9; }
        .og-warm { background: #f4f1eb; }
        .og-dark { background: #101447; color: #fff; }
        .og-kicker { display:inline-flex; align-items:center; gap:10px; margin-bottom:18px; color:#171c63; font-size:12px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        .og-kicker::before { content:""; width:28px; height:2px; background:#d5ad63; }
        .og-dark .og-kicker { color:#d5d9ff; }
        .og-title { font-family:'Manrope',sans-serif; font-size:clamp(34px,4.2vw,58px); line-height:1.06; letter-spacing:-.05em; font-weight:800; }
        .og-title-sm { font-size:clamp(29px,3.4vw,46px); }
        .og-copy { color:#555968; font-size:18px; line-height:1.78; }
        .og-dark .og-copy { color:rgba(255,255,255,.7); }
        .og-center { max-width:820px; margin:0 auto 54px; text-align:center; }
        .og-center .og-copy { max-width:680px; margin:20px auto 0; }
        .og-highlight { color:#171c63; }
        .og-dark .og-highlight { color:#e2c58c; }

        /* 1. Hero */
        .og-hero { min-height:900px; padding:175px 0 105px; background:radial-gradient(circle at 83% 20%,rgba(213,173,99,.16),transparent 24%),linear-gradient(180deg,#fff,#f6f7fa); overflow:hidden; position:relative; }
        .og-hero::after { content:""; position:absolute; width:620px; height:620px; right:-260px; top:90px; border:1px solid rgba(23,28,99,.06); transform:rotate(14deg); }
        .og-hero-grid { display:grid; grid-template-columns:minmax(390px,.88fr) minmax(570px,1.12fr); gap:54px; align-items:center; }
        .og-hero-copy { position:relative; z-index:2; }
        .og-pill { display:inline-flex; align-items:center; gap:9px; padding:9px 13px; border:1px solid #e4e5e9; background:#fff; color:#171c63; font-size:11px; font-weight:800; letter-spacing:.09em; text-transform:uppercase; margin-bottom:26px; }
        .og-pill::before { content:""; width:7px; height:7px; border-radius:50%; background:#14745a; box-shadow:0 0 0 4px rgba(20,116,90,.1); }
        .og-hero h1 { font-family:'Manrope',sans-serif; font-size:clamp(46px,5.7vw,75px); font-weight:800; letter-spacing:-.06em; line-height:.98; }
        .og-hero h1 span { color:#171c63; }
        .og-hero-lead { max-width:650px; margin-top:28px; color:#414553; font-size:19px; line-height:1.72; }
        .og-actions { display:flex; flex-wrap:wrap; gap:14px; margin-top:37px; }
        .og-note { display:flex; align-items:flex-start; gap:9px; margin-top:22px; color:#747885; font-size:13px; }
        .og-note::before { content:"✓"; color:#14745a; font-weight:900; }
        .og-browser { position:relative; width:108%; filter:drop-shadow(0 35px 70px rgba(22,27,67,.17)); z-index:2; }
        .og-browser-label { position:absolute; left:-18px; top:38px; z-index:4; padding:11px 16px; background:#171c63; color:#fff; font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; box-shadow:0 12px 30px rgba(23,28,99,.24); }
        .og-browser-frame { overflow:hidden; border:1px solid rgba(23,28,99,.13); background:#fff; box-shadow:0 40px 90px rgba(22,27,67,.18); }
        .og-browser-top { display:grid; grid-template-columns:auto minmax(0,1fr) auto; gap:16px; align-items:center; min-height:52px; padding:0 16px; border-bottom:1px solid #e6e8ee; background:linear-gradient(#fff,#f7f8fb); }
        .og-dots { display:flex; gap:7px; }.og-dots i { width:8px; height:8px; border-radius:50%; background:#d4d7df; }
        .og-address { justify-self:center; width:100%; max-width:340px; padding:7px 12px; background:#eff1f6; color:#777c8b; font-size:10px; text-align:center; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .og-browser-screen { aspect-ratio:1915/920; overflow:hidden; background:#edf0f5; }.og-browser-screen img { width:100%; height:100%; object-fit:cover; object-position:center top; }
        .og-float { position:absolute; right:-20px; bottom:-28px; z-index:4; width:220px; padding:17px 20px; border:1px solid #e4e5e9; background:rgba(255,255,255,.97); box-shadow:0 20px 50px rgba(22,27,67,.14); }
        .og-float small { display:block; color:#767a87; font-size:9px; font-weight:800; letter-spacing:.09em; text-transform:uppercase; }.og-float strong { display:block; margin-top:6px; color:#14745a; font-size:13px; }

        /* 2. Declaración */
        .og-impact { padding:82px 0; background:#171c63; color:#fff; }
        .og-impact-grid { display:grid; grid-template-columns:.55fr 1.45fr; gap:50px; align-items:center; }
        .og-impact-label { color:#d8dcff; font-size:12px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        .og-impact-copy { font-family:'Manrope',sans-serif; font-size:clamp(30px,4vw,51px); line-height:1.18; letter-spacing:-.045em; font-weight:700; }.og-impact-copy span { color:#e0c38a; }

        /* 3. PAS */
        .og-pas-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; margin-top:50px; }
        .og-pas-card { position:relative; min-height:390px; padding:36px; border:1px solid #e4e5e9; background:#fff; }
        .og-pas-card::before { content:""; position:absolute; left:36px; top:0; width:72px; height:4px; background:#d5ad63; }
        .og-step { color:#9d783a; font-size:11px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }
        .og-pas-card h3 { margin-top:24px; font-family:'Manrope',sans-serif; font-size:24px; line-height:1.2; letter-spacing:-.03em; }
        .og-pas-card p { margin-top:17px; color:#666b79; font-size:15px; line-height:1.75; }
        .og-list { display:grid; gap:11px; margin-top:22px; list-style:none; }.og-list li { display:flex; gap:10px; color:#343746; font-size:14px; }.og-list li::before { content:""; flex:0 0 auto; width:6px; height:6px; margin-top:9px; background:#171c63; }
        .og-big-question { margin-top:42px; padding:34px 38px; border-left:4px solid #d5ad63; background:#f4f1eb; font-family:'Manrope',sans-serif; font-size:clamp(24px,3.2vw,38px); font-weight:700; line-height:1.25; letter-spacing:-.035em; }

        /* 4. Solución */
        .og-solution-grid { display:grid; grid-template-columns:1.02fr .98fr; gap:78px; align-items:center; }
        .og-product-card { padding:28px; border:1px solid #e4e5e9; background:#fff; box-shadow:0 18px 48px rgba(18,24,61,.09); }
        .og-mini-head { height:44px; border:1px solid #e4e5e9; border-bottom:0; background:#f7f8fa; }.og-mini-body { padding:32px; border:1px solid #e4e5e9; background:linear-gradient(135deg,rgba(23,28,99,.04),transparent 55%),#fff; }
        .og-mini-brand { display:flex; align-items:center; gap:14px; }.og-mini-logo { display:flex; align-items:center; justify-content:center; width:48px; height:48px; background:#171c63; color:#fff; font-family:'Manrope'; font-weight:800; }.og-mini-brand small { display:block; color:#767a87; font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }.og-mini-brand strong { display:block; margin-top:3px; font-family:'Manrope'; font-size:18px; }
        .og-metrics { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-top:27px; }.og-metric { padding:19px; border:1px solid #e4e5e9; background:#f6f7f9; }.og-metric small { display:block; color:#767a87; font-size:9px; font-weight:800; letter-spacing:.09em; text-transform:uppercase; }.og-metric strong { display:block; margin-top:5px; color:#171c63; font-family:'Manrope'; font-size:21px; }
        .og-checks { display:grid; gap:16px; margin-top:30px; }.og-check { display:flex; gap:13px; align-items:flex-start; }.og-check-icon { display:flex; align-items:center; justify-content:center; flex:0 0 auto; width:31px; height:31px; background:#eef0ff; color:#171c63; font-weight:900; }.og-check strong { display:block; font-size:15px; }.og-check p { color:#666b79; font-size:14px; }

        /* 5. Curiosidad */
        .og-benefits { display:grid; grid-template-columns:repeat(2,1fr); gap:1px; border:1px solid #e4e5e9; background:#e4e5e9; }
        .og-benefit { min-height:205px; padding:31px; background:#fff; transition:.18s ease; }.og-benefit:hover { position:relative; z-index:2; transform:translateY(-4px); box-shadow:0 24px 70px rgba(18,24,61,.13); }
        .og-benefit small { color:#9d783a; font-size:11px; font-weight:800; letter-spacing:.09em; }.og-benefit h3 { margin-top:18px; font-family:'Manrope'; font-size:21px; line-height:1.25; letter-spacing:-.025em; }.og-benefit p { margin-top:12px; color:#666b79; font-size:14px; line-height:1.7; }

        /* 6. Credibilidad */
        .og-cred-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1px; margin-top:48px; border:1px solid rgba(255,255,255,.13); background:rgba(255,255,255,.13); }
        .og-cred { min-height:225px; padding:28px; background:rgba(255,255,255,.035); }.og-cred-icon { display:flex; align-items:center; justify-content:center; width:45px; height:45px; background:rgba(255,255,255,.09); color:#e0c38a; font-size:20px; }.og-cred h3 { margin-top:23px; font-family:'Manrope'; font-size:18px; line-height:1.25; }.og-cred p { margin-top:11px; color:rgba(255,255,255,.65); font-size:14px; }

        /* 7. Evidencia */
        .og-evidence { display:grid; grid-template-columns:1.15fr .85fr; gap:23px; }
        .og-evidence-main { overflow:hidden; border:1px solid #e4e5e9; background:#fff; box-shadow:0 16px 45px rgba(18,24,61,.08); }.og-evidence-main img { width:100%; aspect-ratio:1915/920; object-fit:cover; object-position:center top; }.og-evidence-caption { padding:27px 29px; }.og-evidence-caption small { color:#9d783a; font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }.og-evidence-caption h3 { margin-top:7px; font-family:'Manrope'; font-size:23px; }.og-evidence-caption p { margin-top:9px; color:#666b79; font-size:14px; }
        .og-evidence-list { display:grid; gap:13px; }.og-proof { padding:22px; border:1px solid #e4e5e9; background:#fff; }.og-proof h3 { display:flex; align-items:center; gap:10px; font-family:'Manrope'; font-size:17px; }.og-proof h3::before { content:"✓"; display:flex; align-items:center; justify-content:center; width:30px; height:30px; background:rgba(20,116,90,.1); color:#14745a; }.og-proof p { margin-top:9px; color:#666b79; font-size:13px; }

        /* 8. Oferta */
        .og-offer { display:grid; grid-template-columns:.88fr 1.12fr; gap:23px; }
        .og-cost { padding:41px; background:#101447; color:#fff; }.og-cost small { color:#d8dcff; font-size:11px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }.og-cost h3 { margin-top:17px; font-family:'Manrope'; font-size:clamp(29px,3.5vw,43px); line-height:1.12; letter-spacing:-.045em; }.og-cost .og-list li { padding-bottom:13px; border-bottom:1px solid rgba(255,255,255,.12); color:rgba(255,255,255,.72); }.og-cost .og-list li::before { background:#d5ad63; }
        .og-offer-card { padding:43px; border:1px solid #e4e5e9; background:#fff; box-shadow:0 28px 80px rgba(18,24,61,.13); }.og-offer-badge { display:inline-flex; padding:8px 11px; background:#f8f0df; color:#9d783a; font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }.og-offer-card h3 { margin-top:21px; font-family:'Manrope'; font-size:clamp(30px,3.6vw,45px); line-height:1.08; letter-spacing:-.047em; }.og-offer-card>p { margin-top:17px; color:#666b79; font-size:16px; line-height:1.75; }
        .og-includes { display:grid; grid-template-columns:repeat(2,1fr); gap:11px; margin-top:26px; }.og-include { padding:15px; border:1px solid #e4e5e9; background:#f6f7f9; color:#343746; font-size:13px; font-weight:700; }.og-include::before { content:"✓"; margin-right:8px; color:#14745a; font-weight:900; }
        .og-price { display:flex; align-items:center; justify-content:space-between; gap:25px; margin-top:28px; padding-top:26px; border-top:1px solid #e4e5e9; }.og-price small { display:block; color:#767a87; font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }.og-price strong { display:block; margin-top:3px; color:#171c63; font-family:'Manrope'; font-size:24px; }

        /* 9. Bonos */
        .og-bonus-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:19px; }.og-bonus { min-height:270px; padding:26px; border:1px solid #e4e5e9; background:#fff; }.og-bonus-num { display:flex; align-items:center; justify-content:center; width:38px; height:38px; background:#171c63; color:#fff; font-family:'Manrope'; font-size:12px; font-weight:800; }.og-bonus h3 { margin-top:21px; font-family:'Manrope'; font-size:18px; line-height:1.25; }.og-bonus p { margin-top:11px; color:#666b79; font-size:13px; line-height:1.67; }.og-bonus-note { margin-top:26px; padding:16px 19px; border-left:4px solid #d5ad63; background:#f8f0df; color:#5c4927; font-size:13px; }

        /* 10. Garantía */
        .og-guarantee { padding:92px 0; background:radial-gradient(circle at 12% 5%,rgba(213,173,99,.15),transparent 28%),#171c63; color:#fff; }.og-guarantee-grid { display:grid; grid-template-columns:.85fr 1.15fr; gap:68px; align-items:center; }.og-seal { display:flex; align-items:center; justify-content:center; min-height:330px; border:1px solid rgba(255,255,255,.22); position:relative; }.og-seal::before,.og-seal::after { content:""; position:absolute; inset:23px; border:1px solid rgba(255,255,255,.12); transform:rotate(6deg); }.og-seal::after { transform:rotate(-6deg); }.og-seal-inner { position:relative; z-index:2; max-width:250px; text-align:center; }.og-seal-icon { display:flex; align-items:center; justify-content:center; width:72px; height:72px; margin:0 auto; background:rgba(255,255,255,.09); color:#e0c38a; font-size:30px; }.og-seal strong { display:block; margin-top:19px; font-family:'Manrope'; font-size:20px; line-height:1.2; }.og-guarantee-points { display:grid; grid-template-columns:repeat(2,1fr); gap:11px; margin-top:26px; }.og-guarantee-points span { color:rgba(255,255,255,.78); font-size:14px; }.og-guarantee-points span::before { content:"✓"; margin-right:8px; color:#e0c38a; font-weight:900; }

        /* 11. FAQ */
        .og-faq-layout { display:grid; grid-template-columns:.7fr 1.3fr; gap:68px; }.og-faq-intro { align-self:start; position:sticky; top:120px; }.og-faq-intro p { margin-top:17px; color:#666b79; }
        .og-faq-list { border-top:1px solid #e4e5e9; }.og-faq-item { border-bottom:1px solid #e4e5e9; }.og-faq-q { display:flex; align-items:center; justify-content:space-between; gap:22px; width:100%; padding:23px 0; border:0; background:transparent; color:#171923; font-family:'Manrope'; font-size:18px; font-weight:700; text-align:left; cursor:pointer; }.og-faq-plus { display:flex; align-items:center; justify-content:center; flex:0 0 auto; width:34px; height:34px; border:1px solid #e4e5e9; color:#171c63; transition:.2s ease; }.og-faq-item.active .og-faq-plus { background:#171c63; color:#fff; transform:rotate(45deg); }.og-faq-a { max-height:0; overflow:hidden; transition:max-height .28s ease; }.og-faq-a p { padding:0 55px 24px 0; color:#666b79; font-size:15px; line-height:1.75; }

        /* 12. Cierre */
        .og-close { padding:100px 0; background:linear-gradient(90deg,rgba(213,173,99,.1),transparent 38%),#0c0f30; color:#fff; }.og-close-grid { display:flex; justify-content:space-between; align-items:center; gap:68px; }.og-close-copy { max-width:760px; }.og-close h2 { font-family:'Manrope'; font-size:clamp(37px,4.9vw,62px); line-height:1.02; letter-spacing:-.055em; }.og-close p { max-width:660px; margin-top:20px; color:rgba(255,255,255,.72); font-size:17px; line-height:1.75; }.og-close-actions { display:flex; flex:0 0 auto; flex-direction:column; gap:11px; min-width:275px; }.og-close-actions small { color:rgba(255,255,255,.55); text-align:center; }
        .button-outline-light { border-color:rgba(255,255,255,.28); color:#fff; }.button-outline-light:hover { background:rgba(255,255,255,.08); border-color:rgba(255,255,255,.55); color:#fff; }

        @media(max-width:1100px){.og-hero-grid{grid-template-columns:minmax(360px,.86fr) minmax(510px,1.14fr)}.og-cred-grid{grid-template-columns:repeat(2,1fr)}.og-bonus-grid{grid-template-columns:repeat(3,1fr)}}
        @media(max-width:940px){.og-section{padding:88px 0}.og-hero{min-height:auto;padding:145px 0 90px}.og-hero-grid,.og-solution-grid,.og-guarantee-grid,.og-faq-layout{grid-template-columns:1fr}.og-browser{width:100%;max-width:760px;margin:12px auto 0}.og-impact-grid{grid-template-columns:1fr}.og-pas-grid{grid-template-columns:1fr}.og-pas-card{min-height:auto}.og-evidence,.og-offer{grid-template-columns:1fr}.og-bonus-grid{grid-template-columns:repeat(2,1fr)}.og-faq-intro{position:static}.og-close-grid{align-items:flex-start;flex-direction:column}.og-close-actions{width:min(100%,420px)}}
        @media(max-width:720px){.og-hero{padding-top:128px}.og-hero h1{font-size:clamp(41px,12vw,58px)}.og-hero-lead{font-size:17px}.og-actions{align-items:stretch;flex-direction:column}.og-actions .button{width:100%}.og-browser-top{grid-template-columns:auto minmax(0,1fr)}.og-browser-label{left:-8px}.og-float{right:8px}.og-benefits,.og-includes,.og-guarantee-points{grid-template-columns:1fr}.og-cred-grid,.og-bonus-grid{grid-template-columns:1fr}.og-offer-card,.og-cost{padding:31px 25px}.og-price{align-items:flex-start;flex-direction:column}.og-price .button{width:100%}.og-close-actions,.og-close-actions .button{width:100%}}
        @media(max-width:480px){.og-section{padding:74px 0}.og-float{display:none}.og-big-question{padding:27px 23px}.og-product-card{padding:14px}.og-mini-body{padding:24px 19px}.og-faq-a p{padding-right:0}}

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
    <!--        
    <a href="{{ url('/') }}" class="brand">
        <img
            src="{{ asset('images/intevi logo.png') }}"
            alt="Logo de INTEVI"
            class="brand-logo"
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
                <li>
                    <a class="nav-link" href="#solucion">
                        Solución
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#funciones">
                        Funciones
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#como-funciona">
                        Cómo funciona
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#instituciones">
                        Instituciones
                    </a>
                </li>
            </ul>

            <a class="button button-primary nav-cta" href="#contacto">
                Solicitar demostración
            </a>
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
    -->

    <div
    class="intevi-alert"
    id="inteviAlert"
    role="alert"
    aria-live="polite"
>
    <div class="container intevi-alert-content">
    <div class="intevi-alert-message">
        <span class="intevi-alert-iconQUITARMAYUSCULAS" aria-hidden="true">
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M12 3 2 21h20L12 3Z"/>
                <path d="M12 9v5"/>
                <path d="M12 18h.01"/>
            </svg>
        </span>

        <p>
            <strong style="text-decoration: underline;">🚨 ATENCIÓN:</strong>
            Institutos de gobierno y empresas. 🚨
        </p>
    </div>
    </div>
</div>

</header>

<main>
    {{-- 1. CAPTAR LA ATENCIÓN --}}
    {{-- 
    <section class="og-hero" id="inicio">
        <div class="container og-hero-grid">
            <div class="og-hero-copy">
                <!--
                <span class="og-pill">Control institucional de bienes</span>
                -->
                <!--
                <h1>Recupera el control de los bienes <span>de tu institución.</span></h1>
                <p class="og-hero-lead">
                    Centraliza el inventario, identifica dónde se encuentra cada bien y consulta quién es su responsable desde una sola plataforma diseñada para organismos gubernamentales.
                </p>
                -->
                <h1 style="font-size:40px;">Cómo llevar control de tus resguardos ahorrando <span style="color:red;">tiempo, esfuerzo y estrés</span> desde <span style="color:red;"> el primer mes</span>, utilizando un sistema sin importar si sabes usar una computadora,<span style="color:red;"> comenzando desde cero.</span></h1>
                <p class="og-hero-lead">
                    Esto funciona incluso si no eres un experto usando sistemas o no sabes usar bien una computadora.
                </p>

                <div class="og-actions">
                    <a class="button button-primary" style="background:red;" href="#contacto">
                        SOLICITAR UNA DEMOSTRACIÓN GRATIS
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <!--
                    <a class="button button-outline" href="#solucion">Conocer cómo funciona</a>
                    -->
                </div>
                <p class="og-note">Conoce primero la plataforma. Después evalúa si responde a las necesidades de tu institución. Sin compromiso de contratación.</p>
            </div>

            <div class="og-browser">
                <!--
                <iframe width="560" height="315" src="https://www.youtube.com/embed/jNQXAC9IVRw?si=z7OVEJo5EyEY0zv-&amp;start=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                -->
                <!--
                <span class="og-browser-label">Vista real de INTEVI</span>
                <div class="og-browser-frame">
                    <div class="og-browser-top">
                        <div class="og-dots"><i></i><i></i><i></i></div>
                        <div class="og-address">tuinstitucion.intevi.app/inventario</div>
                        <div class="og-dots"><i></i><i></i><i></i></div>
                    </div>
                    <div class="og-browser-screen">
                        <img src="{{ asset('images/intevi-dashboard.webp') }}" alt="Vista real del sistema INTEVI" width="1915" height="920" loading="eager" fetchpriority="high">
                    </div>
                </div>
                <div class="og-float"><small>Información institucional</small><strong>Inventario centralizado</strong></div>
                -->
            </div>
        </div>
    </section>
    --}}

    <section class="og-hero" id="inicio" style="width:100%;">
        <div class="og-hero-grid"
            style="
                display:block;
                width:100%;
                max-width:100%;
                margin:0 auto;
                padding-left:5%;
                padding-right:5%;
            ">

            <div class="og-hero-copy"
                style="
                    width:100%;
                    max-width:1300px;
                    margin:0 auto;
                    text-align:center;
                ">

                <h1 style="
                    width:100%;
                    max-width:none;
                    margin-left:auto;
                    margin-right:auto;
                    font-size:clamp(32px, 4vw, 52px);
                    line-height:1.15;
                ">
                    Cómo llevar control de tus resguardos ahorrando
                    <span style="color:red;">tiempo, esfuerzo y estrés</span>
                    desde <span style="color:red;">el primer mes</span>,
                    utilizando un sistema sin importar si sabes usar una computadora,
                    <span style="color:red;">comenzando desde cero.</span>
                </h1>

                <p class="og-hero-lead"
                style="
                        max-width:900px;
                        margin-left:auto;
                        margin-right:auto;
                ">
                    Esto funciona incluso si no eres un experto usando sistemas o no sabes usar bien una computadora.
                </p>

                <div class="og-actions"
                    style="
                        display:flex;
                        justify-content:center;
                        width:100%;
                    ">
                    <a class="button button-primary"
                    style="background:red;"
                    href="#contacto">

                        SOLICITAR UNA DEMOSTRACIÓN GRATIS

                        <svg viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>

                <p class="og-note"
                style="
                        max-width:850px;
                        margin-left:auto;
                        margin-right:auto;
                ">
                    Conoce primero la plataforma. Después evalúa si responde a las necesidades de tu institución. Sin compromiso de contratación.
                </p>

            </div>
        </div>
    </section>

    {{-- 2. DECLARACIÓN IMPACTANTE --}}
    <section class="og-impact" style="background:#F8F8FB;">
        <div class="container og-impact-grid">
            <!--
            <span class="og-impact-label" style="color:black;">Una realidad administrativa</span>
            -->
            <span class="og-impact-label" style="color:black;"></span>
            <p class="og-impact-copy" style="color:black;">¿Sabías que un bien que no puede localizarse, comprobarse o relacionarse con un responsable <span style="text-decoration: underline;color:black;">no está realmente bajo control?</span></p>
        </div>
        <div class="container og-impact-grid">
            <span class="og-impact-label"></span>
            <p class="og-impact-label" style="font-size:20px;margin-top:40px;text-transform: none !important;color:black;">Un día cuando trabajaba en Gobierno del Estado e iban a hacer cambio de administración cambio mi vida. Pude darme cuenta que mucha gente esta estresada por llevar el control de los resguardos institucionales. Pasé de tener un inventario en muchas hojas con mucho caos, a tener un<span style="text-decoration: underline;"> inventario y resguardos con orden, control y sin estrés.</span></p>
        </div>
    </section>


    {{-- 3. PROBLEMA, AGITACIÓN Y RESPUESTA --}}
    <section class="og-section og-soft" id="solucion">
        <div class="container">
            <div class="og-center">
                <!--
                <span class="og-kicker">El Problema</span>
                -->
                <h2 class="og-title og-title-sm" style="color:red;">Este es el problema que tienes...</h2>

                <h2 class="og-title og-title-sm" style="margin-top:50px;">Piensas que al tener muchos bienes es muy difícil llevar control de todos los resguardos.</h2>
                <h2 class="og-title og-title-sm" style="margin-top:50px;">Lo que significa que nunca podras tener un control exitoso de tus resguardos y seguiras viviendo el resto de tu vida con el estrés de una auditoria y de ser despedido en cualquier momento.</h2>
                <h2 class="og-title og-title-sm" style="margin-top:50px;">Perderás mucho tiempo y esfuerzo de personas intentando hacer estrategias que no funcionan y que lo único que harán es que regreses a sufrir y tener un dolor de cabeza por el estrés de una auditoria o de no saber exactamente en donde se ubica cada bien institucional.</h2>

                <!--
                <span class="og-highlight">Es no contar con información confiable sobre ellos.</span></h2>
                <p class="og-copy">Cuando la información depende de archivos dispersos, documentos físicos y conocimiento individual, una consulta sencilla puede convertirse en horas de búsqueda.</p>
                -->    
            </div>

            <!--
            <div class="og-pas-grid">
                <article class="og-pas-card">
                    <span class="og-step">01 · El problema</span>
                    <h3>La información está fragmentada</h3>
                    <p>El inventario se reparte entre hojas de cálculo, formatos impresos, correos y equipos de diferentes áreas.</p>
                    <ul class="og-list"><li>Versiones diferentes del mismo listado.</li><li>Bienes sin ubicación documentada.</li><li>Resguardos difíciles de localizar.</li><li>Datos que dependen de una persona.</li></ul>
                </article>
                <article class="og-pas-card">
                    <span class="og-step">02 · El riesgo</span>
                    <h3>Cada revisión expone la falta de control</h3>
                    <p>El personal debe revisar carpetas, comparar archivos, llamar a otras áreas y reconstruir movimientos manualmente.</p>
                    <ul class="og-list"><li>Más tiempo administrativo.</li><li>Registros duplicados o incompletos.</li><li>Dificultad para comprobar responsables.</li><li>Correcciones de última hora.</li></ul>
                </article>
                <article class="og-pas-card">
                    <span class="og-step">03 · La solución</span>
                    <h3>La institución necesita una fuente central</h3>
                    <p>INTEVI organiza los bienes, responsables, áreas, ubicaciones y resguardos en un mismo entorno institucional.</p>
                    <ul class="og-list"><li>Consulta centralizada.</li><li>Responsabilidad definida.</li><li>Ubicación identificada.</li><li>Acceso según roles y permisos.</li></ul>
                </article>
            </div>
            
            <p class="og-big-question">¿Dónde está este bien, quién lo tiene asignado y qué información respalda su resguardo?</p>
            -->        
        </div>
    </section>

    <section class="og-impact" style="background:red;">
        <div class="container og-impact-grid">
            <span class="og-impact-label"></span>
            <p class="og-impact-copy">Afortunadamente para ti, hay una solución...</p>
        </div>
    </section>
    <div class="container">
            <div class="og-center">
                <p style="font-size:42px; margin-top:35px;">Déjame presentarte a <span style="font-weight:bold;">INTEVI</span></p>
            </div>
            <div class="og-browser">
                <div class="og-browser-screen">
                    <img
                        src="{{ asset('images/intevi-presentacion-producto3.png') }}"
                        alt="Vista real del sistema INTEVI"
                        width="1915"
                        height="920"
                        loading="eager"s
                        fetchpriority="high"
                        style="
                            display: block !important;
                            width: 100% !important;
                            max-width: 1100px !important;
                            height: auto !important;
                            max-height: none !important;
                            margin: 0 auto !important;
                            object-fit: contain !important;
                            object-position: center !important;
                        "
                    >
                </div>
                <!--
                <span class="og-browser-label">Vista real de INTEVI</span>
                <div class="og-browser-frame">
                    <div class="og-browser-top">
                        <div class="og-dots"><i></i><i></i><i></i></div>
                        <div class="og-address">tuinstitucion.intevi.app/inventario</div>
                        <div class="og-dots"><i></i><i></i><i></i></div>
                    </div>
                    <div class="og-browser-screen">
                        <img src="{{ asset('images/intevi-presentacion-producto.png') }}" alt="Vista real del sistema INTEVI" width="1915" height="920" loading="eager" fetchpriority="high">
                    </div>
                -->
                </div>
                
                <h2 class="og-title og-title-sm" style="margin-top:40px;">Una plataforma completamente nueva que le permite a las organizaciones que quieran llevar control de sus resguardos <span style="text-decoration: underline;color:black;"> incrementar el control de sus bienes, saber dónde están y quién los tiene desde el primer mes,</span> con un sistema fácil de usar, incluso si nunca antes has utilizado uno, empezando desde cero.</h2>
                <div class="og-checks">
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Registro completo de bienes, lo que significa que tendras la información muy fácil y rápido de la descripción, marca, serie, características, estado y datos de identificación.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Resguardos y responsables, lo que significa relación clara entre el activo, la persona y el área que lo utiliza o custodia.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Ubicación sencilla de resguardos con códigos escaneables, lo que significa que desde la plataforma tendras la opción de generar etiquetas para pegarlas en tus resguardos y poder escanearlas sabiendo rápidamente a quien le pertenece dicho resguardo.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Implementación sencilla, lo que significa que no tendras que preocuparte de instalar muchas cosas en tu computadora ya que la plataforma funciona desde cualquier navegador web.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Entorno independiente por institución, lo que significa que cada organismo opera con su propio acceso, usuarios e información.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><p>Olvidate el mantenimiento, lo que significa que no tendras que preocuparte por hacer mantenimiento a la plataforma ya que nosotros desde forma remota lo hacemos para mantener todo funcionando: tu solo usas la plataforma y listo, sin preocuparte por todo lo demás.</p></div></div>
                </div>
                <div style="margin-top:50px;">
                    <p>Hola, soy Jonathan Bedolla informático y creador de productos digitales.</p><br>
                    <p><b>¿Porqué yo para solucionar este problema?</b></p><br>
                    <p>Es muy simple de entender, cuando trabaje casi durante dos años en un Instituto de Gobierno, me di cuenta que lograr llevar el control de los resguardos institucionales, fue algo casi que imposible.</p><br>
                    <p>Justo cuando iba darme por vencido y veia a mis compañeros que estaban muy estresados, me llego la idea de una solución mientras tomaba una ducha por la noche.</p><br>    
                    <p>Gracias a esa idea tengo hasta el momento un producto que soluciona el problema de llevar el control de los resguardos institucionales de las organizaciones.</p><br>
                    <p>No fue por suerte ni por casualidad. Ha sido el resultado de <b>meses de trabajo y aplicación del método Resguardos Fáciles de controlar 5X</b>, inspirado en la solución de otros problemas por medio de software.</p><br>
                </div>
            </div>
    </div>
{{--    
    <section class="og-impact" style="background:red;">
        <div class="container og-impact-grid">
            <span class="og-impact-label"></span>
            <p style="font-size:30px;">Yo sé que todo lo que te he mostrado suena muy bueno para ser cierto, pero no quiero que te limites a creer mi palabra. Simplemente echa un vistazo a esto...</p>
        </div>
    </section>


<section class="intevi-testimonios" id="testimonios">
    <div class="intevi-testimonios-container">

        <div class="intevi-testimonios-header">
            <span class="intevi-testimonios-label">
                Evidencia de pruebas institucionales
            </span>

            <h2>
                INTEVI probado en entornos reales
            </h2>

            <p>
                Instituciones han conocido y probado la plataforma para evaluar
                su funcionamiento en procesos de inventario, control de bienes
                y generación de resguardos.
            </p>
        </div>

        <div class="intevi-testimonios-grid">

            <!-- TESTIMONIO IIH -->
            <article class="intevi-testimonio-card">
                <div class="intevi-testimonio-top">
                    <div class="intevi-testimonio-logo">
                        IIH
                    </div>

                    <div>
                        <span class="intevi-testimonio-tipo">
                            Prueba institucional
                        </span>

                        <h3>Instituto de Investigaciones Históricas (UMSNH)</h3>
                    </div>
                </div>

                <div class="intevi-testimonio-quote">
                    <span class="intevi-comillas" aria-hidden="true">“</span>

                    <p>
                        INTEVI nos permitió conocer una alternativa más clara
                        para organizar la información de los bienes, sus
                        ubicaciones y las personas responsables de cada
                        resguardo.
                    </p>
                </div>

                <div class="intevi-testimonio-footer">
                    <div>
                        <strong>IIH</strong>
                        <span>Instituto de Investigaciones Históricas</span>
                    </div>

                    <span class="intevi-testimonio-verificado">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 12.75 11.25 15 15.5 9.75"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>

                        Experiencia de prueba
                    </span>
                </div>
            </article>

            <!-- TESTIMONIO ACADEMIA DE POLICÍA -->
            <article class="intevi-testimonio-card">
                <div class="intevi-testimonio-top">
                    <div class="intevi-testimonio-logo intevi-testimonio-logo-red">
                        AP
                    </div>

                    <div>
                        <span class="intevi-testimonio-tipo">
                            Validación operativa
                        </span>

                        <h3>Academia de Policía (GOBIERNO DE MICHOACÁN)</h3>
                    </div>
                </div>

                <div class="intevi-testimonio-quote">
                    <span class="intevi-comillas" aria-hidden="true">“</span>

                    <p>
                        La plataforma presenta de manera ordenada la información
                        del inventario y facilita la consulta de resguardos,
                        responsables, áreas y ubicaciones institucionales.
                    </p>
                </div>

                <div class="intevi-testimonio-footer">
                    <div>
                        <strong>Academia de Policía</strong>
                        <span>Institución de formación policial</span>
                    </div>

                    <span class="intevi-testimonio-verificado">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 12.75 11.25 15 15.5 9.75"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>

                        Experiencia de prueba
                    </span>
                </div>
            </article>

        </div>

        <div class="intevi-testimonios-nota">
            <div class="intevi-testimonios-nota-icono">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3 4.5 6v5.25c0 4.64 3.2 8.94 7.5 9.75 4.3-.81 7.5-5.11 7.5-9.75V6L12 3Z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </div>

            <p>
                Cada implementación de INTEVI se adapta a la estructura,
                áreas, ubicaciones y procesos internos de la institución.
            </p>
        </div>

    </div>
</section>
--}}

    <section class="og-impact" style="background:red;">
            <p style="font-size:25px;text-align: center;">AQUÍ HAY UN RESUMEN DE</p>
            <p style="font-size:40px;text-align: center;"><b>TODO LO QUE OBTENDRÁS</b></p>
            <p style="font-size:25px;text-align: center;">UNA VEZ INGRESES A INTEVI</p>
    </section>
    <section class="og-impact" style="background:black; padding:80px;">
            <p style="font-size:40px;text-align: center;color:#FED524;"><b>!Solucionar tu Problema Garantizado!</b></p>
            <p style="font-size:20px;text-align: center;">
                Para llevar el control de los resguardos institucionales se necesitan estrategias y herramientas de control<br>
                profesionales, se necesita de una plataforma de alta calidad. Aqui tenemos todo lo que se<br>
                necesita.
            </p>
            <p style="font-size:30px;text-align: center;color:#E9231C;">Acceso inmediato a todo en menos de 72 horas</p>
            <p style="font-size:20px;text-align: center;">Mira todo los beneficios que encontrarás en esta solución</p>
    </section>
    <div class="container">
            <div class="og-browser">
                <div class="og-browser-screen">
                    <img
                        src="{{ asset('images/lo que obtendras.png') }}"
                        alt="Vista real del sistema INTEVI"
                        width="1915"
                        height="920"
                        loading="eager"s
                        fetchpriority="high"
                        style="
                            display: block !important;
                            width: 100% !important;
                            max-width: 1100px !important;
                            height: auto !important;
                            max-height: none !important;
                            margin: 0 auto !important;
                            object-fit: contain !important;
                            object-position: center !important;
                        "
                    >
                </div>
            </div>
            <div class="og-center">
                <p style="font-size:32px; margin-top:30px;" class="og-title og-title-sm">•PLATAFORMA INTEVI <span style="font-weight:bold;color:red;">($1497) USD LICENCIA ANUAL</span></p>
                <p style="font-size:32px; margin-top:30px;" class="og-title og-title-sm">•MÉTODO RESGUARDOS FÁCILES<br> DE CONTROLAR 5X <span style="color:#131750;">(METODOLOGÍA INTEGRADA EN INTEVI PARA ORGANIZAR LA INFORMACIÓN, SIMPLIFICAR LA OPERACIÓN Y MANTENER LOS RESGUARDOS BAJO CONTROL DE UNA MANERA MÁS FÁCIL Y RÁPIDA)</span><span style="font-weight:bold;color:red;">($497) USD</span></p>
                <p style="font-size:37px; margin-top:55px;" class="og-title og-title-sm">TOTAL VALOR: <span class="tachado-equis" style="color:red;">$1994 USD</span></p>
                <p style="font-size:37px; margin-top:55px;" class="og-title og-title-sm">🚀Precio especial de lanzamiento</p>
                <p style="font-size:47px; margin-top:55px;" class="og-title og-title-sm">PRECIO OFERTA: <span style="font-weight:bold;color:red;">$250  USD (EL PRIMER AÑO)</span></p>
                <p style="color:gray;font-weight: bold;">Acceso completo a INTEVI durante 12 meses con precio especial de lanzamiento.</p>
                <p style="color:red;font-weight: bold;">A partir del segundo año, la licencia tendrá un costo de: $500 USD</p>

                <a class="button button-primary" style="background:#FBCC06;color:black; margin-top:40px;" href="#contacto">
                        QUIERO ENTRAR A INTEVI
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
    </div>
    <section class="og-impact" style="background:red; padding:10px;">
            <p style="font-size:40px;text-align: center;"><b>BONUS MÁGICOS</b></p>
    </section>
    <div class="container">
            <div class="og-browser">
                <div class="og-browser-screen">
                    <img
                        src="{{ asset('images/lo que obtendras.png') }}"
                        alt="Vista real del sistema INTEVI"
                        width="1915"
                        height="920"
                        loading="eager"s
                        fetchpriority="high"
                        style="
                            display: block !important;
                            width: 100% !important;
                            max-width: 1100px !important;
                            height: auto !important;
                            max-height: none !important;
                            margin: 0 auto !important;
                            object-fit: contain !important;
                            object-position: center !important;
                        "
                    >
                </div>
            </div>
            <div class="og-center">
                <p style="font-size:32px; margin-top:30px;" class="og-title og-title-sm">•PLATAFORMA INTEVI <span style="font-weight:bold;color:red;">($1497) USD LICENCIA ANUAL</span></p>
                <p style="font-size:32px; margin-top:30px;" class="og-title og-title-sm">•MÉTODO RESGUARDOS FÁCILES<br> DE CONTROLAR 5X <span style="color:#131750;">(METODOLOGÍA INTEGRADA EN INTEVI PARA ORGANIZAR LA INFORMACIÓN, SIMPLIFICAR LA OPERACIÓN Y MANTENER LOS RESGUARDOS BAJO CONTROL DE UNA MANERA MÁS FÁCIL Y RÁPIDA)</span><span style="font-weight:bold;color:red;">($497) USD</span></p>
                <p style="font-size:47px; margin-top:55px;font-style: italic;" class="og-title og-title-sm">BONUS MÁGICOS</p>
                <p style="font-size:32px; margin-top:30px;" class="og-title og-title-sm">•ASISTENTE VIRTUAL (GPT) <span style="font-weight:bold;color:red;">($100) USD</span></p>

                <p style="font-size:37px; margin-top:55px;" class="og-title og-title-sm">TOTAL VALOR: <span class="tachado-equis" style="color:red;">$6197 USD</span></p>
                <p style="font-size:37px; margin-top:55px;" class="og-title og-title-sm">🚀Precio especial de lanzamiento</p>
                <p style="font-size:47px; margin-top:55px;" class="og-title og-title-sm">PRECIO OFERTA: <span style="font-weight:bold;color:red;">$250 USD (ANUAL)</span></p>
                <p style="color:gray;font-weight: bold;">Acceso completo a INTEVI durante 12 meses con precio especial de lanzamiento.</p>
                <p style="color:red;font-weight: bold;">A partir del segundo año, la licencia tendrá un costo de: $500 USD</p>

 
                <a class="button button-primary" style="background:#FBCC06;color:black; margin-top:40px;" href="#contacto">
                    QUIERO ENTRAR A INTEVI
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                
            </div>
    </div>

    <section class="og-garantia" id="garantia">
    <div class="og-garantia-container">

        <!-- LADO IZQUIERDO: 1/3 -->
        <div class="og-garantia-visual">
            <div class="og-garantia-sello">
                <img
                    src="{{ asset('images/garantia-30-dias.png') }}"
                    alt="Garantía de devolución durante 30 días"
                    loading="lazy"
                    width="700"
                    height="700"
                >
            </div>
        </div>

        <!-- LADO DERECHO: 2/3 -->
        <div class="og-garantia-contenido">

            <span class="og-garantia-etiqueta">
                Compra protegida
            </span>

            <h2>
                Tu inversión está segura a un 100% con una 
                <span>Garantía Total de 30 días</span>
            </h2>

            <p class="og-garantia-descripcion">
                Queremos que conozcas INTEVI con tranquilidad y tengas la
                seguridad de estar tomando una buena decisión para tu
                institución.
            </p>

            <div class="og-garantia-beneficio">
                <div class="og-garantia-check">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m5 12 4 4L19 6"></path>
                    </svg>
                </div>

                <p>
                    Si durante los primeros <strong>30 días</strong> la plataforma
                    no es lo que estabas buscando, podrás solicitar una
                    devolución.
                </p>
            </div>

            <p class="og-garantia-mensaje">
                Sin riesgos innecesarios. Sin decisiones apresuradas.
                <strong>Prueba INTEVI con mayor confianza.</strong>
            </p>

            <a href="#contacto" class="og-garantia-boton">
                Solicitar una demostración

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m13 6 6 6-6 6"></path>
                </svg>
            </a>

            <!--
            <small class="og-garantia-terminos">
                Garantía aplicable conforme a las condiciones establecidas
                en la propuesta comercial y contrato de servicio.
            </small>
            -->

        </div>

    </div>
</section>












    <!--
    <section class="og-section" id="funciones">
        <div class="container og-solution-grid">
            <div>
                
                <p class="og-copy" style="margin-top:21px">INTEVI permite registrar los activos de la institución y relacionarlos con responsables, áreas de asignación, ubicaciones físicas y documentos de resguardo.</p>
                
                <div class="og-checks">
                    <div class="og-check"><span class="og-check-icon">✓</span><div><strong>Registro completo de bienes</strong><p>Descripción, marca, serie, características, estado y datos de identificación.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><strong>Resguardos y responsables</strong><p>Relación clara entre el activo, la persona y el área que lo utiliza o custodia.</p></div></div>
                    <div class="og-check"><span class="og-check-icon">✓</span><div><strong>Entorno independiente por institución</strong><p>Cada organismo opera con su propio acceso, usuarios e información.</p></div></div>
                </div>
            
            </div>
        </div>
    </section>

    {{-- 5. VIÑETAS DE CURIOSIDAD --}}
    <section class="og-section og-soft">
        <div class="container">
            <div class="og-center"><span class="og-kicker">Beneficios que puedes comprobar</span><h2 class="og-title og-title-sm">Imagina poder consultar en segundos…</h2><p class="og-copy">Preguntas administrativas frecuentes convertidas en consultas claras dentro de un mismo sistema.</p></div>
            <div class="og-benefits">
                <article class="og-benefit"><small>01</small><h3>Qué bienes existen realmente</h3><p>Sin comparar múltiples hojas de cálculo o versiones guardadas en diferentes equipos.</p></article>
                <article class="og-benefit"><small>02</small><h3>Dónde se encuentra cada activo</h3><p>Desde una oficina o departamento hasta un almacén o ubicación física específica.</p></article>
                <article class="og-benefit"><small>03</small><h3>Quién tiene asignado cada bien</h3><p>Consulta la relación entre el activo, su responsable, puesto y área de asignación.</p></article>
                <article class="og-benefit"><small>04</small><h3>Qué información identifica al bien</h3><p>Descripción, marca, número de serie, características, estado y datos complementarios.</p></article>
                <article class="og-benefit"><small>05</small><h3>Cómo está distribuido el inventario</h3><p>Organiza consultas por área, ubicación, responsable, estado o criterio administrativo.</p></article>
                <article class="og-benefit"><small>06</small><h3>Quién puede modificar información</h3><p>Administra roles y permisos según las responsabilidades del personal autorizado.</p></article>
                <article class="og-benefit"><small>07</small><h3>Qué registros requieren revisión</h3><p>Detecta información pendiente antes de una verificación o proceso administrativo.</p></article>
                <article class="og-benefit"><small>08</small><h3>Cómo crecer sin perder el control</h3><p>Mantén una estructura organizada al incorporar bienes, usuarios, áreas o ubicaciones.</p></article>
            </div>
        </div>
    </section>

    {{-- 6. CREDIBILIDAD --}}
    <section class="og-section og-dark" id="como-funciona">
        <div class="container">
            <div class="og-center"><span class="og-kicker">Credibilidad por especialización</span><h2 class="og-title og-title-sm">Diseñado alrededor de los procesos reales de <span class="og-highlight">resguardo institucional.</span></h2><p class="og-copy">INTEVI no parte de la lógica de una tienda. Parte de la relación entre la institución, sus bienes y las personas responsables.</p></div>
            <div class="og-cred-grid">
                <article class="og-cred"><span class="og-cred-icon">▣</span><h3>Bienes institucionales</h3><p>Información pensada para identificar activos propiedad de la institución.</p></article>
                <article class="og-cred"><span class="og-cred-icon">◉</span><h3>Responsables definidos</h3><p>Cada bien puede relacionarse con la persona que lo tiene asignado.</p></article>
                <article class="og-cred"><span class="og-cred-icon">⌂</span><h3>Áreas y ubicaciones</h3><p>La estructura administrativa y física permanece conectada con el inventario.</p></article>
                <article class="og-cred"><span class="og-cred-icon">✓</span><h3>Acceso controlado</h3><p>Roles y permisos definen quién consulta, registra o administra información.</p></article>
            </div>
        </div>
    </section>

    {{-- 7. PRUEBAS Y EVIDENCIAS --}}
    <section class="og-section og-soft">
        <div class="container">
            <div class="og-center"><span class="og-kicker">Pruebas que puedes revisar</span><h2 class="og-title og-title-sm">No tienes que imaginar cómo funciona. <span class="og-highlight">Puedes verlo directamente.</span></h2><p class="og-copy">La demostración se realiza sobre la plataforma, no solamente con diapositivas.</p></div>
            <div class="og-evidence">
                <article class="og-evidence-main"><img src="{{ asset('images/intevi-dashboard.webp') }}" alt="Dashboard real de INTEVI" loading="lazy"><div class="og-evidence-caption"><small>Vista real del producto</small><h3>La evidencia principal es el sistema funcionando</h3><p>Revisa cómo se consulta el inventario, cómo se administran responsables y cómo se organiza la información.</p></div></article>
                <div class="og-evidence-list">
                    <article class="og-proof"><h3>Inventario centralizado</h3><p>Comprueba cómo se registran y consultan los datos de cada bien.</p></article>
                    <article class="og-proof"><h3>Resguardos y responsables</h3><p>Revisa cómo se relacionan los activos con personas y áreas.</p></article>
                    <article class="og-proof"><h3>Usuarios y permisos</h3><p>Observa cómo se controla el acceso según cada responsabilidad.</p></article>
                    <article class="og-proof"><h3>Entorno institucional propio</h3><p>Cada organismo mantiene separados sus usuarios y su información.</p></article>
                </div>
            </div>
        </div>
    </section>

    {{-- 8. OFERTA Y ANCLAJE DE PRECIO --}}
    <section class="og-section" id="instituciones">
        <div class="container">
            <div class="og-center"><span class="og-kicker">La oferta</span><h2 class="og-title og-title-sm">Una implementación ajustada a la realidad de tu institución</h2><p class="og-copy">INTEVI se presenta mediante una cotización personalizada porque cada organismo tiene un volumen y una estructura diferente.</p></div>
            <div class="og-offer">
                <article class="og-cost"><small>El verdadero anclaje de precio</small><h3>Compara la inversión con el costo de seguir sin control</h3><ul class="og-list"><li>Horas dedicadas a buscar información.</li><li>Duplicidad y corrección de registros.</li><li>Preparación manual de reportes.</li><li>Dependencia de archivos y personas específicas.</li><li>Dificultad para localizar resguardos.</li><li>Falta de claridad durante una revisión.</li></ul></article>
                <article class="og-offer-card"><span class="og-offer-badge">Cotización institucional</span><h3>INTEVI para tu organismo</h3><p>La propuesta se calcula según el alcance real de la operación, para que la institución conozca con claridad qué recibe y cuánto invertirá.</p><div class="og-includes"><div class="og-include">Cantidad de bienes</div><div class="og-include">Número de usuarios</div><div class="og-include">Áreas participantes</div><div class="og-include">Configuración inicial</div><div class="og-include">Capacitación requerida</div><div class="og-include">Acompañamiento de arranque</div></div><div class="og-price"><div><small>Inversión</small><strong>Cotización personalizada</strong></div><a class="button button-primary" style="background:black;" href="#contacto">Solicitar cotización</a></div></article>
            </div>
        </div>
    </section>

    {{-- 9. BONOS --}}
    <section class="og-section og-warm">
        <div class="container">
            <div class="og-center"><span class="og-kicker">Bonos de implementación</span><h2 class="og-title og-title-sm">La plataforma llega acompañada de un proceso de puesta en marcha</h2><p class="og-copy">Los apoyos se definen dentro de cada propuesta para facilitar la adopción inicial.</p></div>
            <div class="og-bonus-grid">
                <article class="og-bonus"><span class="og-bonus-num">01</span><h3>Diagnóstico inicial</h3><p>Revisión del proceso actual para organizar la implementación.</p></article>
                <article class="og-bonus"><span class="og-bonus-num">02</span><h3>Configuración institucional</h3><p>Preparación de áreas, ubicaciones, roles y estructura básica.</p></article>
                <article class="og-bonus"><span class="og-bonus-num">03</span><h3>Capacitación de usuarios</h3><p>Sesión para conocer los módulos y procesos principales.</p></article>
                <article class="og-bonus"><span class="og-bonus-num">04</span><h3>Plantilla de preparación</h3><p>Formato para organizar los datos de la carga inicial.</p></article>
                <article class="og-bonus"><span class="og-bonus-num">05</span><h3>Acompañamiento de arranque</h3><p>Orientación para resolver dudas durante la etapa inicial.</p></article>
            </div>
            <p class="og-bonus-note">Los bonos aplicables, su alcance y condiciones se especifican expresamente dentro de la cotización institucional.</p>
        </div>
    </section>

    {{-- 10. GARANTÍA --}}
    <section class="og-guarantee">
        <div class="container og-guarantee-grid">
            <div class="og-seal"><div class="og-seal-inner"><span class="og-seal-icon">✓</span><strong>Garantía de claridad antes de contratar</strong></div></div>
            <div><span class="og-kicker">Primero conoces. Después decides.</span><h2 class="og-title og-title-sm">No contrates sin saber exactamente qué recibirá tu institución.</h2><p class="og-copy" style="margin-top:20px">Antes de formalizar una contratación, la institución recibe una propuesta clara y puede revisar el funcionamiento real de INTEVI mediante una demostración.</p><div class="og-guarantee-points"><span>Alcance de la implementación.</span><span>Funciones y usuarios contemplados.</span><span>Servicios y apoyos incluidos.</span><span>Costo y condiciones de la propuesta.</span></div><a class="button button-light" style="margin-top:28px" href="#contacto">Agendar una demostración</a></div>
        </div>
    </section>
    -->
    {{-- 11. FAQ --}}
    <section class="og-section" id="preguntas">
        <div class="container og-faq-layout">
            <div class="og-faq-intro">
                <span class="og-kicker">Preguntas frecuentes</span>
                <!--
                <h2 class="og-title og-title-sm">Respuestas claras antes de dar el siguiente paso</h2><p>Información esencial para evaluar INTEVI dentro de un organismo.</p>
                -->    
            </div>
            <div class="og-faq-list">
                @php
                    $faqs = [
                        ['¿INTEVI es un sistema de almacén?', 'No exactamente. Está orientado al control de bienes institucionales y a su relación con responsables, áreas, ubicaciones y resguardos.'],
                        ['¿Qué tipo de bienes se pueden registrar?', 'Equipos tecnológicos, mobiliario, herramientas, activos administrativos y otros bienes que la institución necesite identificar.'],
                        ['¿Podemos conocer quién tiene asignado cada bien?', 'Sí. INTEVI permite relacionar cada activo con su responsable y consultar la información asociada a su resguardo.'],
                        ['¿Se organizan los bienes por área y ubicación?', 'Sí. Los activos pueden asociarse con áreas de asignación y ubicaciones físicas para facilitar su localización.'],
                        ['¿Todos los usuarios tienen el mismo acceso?', 'No. La plataforma administra roles y permisos de acuerdo con las responsabilidades de cada usuario.'],
                        ['¿La información de instituciones diferentes se mezcla?', 'No. Cada institución utiliza un entorno independiente y administra su propia información.'],
                        ['¿Se instala en cada computadora?', 'No. INTEVI funciona como plataforma web y se utiliza desde un navegador compatible.'],
                        ['¿Cómo podemos conocer el sistema?', 'Solicita una demostración para revisar la plataforma y plantear las necesidades de tu organización.'],
                    ];
                @endphp
                
                        {{--
                        ['¿Ofrecen capacitación?', 'La capacitación y el acompañamiento pueden incorporarse dentro de la propuesta de implementación.'],
                        ['¿Cuánto cuesta INTEVI?', 'El precio se determina mediante una cotización personalizada según usuarios, alcance y necesidades.'],
                        --}}
                @foreach ($faqs as $index => $faq)
                    <article class="og-faq-item {{ $index === 0 ? 'active' : '' }}">
                        <button class="og-faq-q" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"><span>{{ $faq[0] }}</span><span class="og-faq-plus">+</span></button>
                        <div class="og-faq-a"><p>{{ $faq[1] }}</p></div>
                    </article>
                @endforeach
            </div>
        </div>
        <div style="text-align:center; margin-top:40px;">
            <p><b>PD:</b> Si has llegado hasta aquí es porque todo lo que te  he mostrado interesa y sabes que necesitas un vehículo que funcione de verdad.</p>
            <p>Este producto premium tiene un precio regularmente de $3600 dólares, pero puedes obtenerlo hoy por sólo $499, cómpralo ahora antes que se vaya.</p>
            <p>¿No te gustaría llevar un mejor control de tus resguados desde el primer mes? !Actúa Ahora!, satisfacción garantizada.</p>
            <p>Sé que tienes dudas en este momento, si la inversión merecerá la pena, si tu producto puede beneficiarte entre otras muchas cosas.</p>
            <p>Por eso te digo que la mejor forma de despejar dudas es probar, analizar y ver si funciona desde dentro. Entra y comprueba si todo lo que digo es</p>
            <p>real, no pierdes nada, tienes una garantía total si no estás satisfecho.</p>
            <p>Te prometo que, si sigues un buen ritmo, cruzarás el otro lado del puente sin riesgo alguno. </p>
        </div>
    </section>

    {{-- 12. CIERRE --}}
    <!--
    <section class="og-close" id="contacto">
        <div class="container og-close-grid">
            <div class="og-close-copy"><h2>Los bienes de tu institución ya existen. La pregunta es si su información está realmente bajo control.</h2><p>No esperes a una revisión, un cambio administrativo o la ausencia de una persona clave para descubrir que la información está dispersa. Conoce INTEVI y evalúa una forma más clara de administrar inventarios y resguardos.</p></div>
            <div class="og-close-actions"><a class="button button-light" href="#contacto">Solicitar demostración</a><a class="button button-outline-light" href="mailto:{{ $contactEmail }}">Escribir a {{ $contactEmail }}</a><small>Sin compromiso de contratación.</small></div>
        </div>
    </section>
    -->
</main>

<!--
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#inicio" class="brand">
                    <span class="brand-symbol" aria-hidden="true">
                <svg
                    viewBox="0 0 32 32"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M16 3.5 25 7v7.1c0 6.2-3.7 10.7-9 14.4-5.3-3.7-9-8.2-9-14.4V7l9-3.5Z"
                        fill="currentColor"
                        fill-opacity=".12"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M12.2 15.1v-2a3.8 3.8 0 0 1 7.6 0v2"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                    <rect
                        x="10.8"
                        y="15"
                        width="10.4"
                        height="7.6"
                        rx="2.1"
                        stroke="currentColor"
                        stroke-width="1.8"
                    />
                    <path
                        d="M16 18.2v1.8"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>
            </span>

                    <span>
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
                    <li>
                        <a href="#solucion">Solución</a>
                    </li>

                    <li>
                        <a href="#funciones">Funciones</a>
                    </li>

                    <li>
                        <a href="#como-funciona">Cómo funciona</a>
                    </li>

                    <li>
                        <a href="#instituciones">Instituciones</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="footer-heading">Contacto</h3>

                <ul class="footer-links">
                    <li>
                        <a href="mailto:{{ $contactEmail }}">
                            Solicita tu demostración enviando un correo a: {{ $contactEmail }}
                        </a>
                    </li>

                    <li>
                        <a href="#contacto">
                            Solicitar demostración
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                © {{ now()->year }} INTEVI. Todos los derechos reservados.
            </p>

            <p class="footer-signature">
                 Inventario y resguardo institucional
            </p>
        </div>
    </div>
</footer>
-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('menuButton');
        const navigation = document.getElementById('navigation');
        const navigationLinks = navigation.querySelectorAll('a');

        function closeMenu() {
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Abrir menú');

            navigation.classList.remove('mobile-visible');
            document.body.classList.remove('menu-open');
        }

        menuButton.addEventListener('click', function () {
            const isOpen =
                menuButton.getAttribute('aria-expanded') === 'true';

            menuButton.setAttribute(
                'aria-expanded',
                String(!isOpen)
            );

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

        window.addEventListener('resize', function () {
            if (window.innerWidth > 940) {
                closeMenu();
            }
        });

        
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
const inteviAlert = document.getElementById('inteviAlert');
const inteviAlertClose = document.getElementById('inteviAlertClose');

if (inteviAlert) {
    document.body.classList.add('has-intevi-alert');
}

if (inteviAlertClose && inteviAlert) {
    inteviAlertClose.addEventListener('click', function () {
        inteviAlert.remove();
        document.body.classList.remove('has-intevi-alert');
    });
}
        
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.og-faq-item');
    function setOpen(item, open) {
        const answer = item.querySelector('.og-faq-a');
        const button = item.querySelector('.og-faq-q');
        item.classList.toggle('active', open);
        button.setAttribute('aria-expanded', String(open));
        answer.style.maxHeight = open ? answer.scrollHeight + 'px' : '0px';
    }
    items.forEach(function (item) {
        setOpen(item, item.classList.contains('active'));
        item.querySelector('.og-faq-q').addEventListener('click', function () {
            const opening = !item.classList.contains('active');
            items.forEach(function (other) { if (other !== item) setOpen(other, false); });
            setOpen(item, opening);
        });
    });
    window.addEventListener('resize', function () {
        items.forEach(function (item) { if (item.classList.contains('active')) setOpen(item, true); });
    });
});
</script>

</body>
</html>
