<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $contactEmail = 'contacto@intevi.app';
        $taxLegend = 'El tratamiento de impuestos y facturación se confirma por escrito antes de contratar.';
        $brevoFormUrl = 'https://c9015cf0.sibforms.com/v2/serve/MUIFAKBtKumOeQ_vSPH4Fxc7sj3KkltZg_HQSUsH-CugU2MCkC8ZHdbYq2Zch6Z44BMj5yndHZmM3XoVk-ljtgcKxi77ZjEDjiDqvHslUhQXB0s8XYnRCYeTP2cGeFJ9MwXBF8UfHc5Yd4TvrMY7pGXQOn_gKXYPqdaEWzv6hoPLSi9KUxLXG_OuKz2fZlTvY8TrUTI9kPpx0b95aw==';

        $versionedAsset = static function (string $path): string {
            $absolutePath = public_path($path);
            $version = is_file($absolutePath) ? (string) filemtime($absolutePath) : '1';

            return asset($path) . '?v=' . $version;
        };

        $demoSubject = rawurlencode('Solicitud de demostración de INTEVI');
        $demoBody = rawurlencode(
            "Hola, me interesa solicitar una demostración de INTEVI.\n\n" .
            "Institución:\n" .
            "Nombre:\n" .
            "Cargo:\n" .
            "Teléfono:\n" .
            "Número aproximado de bienes:\n"
        );
        $demoMailto = "mailto:{$contactEmail}?subject={$demoSubject}&body={$demoBody}";

        $faqItems = [
            [
                'question' => '¿INTEVI es un sistema de almacén?',
                'answer' => 'No exactamente. INTEVI está especializado en el control de bienes institucionales y en relacionarlos con responsables, áreas, ubicaciones, documentos e historiales de resguardo.',
            ],
            [
                'question' => '¿Qué tipo de bienes se pueden registrar?',
                'answer' => 'Equipos tecnológicos, mobiliario, herramientas, activos administrativos y otros bienes que la institución necesite identificar, ubicar y asignar.',
            ],
            [
                'question' => '¿INTEVI ya se utiliza en entornos institucionales?',
                'answer' => 'INTEVI cuenta con experiencia de uso en el Instituto de Investigaciones Históricas de la UMSNH y en el IEESSPP Michoacán. Esta experiencia ha orientado el desarrollo de sus flujos de inventario y resguardo.',
            ],
            [
                'question' => '¿Podemos cargar información desde Excel?',
                'answer' => 'Sí. La plataforma incorpora carga masiva para determinados catálogos, como marcas, puestos y áreas de asignación, con el fin de reducir la captura manual durante la implementación.',
            ],
            [
                'question' => '¿Todos los usuarios tienen el mismo acceso?',
                'answer' => 'No. Los roles y permisos permiten organizar qué puede consultar o administrar cada usuario según sus responsabilidades.',
            ],
            [
                'question' => '¿La información de distintas instituciones se mezcla?',
                'answer' => 'No. Cada organización trabaja dentro de un entorno independiente con su propio dominio, usuarios e información.',
            ],
            [
                'question' => '¿Hay que instalar INTEVI en cada computadora?',
                'answer' => 'No. INTEVI funciona como plataforma web y se utiliza mediante un navegador compatible con conexión a Internet.',
            ],
            [
                'question' => '¿El asistente de IA puede ver la información institucional?',
                'answer' => 'El asistente incluido está orientado a resolver preguntas frecuentes sobre el uso de INTEVI. No consulta automáticamente la base de datos institucional ni recibe su información operativa, salvo que en el futuro se contrate e implemente una integración específica.',
            ],
            [
                'question' => '¿Qué incluye el primer año?',
                'answer' => 'Incluye el entorno institucional, los módulos del alcance estándar, configuración inicial, hasta 10 usuarios individuales, 2 GB de almacenamiento, tutoriales guiados, acompañamiento de arranque, mantenimiento y actualizaciones generales.',
            ],
            [
                'question' => '¿Cuánto cuesta renovar?',
                'answer' => 'La implementación para instituciones fundadoras es de $6,999 MXN durante el primer año. A partir del segundo año, la renovación anual es de $9,999 MXN dentro del alcance estándar contratado.',
            ],
            [
                'question' => '¿El precio incluye impuestos y facturación?',
                'answer' => $taxLegend,
            ],
            [
                'question' => '¿Qué sucede si necesitamos más de 10 usuarios o más de 2 GB?',
                'answer' => 'Los usuarios y la capacidad adicionales se cotizan según la necesidad de la institución. El costo y el alcance se informan antes de realizar cualquier ampliación.',
            ],
            [
                'question' => '¿Qué soporte está incluido?',
                'answer' => 'La implementación incluye acompañamiento de arranque, tutoriales guiados y atención de dudas relacionadas con el uso estándar. Desarrollos, integraciones y personalizaciones se cotizan por separado.',
            ],
            [
                'question' => '¿Qué sucede con la información si no renovamos?',
                'answer' => 'Antes de finalizar el servicio se informa el procedimiento aplicable para entregar o exportar la información disponible y cerrar el entorno institucional conforme al alcance contratado.',
            ],
            [
                'question' => '¿Cómo podemos conocer el sistema?',
                'answer' => 'Solicita una demostración. Revisaremos la plataforma y podrás explicar las necesidades actuales de tu organización antes de decidir.',
            ],
        ];

        $structuredData = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'INTEVI',
                'url' => 'https://intevi.app/',
                'logo' => asset('images/intevi logo.png'),
                'email' => $contactEmail,
                'description' => 'Plataforma web para control de inventario, resguardos, responsables, ubicaciones, evidencias e historiales de bienes institucionales.',
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareApplication',
                'name' => 'INTEVI',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Web',
                'url' => 'https://intevi.app/',
                'description' => 'Sistema de inventario y resguardo institucional que conecta bienes, responsables, ubicaciones, documentos e historiales.',
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'MXN',
                    'price' => '6999',
                    'description' => 'Implementación durante el primer año para instituciones fundadoras, dentro del alcance estándar.',
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(
                    static fn (array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['answer'],
                        ],
                    ],
                    $faqItems
                ),
            ],
        ];
    @endphp

    <title>INTEVI | Inventario y resguardo institucional</title>
    <meta name="description" content="Controla bienes institucionales, responsables, ubicaciones, evidencias e historiales desde una sola plataforma web. Solicita una demostración de INTEVI.">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#171C63">
    <meta name="color-scheme" content="light">
    <link rel="canonical" href="https://intevi.app/">

    <meta property="og:locale" content="es_MX">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://intevi.app/">
    <meta property="og:title" content="INTEVI | Inventario y resguardo institucional">
    <meta property="og:description" content="Identifica qué bienes existen, dónde están, quién responde por ellos y qué evidencia los respalda.">
    <meta property="og:image" content="{{ $versionedAsset('images/intevi-social.webp') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Vista de la plataforma INTEVI para inventario y resguardo institucional">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="INTEVI | Inventario y resguardo institucional">
    <meta name="twitter:description" content="Controla bienes, responsables, ubicaciones, evidencias e historiales desde una sola plataforma.">
    <meta name="twitter:image" content="{{ $versionedAsset('images/intevi-social.webp') }}">

    <link rel="preload" href="{{ $versionedAsset('css/intevi-landing.css') }}" as="style">
    <link rel="stylesheet" href="{{ $versionedAsset('css/intevi-landing.css') }}">

    <link
        rel="preload"
        as="image"
        href="{{ $versionedAsset('images/intevi-plataforma-1600.webp') }}"
        imagesrcset="{{ $versionedAsset('images/intevi-plataforma-720.webp') }} 720w, {{ $versionedAsset('images/intevi-plataforma-1120.webp') }} 1120w, {{ $versionedAsset('images/intevi-plataforma-1600.webp') }} 1600w"
        imagesizes="(max-width: 960px) 100vw, 58vw"
        fetchpriority="high"
    >

    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    <script src="{{ $versionedAsset('js/intevi-clarity.js') }}" defer></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NETSEPFHTT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-NETSEPFHTT', { anonymize_ip: true });
    </script>

    <script src="{{ $versionedAsset('js/intevi-landing.js') }}" defer></script>
