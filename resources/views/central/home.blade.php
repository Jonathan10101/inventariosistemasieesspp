<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

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
    </style>
</head>

<body>

<header class="site-header">
        <div class="container navbar">
    <a href="{{ url('/') }}" class="brand">
        <img
            src="{{ asset('images/intevi logo.png') }}"
            alt="Logo de INTEVI"
            class="brand-logo"
        >

        <span class="brand-text">
            <span class="brand-name">INTEVI</span>

            <span class="brand-description">
                Inventario Tecnológico Institucional
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
</header>

<main>

    {{-- HERO --}}
    <section class="hero" id="inicio">
        <div class="container hero-grid">

            <div class="hero-copy">
                <div class="hero-tag">
                    <span class="hero-tag-dot"></span>
                    Gestión de bienes institucionales
                </div>

                <h1 class="hero-title">
                    Cada bien bajo control.
                    <span>Cada resguardo, documentado.</span>
                </h1>

                <p class="hero-description">
                    INTEVI centraliza el inventario, los responsables, las
                    ubicaciones y los resguardos de tu institución para que
                    siempre sepas qué bienes existen, dónde están y quién los
                    tiene asignados.
                </p>

                <div class="hero-actions">
                    <a class="button button-primary" href="#contacto">
                        Solicitar una demostración

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>

                    <a class="button button-outline" href="#funciones">
                        Conocer la plataforma
                    </a>
                </div>

                <div class="hero-note">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        aria-hidden="true"
                    >
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>

                    Diseñado para instituciones públicas, organismos y empresas.
                </div>
            </div>

            <div class="product-preview product-preview-real">

                <div class="preview-label">
                    Plataforma INTEVI
                </div>

                <div class="system-browser">

                    <div class="system-browser-bar">
                        <div class="system-browser-controls">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <div class="system-browser-address">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                aria-hidden="true"
                            >
                                <rect x="5" y="10" width="14" height="10" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>

                            <span>
                                tuinstitucion.intevi.app/inventario
                            </span>
                        </div>

                        <div class="system-browser-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <div class="system-screen">
                        <img
                            src="{{ asset('images/intevi-dashboard.webp') }}"
                            alt="Vista del módulo de control de inventario de INTEVI"
                            width="1915"
                            height="920"
                            loading="eager"
                            fetchpriority="high"
                        >
                    </div>

                </div>

                <div class="product-floating-card">
                    <span class="floating-card-label">
                        Plataforma institucional
                    </span>

                    <span class="floating-card-value">
                        Inventario centralizado
                    </span>
                </div>

            </div>
        </div>
    </section>

    {{-- TIPOS DE CLIENTES --}}
    <section class="audience-strip">
        <div class="container audience-content">
            <span class="audience-title">
                Una solución para
            </span>

            <div class="audience-list">
                <span class="audience-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M3 21h18M5 21V8l7-4 7 4v13"/>
                        <path d="M9 12h1M14 12h1M9 16h1M14 16h1"/>
                    </svg>

                    Instituciones públicas
                </span>

                <span class="audience-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M4 20V6h8v14M12 10h8v10"/>
                        <path d="M7 9h2M7 13h2M7 17h2M15 13h2M15 17h2"/>
                    </svg>

                    Empresas
                </span>

                <span class="audience-item">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M8 12h8M12 8v8"/>
                    </svg>

                    Organismos
                </span>
            </div>
        </div>
    </section>

    {{-- PROBLEMA --}}
    <section class="section" id="solucion">
        <div class="container problem-layout">
            <div class="problem-statement">
                <p class="problem-quote">
                    El inventario no debería depender de
                    <span>archivos dispersos, formatos físicos y memoria.</span>
                </p>

                <p class="problem-caption">
                    INTEVI convierte la información patrimonial en un proceso
                    claro, ordenado y consultable.
                </p>
            </div>

            <div>
                <span class="eyebrow">El problema que resolvemos</span>

                <h2 class="heading heading-medium">
                    Control institucional sin incertidumbre.
                </h2>

                <p class="section-copy">
                    Cuando la información se encuentra en distintos archivos,
                    localizar un bien o confirmar un resguardo puede tomar horas.
                    INTEVI concentra la operación en una plataforma diseñada para
                    el trabajo administrativo real.
                </p>

                <div class="problem-list">
                    <div class="problem-item">
                        <span class="problem-number">01</span>

                        <div>
                            <strong>Bienes sin ubicación clara</strong>

                            <p>
                                Consulta el área, ubicación y responsable actual
                                de cada activo.
                            </p>
                        </div>
                    </div>

                    <div class="problem-item">
                        <span class="problem-number">02</span>

                        <div>
                            <strong>Resguardos difíciles de comprobar</strong>

                            <p>
                                Mantén organizada la relación entre los bienes y
                                las personas que los tienen asignados.
                            </p>
                        </div>
                    </div>

                    <div class="problem-item">
                        <span class="problem-number">03</span>

                        <div>
                            <strong>Información duplicada o desactualizada</strong>

                            <p>
                                Trabaja con un registro central para reducir
                                inconsistencias y búsquedas innecesarias.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FUNCIONES --}}
    <section class="section section-soft" id="funciones">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Una sola plataforma</span>

                    <h2 class="heading heading-medium">
                        Todo lo necesario para gestionar los bienes de tu institución.
                    </h2>
                </div>

                <p class="section-copy">
                    Desde el registro inicial hasta la asignación y consulta,
                    cada módulo mantiene la información conectada.
                </p>
            </div>

            <div class="feature-grid">
                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M4 7h16v13H4z"/>
                            <path d="m4 7 3-3h10l3 3M9 11h6"/>
                        </svg>
                    </div>

                    <h3>Inventario de bienes</h3>

                    <p>
                        Registra la descripción, marca, número de serie,
                        características, estado y datos de identificación de cada
                        activo institucional.
                    </p>

                    <span class="feature-link">
                        Registro centralizado

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="12" cy="8" r="3"/>
                            <path d="M5 20c0-4 3-7 7-7s7 3 7 7"/>
                            <path d="M18 5h3M19.5 3.5v3"/>
                        </svg>
                    </div>

                    <h3>Resguardos y responsables</h3>

                    <p>
                        Relaciona cada bien con su responsable y conserva una
                        operación ordenada al realizar asignaciones o cambios.
                    </p>

                    <span class="feature-link">
                        Responsabilidad definida

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M4 20V9l8-5 8 5v11"/>
                            <path d="M8 20v-7h8v7"/>
                        </svg>
                    </div>

                    <h3>Áreas y ubicaciones</h3>

                    <p>
                        Organiza los bienes por dirección, departamento, oficina,
                        almacén o espacio físico para encontrarlos con facilidad.
                    </p>

                    <span class="feature-link">
                        Ubicación precisa

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M5 4h14v16H5z"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>
                    </div>

                    <h3>Etiquetas y documentos</h3>

                    <p>
                        Identifica activos y genera formatos útiles para apoyar
                        los procesos administrativos y las verificaciones
                        internas.
                    </p>

                    <span class="feature-link">
                        Identificación organizada

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M4 19V9M10 19V5M16 19v-7M22 19H2"/>
                        </svg>
                    </div>

                    <h3>Consultas y reportes</h3>

                    <p>
                        Obtén una visión clara del inventario por responsable,
                        área, ubicación o estado para agilizar revisiones y
                        decisiones.
                    </p>

                    <span class="feature-link">
                        Información consultable

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3 5 6v5c0 5 3 8 7 10 4-2 7-5 7-10V6z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>

                    <h3>Usuarios, roles y permisos</h3>

                    <p>
                        Define quién puede consultar, registrar o administrar la
                        información de acuerdo con las responsabilidades de cada
                        usuario.
                    </p>

                    <span class="feature-link">
                        Acceso controlado

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </article>
            </div>
        </div>
    </section>

    {{-- PROCESO --}}
    <section class="section section-dark" id="como-funciona">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Cómo funciona</span>

                    <h2 class="heading heading-medium">
                        Un proceso sencillo para mantener el control.
                    </h2>
                </div>

                <p class="section-copy">
                    INTEVI organiza las tareas principales sin añadir
                    complejidad innecesaria al trabajo diario.
                </p>
            </div>

            <div class="workflow">
                <article class="workflow-step">
                    <h3>Registra los bienes</h3>

                    <p>
                        Captura la información necesaria para identificar cada
                        activo y construir un inventario institucional confiable.
                    </p>
                </article>

                <article class="workflow-step">
                    <h3>Asigna responsables</h3>

                    <p>
                        Relaciona los bienes con personas, áreas y ubicaciones
                        mediante un proceso de resguardo organizado.
                    </p>
                </article>

                <article class="workflow-step">
                    <h3>Consulta y administra</h3>

                    <p>
                        Localiza información, actualiza movimientos y genera
                        reportes desde un mismo entorno.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- MULTITENANCY --}}
    <section class="section" id="instituciones">
        <div class="container organization-layout">
            <div class="organization-preview">
                <div class="browser-bar">
                    <div class="browser-points">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="browser-address">
                        https://<strong>tuinstitucion</strong>.intevi.app
                    </div>
                </div>

                <div class="organization-card">
                    <div class="organization-brand">
                        <div class="organization-logo">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
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
                    Una plataforma preparada para cada organización.
                </h2>

                <p class="section-copy">
                    Cada institución puede contar con su propio acceso,
                    usuarios, información y configuración dentro de un entorno
                    identificado con su nombre.
                </p>

                <div class="benefit-list">
                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>

                        <div>
                            <strong>Acceso personalizado</strong>

                            <p>
                                Una dirección web propia para ingresar al sistema.
                            </p>
                        </div>
                    </div>

                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>

                        <div>
                            <strong>Información separada</strong>

                            <p>
                                Los registros de cada organización permanecen
                                dentro de su entorno correspondiente.
                            </p>
                        </div>
                    </div>

                    <div class="benefit">
                        <span class="benefit-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </span>

                        <div>
                            <strong>Crecimiento organizado</strong>

                            <p>
                                La plataforma puede incorporar nuevas
                                instituciones sin mezclar operaciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROPUESTA DE VALOR --}}
    <section class="value-section">
        <div class="container value-layout">
            <span class="value-title">
                El valor de INTEVI
            </span>

            <p class="value-message">
                Menos tiempo buscando información. Más claridad para administrar
                y proteger los bienes de la institución.
            </p>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta" id="contacto">
        <div class="container cta-layout">
            <div class="cta-copy">
                <h2>
                    Convierte tu inventario en información útil y confiable.
                </h2>

                <p>
                    Conoce cómo INTEVI puede adaptarse a la operación de tu
                    institución y ayudarte a gestionar los resguardos desde una
                    sola plataforma.
                </p>
            </div>

            <div class="cta-action">
                <a
                    class="button button-light"
                >
                    Solicitar demostración

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </a>

                <a class="cta-email" href="mailto:{{ $contactEmail }}">
                    Solicita tu demostración enviando un correo a: {{ $contactEmail }}
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
                            Inventario Tecnológico Institucional
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
                Inventario Tecnológico Institucional
            </p>
        </div>
    </div>
</footer>

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

</body>
</html>
