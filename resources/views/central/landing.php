<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Solicita una demostración | INTEVI</title>

    <meta
        name="description"
        content="Solicita una demostración de INTEVI y conoce cómo controlar inventarios, ubicaciones, responsables, resguardos e historiales institucionales."
    >

    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#171C63">

    <style>
        :root {
            --intevi-primary: #171C63;
            --intevi-primary-light: #292f91;
            --intevi-background: #f4f6fb;
            --intevi-text: #151a2d;
            --intevi-muted: #667085;
            --intevi-border: #e4e7ec;
            --intevi-white: #ffffff;
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
                    circle at top left,
                    rgba(23, 28, 99, 0.10),
                    transparent 32%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(23, 28, 99, 0.08),
                    transparent 30%
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

        .demo-page {
            min-height: 100vh;
            padding: 42px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .demo-container {
            width: 100%;
            max-width: 760px;
        }

        .demo-header {
            margin-bottom: 24px;
            text-align: center;
        }

        .demo-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 22px;
            color: var(--intevi-primary);
            text-decoration: none;
        }

        .demo-logo img {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        .demo-logo span {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .demo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            padding: 8px 14px;
            border: 1px solid rgba(23, 28, 99, 0.12);
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.07);
            color: var(--intevi-primary);
            font-size: 13px;
            font-weight: 750;
        }

        .demo-title {
            max-width: 650px;
            margin: 0 auto 12px;
            color: var(--intevi-primary);
            font-size: clamp(30px, 5vw, 46px);
            line-height: 1.08;
            letter-spacing: -0.04em;
        }

        .demo-description {
            max-width: 620px;
            margin: 0 auto;
            color: var(--intevi-muted);
            font-size: 17px;
            line-height: 1.65;
        }

        .demo-benefits {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px 18px;
            margin: 22px auto 0;
            padding: 0;
            list-style: none;
            color: #344054;
            font-size: 14px;
            font-weight: 650;
        }

        .demo-benefits li {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .demo-benefits li::before {
            content: "✓";
            display: inline-flex;
            width: 20px;
            height: 20px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(23, 28, 99, 0.10);
            color: var(--intevi-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .demo-card {
            overflow: hidden;
            margin-top: 30px;
            border: 1px solid rgba(23, 28, 99, 0.10);
            border-radius: 24px;
            background: var(--intevi-white);
            box-shadow:
                0 24px 70px rgba(16, 24, 40, 0.10),
                0 4px 14px rgba(16, 24, 40, 0.05);
        }

        .demo-card-topbar {
            padding: 20px 24px;
            border-bottom: 1px solid var(--intevi-border);
            background: linear-gradient(
                135deg,
                var(--intevi-primary),
                var(--intevi-primary-light)
            );
            color: var(--intevi-white);
            text-align: center;
        }

        .demo-card-topbar strong {
            display: block;
            margin-bottom: 5px;
            font-size: 18px;
        }

        .demo-card-topbar span {
            font-size: 13px;
            opacity: 0.88;
        }

        .demo-frame-wrap {
            width: 100%;
            min-height: 600px;
            padding: 0;
            background: var(--intevi-white);
        }

        .demo-iframe {
            display: block;
            width: 100%;
            min-height: 600px;
            border: 0;
            background: var(--intevi-white);
        }

        .demo-privacy {
            margin: 18px auto 0;
            color: var(--intevi-muted);
            font-size: 12px;
            line-height: 1.6;
            text-align: center;
        }

        .demo-privacy a {
            color: var(--intevi-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .demo-privacy a:hover {
            text-decoration: underline;
        }

        .demo-back {
            display: table;
            margin: 18px auto 0;
            color: var(--intevi-primary);
            font-size: 14px;
            font-weight: 750;
            text-decoration: none;
        }

        .demo-back:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .demo-page {
                padding: 24px 12px;
                align-items: flex-start;
            }

            .demo-header {
                margin-bottom: 18px;
            }

            .demo-logo {
                margin-bottom: 18px;
            }

            .demo-logo img {
                width: 39px;
                height: 39px;
            }

            .demo-logo span {
                font-size: 23px;
            }

            .demo-title {
                font-size: 31px;
            }

            .demo-description {
                font-size: 15px;
            }

            .demo-benefits {
                display: grid;
                justify-content: start;
                max-width: 320px;
                margin-top: 20px;
                text-align: left;
            }

            .demo-card {
                margin-top: 24px;
                border-radius: 17px;
            }

            .demo-card-topbar {
                padding: 17px 15px;
            }

            .demo-frame-wrap,
            .demo-iframe {
                min-height: 680px;
            }
        }
    </style>
</head>

<body>
    @php
        $brevoFormUrl = 'https://c9015cf0.sibforms.com/v2/serve/MUIFAKBtKumOeQ_vSPH4Fxc7sj3KkltZg_HQSUsH-CugU2MCkC8ZHdbYq2Zch6Z44BMj5yndHZmM3XoVk-ljtgcKxi77ZjEDjiDqvHslUhQXB0s8XYnRCYeTP2cGeFJ9MwXBF8UfHc5Yd4TvrMY7pGXQOn_gKXYPqdaEWzv6hoPLSi9KUxLXG_OuKz2fZlTvY8TrUTI9kPpx0b95aw==';
    @endphp

    <main class="demo-page">
        <div class="demo-container">

            <header class="demo-header">
                <a
                    href="{{ url('/') }}"
                    class="demo-logo"
                    aria-label="Volver al inicio de INTEVI"
                >
                    <img
                        src="{{ asset('images/intevi logo.png') }}"
                        alt="Logotipo de INTEVI"
                    >

                    <span>INTEVI</span>
                </a>

                <div>
                    <span class="demo-badge">
                        Demostración personalizada
                    </span>
                </div>

                <h1 class="demo-title">
                    Conoce cómo controlar tus bienes institucionales
                </h1>

                <p class="demo-description">
                    Completa el formulario y revisaremos cómo INTEVI puede
                    ayudarte a organizar inventarios, responsables,
                    ubicaciones, resguardos e historiales.
                </p>

                <ul class="demo-benefits" aria-label="Beneficios de la demostración">
                    <li>Sin compromiso</li>
                    <li>Atención personalizada</li>
                    <li>Plataforma en funcionamiento</li>
                </ul>
            </header>

            <section
                class="demo-card"
                aria-labelledby="demo-form-title"
            >
                <div class="demo-card-topbar">
                    <strong id="demo-form-title">
                        Solicita tu demostración
                    </strong>

                    <span>
                        Cuéntanos brevemente sobre tu institución
                    </span>
                </div>

                <div class="demo-frame-wrap">
                    <iframe
                        class="demo-iframe"
                        title="Formulario para solicitar una demostración de INTEVI"
                        src="{{ $brevoFormUrl }}"
                        width="100%"
                        height="600"
                        loading="eager"
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>
                </div>
            </section>

            <p class="demo-privacy">
                Usaremos tus datos únicamente para atender tu solicitud
                y proporcionar seguimiento comercial.

                <a href="{{ route('privacidad') }}">
                    Consulta el aviso de privacidad
                </a>.
            </p>

            <a href="{{ url('/') }}" class="demo-back">
                ← Volver al sitio de INTEVI
            </a>
        </div>
    </main>
</body>
</html>