</head>
<body>
<a class="skip-link" href="#contenido-principal">Saltar al contenido principal</a>

<svg width="0" height="0" aria-hidden="true" focusable="false" style="position:absolute">
    <symbol id="icon-check" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-building" viewBox="0 0 24 24"><path d="M3 21h18M5 21V8l7-4 7 4v13M9 12h1M14 12h1M9 16h1M14 16h1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-box" viewBox="0 0 24 24"><path d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7M12 11v10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></symbol>
    <symbol id="icon-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M4 21a8 8 0 0 1 16 0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></symbol>
    <symbol id="icon-pin" viewBox="0 0 24 24"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="10" r="2.5" fill="none" stroke="currentColor" stroke-width="1.8"/></symbol>
    <symbol id="icon-file" viewBox="0 0 24 24"><path d="M6 2h8l4 4v16H6zM14 2v5h5M9 12h6M9 16h6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-history" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 3-6.7L3 8M3 3v5h5M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-tag" viewBox="0 0 24 24"><path d="M3 12V4h8l10 10-8 8L3 12Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="8" cy="9" r="1.5" fill="currentColor"/></symbol>
    <symbol id="icon-shield" viewBox="0 0 24 24"><path d="M12 3 20 6v6c0 5-3.4 8-8 10-4.6-2-8-5-8-10V6l8-3Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m8.5 12 2.2 2.2 4.8-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-upload" viewBox="0 0 24 24"><path d="M12 16V4m0 0L7 9m5-5 5 5M4 15v5h16v-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m20 20-4-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></symbol>
    <symbol id="icon-lock" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M8 10V7a4 4 0 0 1 8 0v3" fill="none" stroke="currentColor" stroke-width="1.8"/></symbol>
