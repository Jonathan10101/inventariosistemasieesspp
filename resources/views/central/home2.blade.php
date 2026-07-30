<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Diagnóstico 5X gratuito | INTEVI</title>

    <meta
        name="description"
        content="Evalúa gratuitamente qué tan controlado está el inventario de tu institución con el Diagnóstico de Control Institucional 5X de INTEVI."
    >

    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#171C63">
    <meta name="color-scheme" content="light">

    <link
        rel="canonical"
        href="{{ url('/diagnostico-5x') }}"
    >

    <style>
        :root {
            --intevi-primary: #171c63;
            --intevi-primary-light: #29319a;
            --intevi-primary-soft: #eef0ff;
            --intevi-dark: #10132d;
            --intevi-text: #24283b;
            --intevi-muted: #667085;
            --intevi-border: #e4e7ec;
            --intevi-background: #f5f7fc;
            --intevi-white: #ffffff;
            --intevi-success: #087443;
            --intevi-success-soft: #eaf8f1;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 7% 10%,
                    rgba(23, 28, 99, 0.11),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 94% 88%,
                    rgba(41, 49, 154, 0.09),
                    transparent 25%
                ),
                var(--intevi-background);

            color: var(--intevi-text);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        a {
            color: inherit;
        }

        .lead-page {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .lead-page::before,
        .lead-page::after {
            position: fixed;
            z-index: 0;
            width: 260px;
            height: 260px;
            pointer-events: none;
            opacity: 0.35;
            content: "";
            background-image:
                radial-gradient(
                    circle,
                    rgba(23, 28, 99, 0.26) 1.6px,
                    transparent 1.8px
                );
            background-size: 17px 17px;
        }

        .lead-page::before {
            top: -35px;
            left: -45px;
        }

        .lead-page::after {
            right: -70px;
            bottom: -70px;
        }

        .lead-header {
            position: relative;
            z-index: 2;
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
            padding: 24px 0 12px;
        }

        .lead-brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: var(--intevi-primary);
            text-decoration: none;
        }

        .lead-brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border: 2px solid var(--intevi-primary);
            border-radius: 13px;
            font-size: 21px;
            font-weight: 900;
            line-height: 1;
        }

        .lead-brand-name {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 0.08em;
        }

        .lead-main {
            position: relative;
            z-index: 1;
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
            padding: 28px 0 64px;
        }

        .lead-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                minmax(420px, 520px);
            gap: 54px;
            align-items: center;
        }

        .lead-copy {
            padding: 20px 0;
        }

        .lead-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 9px 14px;
            border: 1px solid rgba(23, 28, 99, 0.12);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.84);
            color: var(--intevi-primary);
            box-shadow: 0 8px 25px rgba(23, 28, 99, 0.06);
            font-size: 13px;
            font-weight: 800;
        }

        .lead-eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--intevi-primary);
            box-shadow: 0 0 0 5px rgba(23, 28, 99, 0.09);
        }

        .lead-title {
            max-width: 680px;
            margin: 0;
            color: var(--intevi-dark);
            font-size: clamp(38px, 5.2vw, 66px);
            line-height: 1.04;
            letter-spacing: -0.055em;
        }

        .lead-title strong {
            color: var(--intevi-primary);
            font-weight: 900;
        }

        .lead-subtitle {
            max-width: 660px;
            margin: 23px 0 0;
            color: var(--intevi-muted);
            font-size: 18px;
            line-height: 1.7;
        }

        .lead-subtitle strong {
            color: var(--intevi-text);
        }

        .lead-benefits {
            display: grid;
            gap: 13px;
            margin: 30px 0 0;
            padding: 0;
            list-style: none;
        }

        .lead-benefits li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #344054;
            font-size: 15px;
            line-height: 1.55;
        }

        .lead-benefit-icon {
            display: grid;
            flex: 0 0 25px;
            width: 25px;
            height: 25px;
            margin-top: 1px;
            place-items: center;
            border-radius: 50%;
            background: var(--intevi-success-soft);
            color: var(--intevi-success);
            font-size: 13px;
            font-weight: 900;
        }

        .lead-preview {
            position: relative;
            max-width: 585px;
            margin-top: 38px;
            padding-left: 24px;
        }

        .lead-preview-document {
            position: relative;
            overflow: hidden;
            width: min(100%, 460px);
            min-height: 260px;
            padding: 28px;
            border: 1px solid rgba(23, 28, 99, 0.11);
            border-radius: 24px;
            background: var(--intevi-white);
            box-shadow:
                0 26px 65px rgba(16, 24, 40, 0.13),
                0 5px 18px rgba(16, 24, 40, 0.05);
            transform: rotate(-1.5deg);
        }

        .lead-preview-document::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 9px;
            content: "";
            background:
                linear-gradient(
                    90deg,
                    var(--intevi-primary),
                    var(--intevi-primary-light)
                );
        }

        .lead-preview-label {
            display: inline-flex;
            margin-top: 7px;
            padding: 7px 11px;
            border-radius: 999px;
            background: var(--intevi-primary-soft);
            color: var(--intevi-primary);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        .lead-preview-title {
            margin: 18px 0 8px;
            color: var(--intevi-primary);
            font-size: 28px;
            line-height: 1.12;
            letter-spacing: -0.035em;
        }

        .lead-preview-text {
            margin: 0;
            color: var(--intevi-muted);
            font-size: 13px;
            line-height: 1.55;
        }

        .lead-preview-score {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 7px;
            margin-top: 23px;
        }

        .lead-preview-score span {
            height: 9px;
            border-radius: 99px;
            background: rgba(23, 28, 99, 0.12);
        }

        .lead-preview-score span:nth-child(-n + 3) {
            background: var(--intevi-primary);
        }

        .lead-preview-footer {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid var(--intevi-border);
            color: var(--intevi-muted);
            font-size: 11px;
            font-weight: 700;
        }

        .lead-preview-badge {
            position: absolute;
            right: 10px;
            bottom: -18px;
            max-width: 185px;
            padding: 15px 17px;
            border: 1px solid rgba(23, 28, 99, 0.10);
            border-radius: 17px;
            background: var(--intevi-white);
            color: var(--intevi-primary);
            box-shadow: 0 18px 45px rgba(16, 24, 40, 0.15);
            font-size: 12px;
            font-weight: 850;
            line-height: 1.45;
            transform: rotate(2deg);
        }

        .lead-form-card {
            overflow: hidden;
            border: 1px solid rgba(23, 28, 99, 0.11);
            border-radius: 28px;
            background: var(--intevi-white);
            box-shadow:
                0 30px 85px rgba(16, 24, 40, 0.14),
                0 5px 18px rgba(16, 24, 40, 0.05);
        }

        .lead-form-header {
            padding: 29px 30px 25px;
            background:
                linear-gradient(
                    135deg,
                    var(--intevi-primary),
                    var(--intevi-primary-light)
                );
            color: var(--intevi-white);
        }

        .lead-form-kicker {
            display: inline-flex;
            margin-bottom: 11px;
            padding: 6px 10px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            font-size: 11px;
            font-weight: 850;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .lead-form-title {
            margin: 0;
            font-size: 26px;
            line-height: 1.18;
            letter-spacing: -0.03em;
        }

        .lead-form-description {
            margin: 9px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 14px;
            line-height: 1.55;
        }

        .lead-form-secure {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            color: rgba(255, 255, 255, 0.88);
            font-size: 12px;
            font-weight: 650;
        }

        .lead-form-body {
            position: relative;
            min-height: 620px;
            background: var(--intevi-white);
        }

        .lead-form-loading {
            position: absolute;
            inset: 0;
            z-index: 0;
            display: grid;
            place-items: center;
            padding: 30px;
            color: var(--intevi-muted);
            text-align: center;
            font-size: 14px;
        }

        .lead-form-loading::before {
            width: 34px;
            height: 34px;
            margin: 0 auto 13px;
            border: 3px solid rgba(23, 28, 99, 0.12);
            border-top-color: var(--intevi-primary);
            border-radius: 50%;
            content: "";
            animation: lead-spin 0.8s linear infinite;
        }

        @keyframes lead-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .lead-form-iframe {
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            min-height: 620px;
            border: 0;
            background: var(--intevi-white);
        }

        .lead-privacy {
            margin: 17px 25px 24px;
            color: var(--intevi-muted);
            font-size: 11px;
            line-height: 1.55;
            text-align: center;
        }

        .lead-privacy a {
            color: var(--intevi-primary);
            font-weight: 750;
            text-decoration: none;
        }

        .lead-privacy a:hover {
            text-decoration: underline;
        }

        .lead-trust {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 24px;
        }

        .lead-trust-item {
            padding: 14px;
            border: 1px solid rgba(23, 28, 99, 0.09);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.78);
            color: var(--intevi-muted);
            font-size: 11px;
            font-weight: 700;
            line-height: 1.4;
            text-align: center;
            backdrop-filter: blur(8px);
        }

        .lead-footer {
            position: relative;
            z-index: 1;
            padding: 0 20px 28px;
            color: var(--intevi-muted);
            font-size: 12px;
            text-align: center;
        }

        .lead-footer a {
            color: var(--intevi-primary);
            font-weight: 750;
            text-decoration: none;
        }

        @media (max-width: 980px) {
            .lead-grid {
                grid-template-columns: 1fr;
                gap: 42px;
            }

            .lead-copy {
                padding-bottom: 0;
                text-align: center;
            }

            .lead-title,
            .lead-subtitle {
                margin-right: auto;
                margin-left: auto;
            }

            .lead-benefits {
                width: min(100%, 620px);
                margin-right: auto;
                margin-left: auto;
                text-align: left;
            }

            .lead-preview {
                margin-right: auto;
                margin-left: auto;
                text-align: left;
            }

            .lead-form-card {
                width: min(100%, 620px);
                margin: 0 auto;
            }
        }

        @media (max-width: 640px) {
            .lead-header,
            .lead-main {
                width: min(100% - 24px, 1180px);
            }

            .lead-header {
                padding-top: 17px;
            }

            .lead-main {
                padding-top: 15px;
                padding-bottom: 42px;
            }

            .lead-brand-mark {
                width: 37px;
                height: 37px;
                border-radius: 11px;
                font-size: 18px;
            }

            .lead-brand-name {
                font-size: 21px;
            }

            .lead-grid {
                gap: 34px;
            }

            .lead-copy {
                padding-top: 8px;
            }

            .lead-eyebrow {
                margin-bottom: 16px;
                font-size: 11px;
            }

            .lead-title {
                font-size: 38px;
                line-height: 1.07;
            }

            .lead-subtitle {
                margin-top: 18px;
                font-size: 16px;
                line-height: 1.65;
            }

            .lead-benefits {
                margin-top: 25px;
            }

            .lead-preview {
                margin-top: 30px;
                padding-left: 0;
            }

            .lead-preview-document {
                width: 100%;
                min-height: 245px;
                padding: 23px;
                transform: none;
            }

            .lead-preview-title {
                font-size: 24px;
            }

            .lead-preview-badge {
                position: relative;
                right: auto;
                bottom: auto;
                width: fit-content;
                max-width: 100%;
                margin: 12px 0 0 auto;
                transform: none;
            }

            .lead-form-card {
                border-radius: 20px;
            }

            .lead-form-header {
                padding: 23px 20px 21px;
            }

            .lead-form-title {
                font-size: 23px;
            }

            .lead-form-body,
            .lead-form-iframe {
                min-height: 690px;
            }

            .lead-trust {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @php
        /*
        |--------------------------------------------------------------------------
        | FORMULARIO DE BREVO PARA EL LEAD MAGNET
        |--------------------------------------------------------------------------
        |
        | Debes crear un formulario independiente en Brevo para el
        | Diagnóstico 5X y pegar aquí su URL.
        |
        | No utilices el mismo formulario de solicitud de demostración,
        | porque ambas acciones corresponden a etapas diferentes.
        |
        */

        $brevoFormUrl = env(
            'BREVO_DIAGNOSTICO_5X_FORM_URL',
            'PEGA_AQUI_LA_URL_DEL_FORMULARIO_DE_BREVO'
        );
    @endphp

    <div class="lead-page">

        <header class="lead-header">
            <a
                href="{{ url('/') }}"
                class="lead-brand"
                aria-label="Ir a la página principal de INTEVI"
            >
                <span class="lead-brand-mark" aria-hidden="true">
                    I
                </span>

                <span class="lead-brand-name">
                    INTEVI
                </span>
            </a>
        </header>

        <main class="lead-main">
            <div class="lead-grid">

                <section class="lead-copy">
                    <div class="lead-eyebrow">
                        <span
                            class="lead-eyebrow-dot"
                            aria-hidden="true"
                        ></span>

                        Diagnóstico gratuito para instituciones
                    </div>

                    <h1 class="lead-title">
                        Descubre qué tan controlado está tu
                        <strong>inventario institucional</strong>
                    </h1>

                    <p class="lead-subtitle">
                        Evalúa en aproximadamente 10 minutos si tu
                        organización puede comprobar
                        <strong>
                            qué bienes existen, dónde están, quién
                            responde por ellos y qué evidencia los respalda.
                        </strong>
                    </p>

                    <ul class="lead-benefits">
                        <li>
                            <span
                                class="lead-benefit-icon"
                                aria-hidden="true"
                            >
                                ✓
                            </span>

                            <span>
                                Identifica las principales brechas en el
                                control de tus bienes institucionales.
                            </span>
                        </li>

                        <li>
                            <span
                                class="lead-benefit-icon"
                                aria-hidden="true"
                            >
                                ✓
                            </span>

                            <span>
                                Evalúa existencia, ubicación, responsable,
                                evidencia e historial.
                            </span>
                        </li>

                        <li>
                            <span
                                class="lead-benefit-icon"
                                aria-hidden="true"
                            >
                                ✓
                            </span>

                            <span>
                                Obtén una puntuación inicial para conocer
                                el nivel de control de tu institución.
                            </span>
                        </li>

                        <li>
                            <span
                                class="lead-benefit-icon"
                                aria-hidden="true"
                            >
                                ✓
                            </span>

                            <span>
                                Define las acciones prioritarias que puedes
                                comenzar a implementar.
                            </span>
                        </li>
                    </ul>

                    <div
                        class="lead-preview"
                        aria-label="Vista previa del Diagnóstico 5X"
                    >
                        <article class="lead-preview-document">
                            <span class="lead-preview-label">
                                Recurso gratuito
                            </span>

                            <h2 class="lead-preview-title">
                                Diagnóstico de Control Institucional 5X
                            </h2>

                            <p class="lead-preview-text">
                                Una evaluación práctica para descubrir
                                qué tan fácil es comprobar y dar seguimiento
                                a los bienes de tu institución.
                            </p>

                            <div
                                class="lead-preview-score"
                                aria-hidden="true"
                            >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="lead-preview-footer">
                                <span>Evaluación práctica</span>
                                <span>INTEVI</span>
                            </div>
                        </article>

                        <div class="lead-preview-badge">
                            Incluye criterios de evaluación y un plan inicial
                            de mejora.
                        </div>
                    </div>
                </section>

                <aside class="lead-form-area">
                    <section
                        class="lead-form-card"
                        aria-labelledby="lead-form-title"
                    >
                        <header class="lead-form-header">
                            <span class="lead-form-kicker">
                                Descarga inmediata
                            </span>

                            <h2
                                id="lead-form-title"
                                class="lead-form-title"
                            >
                                Recibe gratis el Diagnóstico 5X
                            </h2>

                            <p class="lead-form-description">
                                Completa tus datos y te enviaremos el recurso
                                a tu correo.
                            </p>

                            <div class="lead-form-secure">
                                <span aria-hidden="true">🔒</span>

                                Tus datos serán utilizados únicamente para
                                enviarte el recurso y contenido relacionado.
                            </div>
                        </header>

                        <div class="lead-form-body">
                            <div
                                class="lead-form-loading"
                                aria-hidden="true"
                            >
                                <div>
                                    Cargando formulario seguro…
                                </div>
                            </div>

                            <iframe
                                class="lead-form-iframe"
                                title="Formulario para recibir el Diagnóstico 5X de INTEVI"
                                src="{{ $brevoFormUrl }}"
                                width="100%"
                                height="620"
                                loading="eager"
                                referrerpolicy="strict-origin-when-cross-origin"
                            ></iframe>
                        </div>

                        <p class="lead-privacy">
                            Al enviar el formulario aceptas recibir el
                            Diagnóstico 5X y comunicaciones relacionadas
                            con el control de inventario institucional.
                            Puedes cancelar tu suscripción en cualquier
                            momento.

                            <a href="{{ route('privacidad') }}">
                                Consulta el aviso de privacidad
                            </a>.
                        </p>
                    </section>

                    <div
                        class="lead-trust"
                        aria-label="Características del recurso"
                    >
                        <div class="lead-trust-item">
                            Recurso completamente gratuito
                        </div>

                        <div class="lead-trust-item">
                            Aplicable a instituciones y organizaciones
                        </div>

                        <div class="lead-trust-item">
                            No requiere contratar INTEVI
                        </div>
                    </div>
                </aside>

            </div>
        </main>

        <footer class="lead-footer">
            © {{ date('Y') }} INTEVI · Inventario y resguardo institucional ·

            <a href="{{ url('/') }}">
                Conocer la plataforma
            </a>
        </footer>

    </div>
</body>
</html>