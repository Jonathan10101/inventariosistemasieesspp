@extends('central.legal-layout')

@section('title', 'Aviso de privacidad')

@section('content')
    <span class="eyebrow">Protección de datos</span>
    <h1>Aviso de privacidad integral</h1>

    <div class="legal-alert">
        Antes de publicarlo, reemplaza el domicilio pendiente y solicita una revisión jurídica. Este archivo es un borrador operativo, no un dictamen legal.
    </div>

    <h2>1. Responsable</h2>
    <p>
        INTEVI, operado por Jonathan Bedolla, es responsable del tratamiento de los datos personales recabados mediante este sitio. Correo de contacto:
        <a href="mailto:contacto@intevi.app">contacto@intevi.app</a>.
    </p>
    <p><strong>Domicilio para oír y recibir notificaciones:</strong> [AGREGA AQUÍ EL DOMICILIO COMPLETO DEL RESPONSABLE].</p>

    <h2>2. Datos que se recaban</h2>
    <p>Por medio del formulario de demostración pueden recabarse nombre, institución u organización, correo electrónico, cargo, teléfono y datos generales relacionados con la necesidad de inventario o resguardo.</p>
    <p>No se solicitan datos personales sensibles mediante el formulario comercial de la landing.</p>

    <h2>3. Finalidades</h2>
    <ul>
        <li>Atender y dar seguimiento a solicitudes de demostración.</li>
        <li>Preparar propuestas, alcances y cotizaciones.</li>
        <li>Contactar a la persona solicitante para resolver dudas comerciales o técnicas.</li>
        <li>Conservar evidencia de la comunicación relacionada con una posible contratación.</li>
    </ul>

    <h2>4. Encargados y servicios de terceros</h2>
    <p>Para operar el sitio pueden utilizarse proveedores de formularios, correo, analítica, alojamiento y medición. Estos proveedores tratarán información únicamente conforme a las finalidades del servicio contratado y a sus condiciones aplicables.</p>

    <h2>5. Limitación del uso y derechos ARCO</h2>
    <p>La persona titular puede solicitar acceso, rectificación, cancelación u oposición, así como limitar el uso o revocar su consentimiento, escribiendo a <a href="mailto:contacto@intevi.app">contacto@intevi.app</a>. La solicitud deberá permitir identificar a la persona titular y describir claramente el derecho que desea ejercer.</p>

    <h2>6. Conservación</h2>
    <p>Los datos se conservarán durante el tiempo necesario para atender la solicitud, preparar una propuesta, cumplir obligaciones aplicables y resolver posibles aclaraciones. Después se eliminarán o bloquearán conforme a los plazos que correspondan.</p>

    <h2>7. Cambios</h2>
    <p>Las modificaciones a este aviso se publicarán en esta misma dirección. Fecha de última actualización: {{ now()->format('d/m/Y') }}.</p>
@endsection