</svg>

<header class="site-header">
    <div class="container navbar">
        <a href="#inicio" class="brand" aria-label="Ir al inicio de INTEVI">
            <img
                src="{{ asset('images/intevi logo.png') }}"
                alt="INTEVI"
                class="brand-logo"
                width="48"
                height="48"
                decoding="async"
            >
            <span class="brand-text">
                <span class="brand-name">INTEVI</span>
                <span class="brand-description">Inventario y resguardo institucional</span>
            </span>
        </a>

        <nav class="nav-area" id="navigation" aria-label="Navegación principal">
            <ul class="nav-links">
                <li><a class="nav-link" href="#metodo">Control Institucional 5X</a></li>
                <li><a class="nav-link" href="#plataforma">Plataforma</a></li>
                <li><a class="nav-link" href="#implementacion">Implementación</a></li>
                <li><a class="nav-link" href="#oferta">Precio</a></li>
                <li><a class="nav-link" href="#preguntas">Preguntas</a></li>
            </ul>
            <a class="button button-primary nav-cta" href="#formulario-demo" data-analytics="demo-cta" data-location="header">Solicitar demostración</a>
        </nav>

        <button
            class="menu-button"
            id="menuButton"
            type="button"
            aria-expanded="false"
            aria-controls="navigation"
            aria-label="Abrir menú"
        ><span></span></button>
    </div>
</header>

<main id="contenido-principal">
    <section class="hero" id="inicio">
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="hero-tag"><span class="hero-tag-dot"></span>Control de bienes institucionales</div>

                <h1 class="hero-title">
                    No basta con saber qué bienes tienes.
                    <span>Debes saber dónde están, quién responde por ellos y qué lo comprueba.</span>
                </h1>

                <p class="hero-description">
                    INTEVI conecta cada bien con su ubicación, responsable, evidencia e historial para que tu institución mantenga el control desde una sola plataforma.
                </p>

                <div class="hero-actions">
                    <a class="button button-primary" href="#formulario-demo" data-analytics="demo-cta" data-location="hero">Solicitar demostración</a>
                    <a class="button button-outline" href="#metodo">Conocer el Control Institucional 5X</a>
                </div>

                <div class="hero-proof-list" aria-label="Características principales">
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Funciona desde el navegador</span>
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Sin instalación por equipo</span>
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Demostración sin compromiso</span>
                </div>
            </div>

            <div class="product-preview">
                <div class="preview-label">Vista real de la plataforma</div>
                <div class="browser-shell">
                    <div class="browser-bar">
                        <div class="browser-dots"><span></span><span></span><span></span></div>
                        <div class="browser-address"><svg><use href="#icon-lock"/></svg><span>tuinstitucion.intevi.app/inventario</span></div>
                        <div class="browser-menu"><span></span><span></span><span></span></div>
                    </div>
                    <picture class="platform-picture">
                        <source media="(max-width: 720px)" srcset="{{ $versionedAsset('images/intevi-plataforma-720.webp') }}">
                        <source media="(max-width: 1200px)" srcset="{{ $versionedAsset('images/intevi-plataforma-1120.webp') }}">
                        <img
                            src="{{ $versionedAsset('images/intevi-plataforma-1600v2.png') }}"
                            alt="Vista real del módulo de inventario de INTEVI con búsqueda, bienes registrados, ubicación y resguardante"
                            width="1600"
                            height="735"
                            loading="eager"
                            fetchpriority="high"
                            decoding="async"
                        >
                    </picture>
                </div>
                <div class="product-floating-card"><small>Operación institucional</small><strong>Información centralizada</strong></div>
            </div>
        </div>
    </section>

    <section class="usage-strip" aria-labelledby="uso-institucional-title">
        <div class="container usage-layout">
            <div class="usage-intro">
                <small id="uso-institucional-title">Experiencia de uso institucional</small>
                <strong>Desarrollado y probado desde necesidades reales</strong>
            </div>
            <div class="usage-badges">
                <div class="usage-badge">
                    <span class="usage-badge-icon"><svg><use href="#icon-building"/></svg></span>
                    <div><strong>Instituto de Investigaciones Históricas</strong><span>Universidad Michoacana de San Nicolás de Hidalgo</span></div>
                </div>
                <div class="usage-badge">
                    <span class="usage-badge-icon"><svg><use href="#icon-shield"/></svg></span>
                    <div><strong>IEESSPP Michoacán</strong><span>Experiencia de uso en un entorno institucional</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section deferred-section" id="problema">
        <div class="container problem-layout">
            <div class="problem-statement">
                <span class="eyebrow">El costo del descontrol</span>
                <p class="problem-quote">Un inventario disperso no solo consume tiempo: <span>debilita la trazabilidad y la responsabilidad institucional.</span></p>
                <p class="problem-caption">INTEVI organiza la información alrededor del bien, no alrededor de archivos aislados.</p>
            </div>

            <div class="problem-list">
                <article class="problem-item"><span class="problem-number">01</span><div><h3>Horas buscando información</h3><p>Datos repartidos entre hojas de cálculo, documentos, carpetas, fotografías y conocimiento del personal.</p></div></article>
                <article class="problem-item"><span class="problem-number">02</span><div><h3>Trabajo repetido</h3><p>La misma información se captura, compara y corrige en diferentes formatos.</p></div></article>
                <article class="problem-item"><span class="problem-number">03</span><div><h3>Responsabilidad poco clara</h3><p>Se dificulta comprobar quién recibió un bien, dónde se encuentra y qué evidencia existe.</p></div></article>
                <article class="problem-item"><span class="problem-number">04</span><div><h3>Pérdida de continuidad</h3><p>Cuando cambia el personal, parte del control puede irse con quien conocía los archivos.</p></div></article>
            </div>
        </div>
    </section>

    <section class="section section-dark deferred-section" id="metodo">
        <div class="container">
            <div class="method-header">
                <div>
                    <span class="eyebrow">Control Institucional 5X</span>
                    <h2 class="heading heading-medium">Cada bien debe responder cinco preguntas.</h2>
                    <p class="section-copy">INTEVI no se limita a guardar una lista: relaciona la información necesaria para demostrar que un activo está realmente bajo control.</p>
                </div>
                <div class="method-summary">
                    <strong>Un modelo sencillo para una operación compleja</strong>
                    <p>Control Institucional 5X organiza el proceso alrededor de existencia, ubicación, responsable, evidencia e historial.</p>
                </div>
            </div>

            <div class="method-grid">
                <article class="method-card"><span class="method-number">01</span><h3>Existencia</h3><strong>¿Qué bien existe?</strong><p>Descripción, marca, serie, cantidad, estado y datos institucionales.</p></article>
                <article class="method-card"><span class="method-number">02</span><h3>Ubicación</h3><strong>¿Dónde se encuentra?</strong><p>Área de asignación y ubicación física actual del bien.</p></article>
                <article class="method-card"><span class="method-number">03</span><h3>Responsable</h3><strong>¿Quién responde por él?</strong><p>Persona, puesto y área que utiliza o mantiene el bien bajo resguardo.</p></article>
                <article class="method-card"><span class="method-number">04</span><h3>Evidencia</h3><strong>¿Qué lo comprueba?</strong><p>Documentos, imágenes y datos relacionados con la entrega y el resguardo.</p></article>
                <article class="method-card"><span class="method-number">05</span><h3>Historial</h3><strong>¿Qué ha sucedido?</strong><p>Asignaciones, cambios, liberaciones y antecedentes consultables.</p></article>
            </div>
        </div>
    </section>

    <section class="section section-soft deferred-section" id="plataforma">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Una plataforma conectada</span>
                    <h2 class="heading heading-medium">Herramientas para controlar bienes sin depender de procesos dispersos.</h2>
                </div>
                <p class="section-copy">Cada módulo alimenta la trazabilidad del bien para que inventario, resguardo, ubicación y evidencia se consulten dentro del mismo entorno.</p>
            </div>

            <div class="feature-grid">
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-box"/></svg></span><h3>Inventario institucional</h3><p>Registra bienes con descripción, marca, serie, cantidad, estado, características y datos de identificación.</p><span class="feature-result">Existencia identificada</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-user"/></svg></span><h3>Resguardantes y puestos</h3><p>Relaciona personas, puestos y áreas con los bienes que utilizan o tienen asignados.</p><span class="feature-result">Responsabilidad clara</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-pin"/></svg></span><h3>Ubicaciones físicas</h3><p>Organiza dónde se encuentra cada bien y conserva evidencia visual relacionada con el espacio.</p><span class="feature-result">Localización consultable</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-building"/></svg></span><h3>Áreas de asignación</h3><p>Estructura la distribución institucional de los bienes de acuerdo con áreas y responsabilidades.</p><span class="feature-result">Orden organizacional</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-file"/></svg></span><h3>Documentos e imágenes</h3><p>Conserva evidencia asociada con ubicaciones y resguardos para respaldar la información registrada.</p><span class="feature-result">Evidencia vinculada</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-history"/></svg></span><h3>Historial de resguardos</h3><p>Consulta asignaciones, cambios y liberaciones para conocer qué ha sucedido con cada bien.</p><span class="feature-result">Trazabilidad histórica</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-tag"/></svg></span><h3>Etiquetas identificables</h3><p>Genera etiquetas para agilizar la identificación y consulta de bienes durante recorridos o revisiones.</p><span class="feature-result">Consulta más rápida</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-upload"/></svg></span><h3>Carga de catálogos</h3><p>Importa determinados catálogos desde Excel para reducir la captura manual durante el arranque.</p><span class="feature-result">Implementación ágil</span></article>
                <article class="feature-card"><span class="feature-icon"><svg><use href="#icon-shield"/></svg></span><h3>Usuarios, roles y permisos</h3><p>Organiza el acceso de cada usuario según las responsabilidades definidas por la institución.</p><span class="feature-result">Acceso controlado</span></article>
            </div>
        </div>
    </section>

    <section class="section section-warm deferred-section" id="implementacion">
        <div class="container">
            <div class="section-heading">
                <div><span class="eyebrow">Implementación acompañada</span><h2 class="heading heading-medium">No te entregamos un acceso y te dejamos solo.</h2></div>
                <p class="section-copy">El arranque se organiza para que la institución comprenda el sistema, prepare sus catálogos y comience con un proceso definido.</p>
            </div>

            <div class="implementation-grid">
                <article class="implementation-card"><span class="implementation-number">01</span><h3>Diagnóstico inicial</h3><p>Revisamos el proceso actual, tipos de bienes, estructura institucional y necesidades principales.</p></article>
                <article class="implementation-card"><span class="implementation-number">02</span><h3>Configuración</h3><p>Preparamos el entorno institucional, usuarios y parámetros incluidos en el alcance estándar.</p></article>
                <article class="implementation-card"><span class="implementation-number">03</span><h3>Preparación de información</h3><p>Orientamos la carga de catálogos y el orden recomendado para comenzar a registrar bienes.</p></article>
                <article class="implementation-card"><span class="implementation-number">04</span><h3>Capacitación y arranque</h3><p>La institución conoce los flujos principales y cuenta con tutoriales para continuar operando.</p></article>
            </div>
        </div>
    </section>

    <section class="section deferred-section" id="instituciones">
        <div class="container trust-layout">
            <div class="trust-panel" aria-label="Ejemplo de entorno institucional independiente">
                <div class="domain-preview"><div class="domain-dots"><span></span><span></span><span></span></div><div class="domain-address"><strong>tuinstitucion</strong>.intevi.app</div></div>
                <div class="institution-card">
                    <div class="institution-card-header"><span class="institution-card-icon"><svg><use href="#icon-building"/></svg></span><div><small>Entorno independiente</small><strong>Información de tu institución</strong></div></div>
                    <div class="trust-list">
                        <div class="trust-item"><span class="trust-item-icon"><svg><use href="#icon-shield"/></svg></span><div><strong>Usuarios y permisos propios</strong><p>La institución define quién consulta y administra cada módulo.</p></div></div>
                        <div class="trust-item"><span class="trust-item-icon"><svg><use href="#icon-lock"/></svg></span><div><strong>Acceso mediante HTTPS</strong><p>La plataforma se utiliza desde el navegador dentro del entorno asignado.</p></div></div>
                        <div class="trust-item"><span class="trust-item-icon"><svg><use href="#icon-history"/></svg></span><div><strong>Actualizaciones centralizadas</strong><p>La institución no tiene que instalar manualmente cada mejora en sus equipos.</p></div></div>
                    </div>
                </div>
            </div>

            <div>
                <span class="eyebrow">Separación y confianza</span>
                <h2 class="heading heading-medium">Cada institución trabaja dentro de su propio entorno.</h2>
                <p class="section-copy">Los accesos, usuarios e información se organizan por institución. El asistente especializado está pensado para resolver dudas frecuentes de uso y no consulta automáticamente la base de datos institucional.</p>
                <div class="hero-proof-list">
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Dominio institucional independiente</span>
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Roles y permisos configurables</span>
                    <span class="hero-proof-item"><svg><use href="#icon-check"/></svg>Mantenimiento centralizado</span>
                </div>
            </div>
        </div>
    </section>

    <section class="offer-section deferred-section" id="oferta">
        <div class="container">
            <div class="offer-header">
                <span class="eyebrow">Alcance claro desde el inicio</span>
                <h2 class="heading heading-medium">Implementación anual de INTEVI para instituciones fundadoras.</h2>
                <p class="section-copy">Plataforma, configuración y acompañamiento incluidos dentro de un alcance estándar que se confirma por escrito antes de contratar.</p>
            </div>

            <div class="offer-grid">
                <article class="price-card">
                    <span class="offer-label">Programa para instituciones fundadoras</span>
                    <h3>Primer año de implementación</h3>
                    <h3>Todo lo necesario para comenzar con una sola licencia</h3>

                    <div class="price-main"><span class="price-amount">$6,999</span><span class="price-period">MXN durante el primer año</span></div>
                    <p class="renewal-note"><strong>Renovación:</strong> $9,999 MXN al año a partir del segundo año. El precio se informa desde el inicio para que la institución conozca su inversión futura.</p>

                    <div class="offer-list">
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Licencia anual y entorno institucional</strong><p>Acceso a los módulos incluidos en el alcance estándar.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Hasta 10 usuarios individuales</strong><p>Cuentas independientes con roles y permisos configurables.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>2 GB de almacenamiento</strong><p>Para imágenes, documentos y archivos asociados con ubicaciones y resguardos.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Control Institucional 5X</strong><p>Integrado en la forma de organizar los bienes dentro de la plataforma.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Configuración y acompañamiento de arranque</strong><p>Orientación inicial, preparación de catálogos y capacitación de uso.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Tutoriales y asistente especializado</strong><p>Apoyo para resolver dudas frecuentes relacionadas con el funcionamiento estándar.</p></div></div>
                        <div class="offer-item"><svg><use href="#icon-check"/></svg><div><strong>Mantenimiento y actualizaciones generales</strong><p>Sin instalaciones manuales en cada computadora.</p></div></div>
                    </div>

                    <p class="tax-note">{{ $taxLegend }}</p>
                    <p class="scope-note">Usuarios adicionales, mayor capacidad, integraciones, desarrollos especiales y personalizaciones se cotizan por separado.</p>
                </article>

                <article class="demo-card" id="formulario-demo">
                    <div class="demo-card-header">
                        <small>Demostración sin compromiso</small>
                        <h3>Conoce INTEVI con el proceso de tu institución en mente.</h3>
                        <p>Completa el formulario para coordinar una demostración y revisar tus necesidades actuales.</p>
                    </div>

                    <div class="demo-frame-wrap" data-demo-frame>
                        <div class="demo-frame-skeleton" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>
                        <iframe
                            class="demo-iframe"
                            title="Formulario para solicitar una demostración de INTEVI"
                            data-src="{{ $brevoFormUrl }}"
                            src="about:blank"
                            width="540"
                            height="550"
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                        ></iframe>
                        <noscript>
                            <iframe
                                class="demo-iframe"
                                title="Formulario para solicitar una demostración de INTEVI"
                                src="{{ $brevoFormUrl }}"
                                width="540"
                                height="550"
                                loading="lazy"
                            ></iframe>
                        </noscript>
                    </div>

                    <p class="privacy-microcopy">Usaremos tus datos únicamente para atender la solicitud y dar seguimiento comercial. Consulta el <a href="{{ route('privacidad') }}">aviso de privacidad</a>.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section deferred-section">
        <div class="container decision-grid">
            <div>
                <span class="eyebrow">Decisión informada</span>
                <h2 class="heading heading-medium">Primero conoces la plataforma. Después decides.</h2>
                <p class="section-copy">La demostración permite revisar el funcionamiento real, aclarar el alcance y evitar que la institución contrate con expectativas ambiguas.</p>
            </div>
            <div class="decision-card">
                <h3>La contratación se construye sobre condiciones claras.</h3>
                <div class="decision-list">
                    <span class="decision-item"><svg><use href="#icon-check"/></svg>Demostración previa y sin compromiso de contratación.</span>
                    <span class="decision-item"><svg><use href="#icon-check"/></svg>Alcance, precio, usuarios, almacenamiento y renovación confirmados por escrito.</span>
                    <span class="decision-item"><svg><use href="#icon-check"/></svg>Personalizaciones e integraciones cotizadas antes de comenzar.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft deferred-section" id="preguntas">
        <div class="container faq-layout">
            <div class="faq-intro">
                <span class="eyebrow">Preguntas frecuentes</span>
                <h2 class="heading heading-medium">Resuelve las dudas principales antes de solicitar una demostración.</h2>
                <p class="section-copy">También puedes escribir directamente a <a href="{{ $demoMailto }}" style="color:var(--primary);font-weight:800">{{ $contactEmail }}</a>.</p>
            </div>

            <div class="faq-list">
                @foreach ($faqItems as $index => $faq)
                    @php
                        $questionId = 'faq-question-' . $index;
                        $answerId = 'faq-answer-' . $index;
                    @endphp
                    <article class="faq-item {{ $index === 0 ? 'open' : '' }}">
                        <button
                            class="faq-question"
                            id="{{ $questionId }}"
                            type="button"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="{{ $answerId }}"
                        ><span>{{ $faq['question'] }}</span><span class="faq-symbol" aria-hidden="true">+</span></button>
                        <div class="faq-answer" id="{{ $answerId }}" role="region" aria-labelledby="{{ $questionId }}"><div><p>{{ $faq['answer'] }}</p></div></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta deferred-section" id="contacto">
        <div class="container cta-layout">
            <div class="cta-copy">
                <h2>Descubre si INTEVI puede darte el control que hoy depende de archivos, tiempo y conocimiento disperso.</h2>
                <p>Solicita una demostración, conoce la plataforma y evalúa cómo puede adaptarse al proceso de inventario y resguardos de tu institución.</p>
            </div>
            <div class="cta-action">
                <a class="button button-light" href="#formulario-demo" data-analytics="demo-cta" data-location="final">Solicitar demostración</a>
                <a class="cta-email" href="{{ $demoMailto }}">O escribe a {{ $contactEmail }}</a>
            </div>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#inicio" class="brand">
                    <img src="{{ asset('images/intevi logo.png') }}" alt="INTEVI" class="brand-logo" width="48" height="48" loading="lazy" decoding="async">
                    <span class="brand-text"><span class="brand-name">INTEVI</span><span class="brand-description">Inventario y resguardo institucional</span></span>
                </a>
                <p class="footer-description">Gestión inteligente de inventario, resguardos y trazabilidad de bienes institucionales.</p>
            </div>

            <div><h3 class="footer-heading">Plataforma</h3><ul class="footer-links"><li><a href="#metodo">Control Institucional 5X</a></li><li><a href="#plataforma">Funciones</a></li><li><a href="#implementacion">Implementación</a></li><li><a href="#oferta">Precio</a></li></ul></div>
            <div><h3 class="footer-heading">Contacto</h3><ul class="footer-links"><li><a href="{{ $demoMailto }}">{{ $contactEmail }}</a></li><li><a href="#preguntas">Preguntas frecuentes</a></li><li><a href="#formulario-demo">Solicitar demostración</a></li></ul></div>
            <div><h3 class="footer-heading">Información</h3><ul class="footer-links"><li><a href="{{ route('privacidad') }}">Aviso de privacidad</a></li><li><a href="{{ route('terminos') }}">Términos del servicio</a></li><li><a href="{{ route('condiciones.comerciales') }}">Condiciones comerciales</a></li></ul></div>
        </div>

        <div class="footer-bottom"><p>© {{ now()->year }} INTEVI. Todos los derechos reservados.</p><p>Inventario Tecnológico Institucional</p></div>
    </div>
</footer>

<div class="mobile-sticky-cta"><a class="button button-primary" href="#formulario-demo" data-analytics="demo-cta" data-location="mobile-sticky">Solicitar demostración</a></div>
</body>
</html>
