<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Etiqueta {{ $codigo }}</title>

    <style>
        @page {
            size: 50mm 25mm;
            margin: 0;
        }

        html,
        body {
            width: 50mm;
            height: 25mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .etiqueta {
            width: 25mm;
            height: 50mm;
            position: absolute;
            top: 25mm;
            left: 0;
            transform: rotate(-90deg);
            transform-origin: top left;
            text-align: center;
            overflow: hidden;
        }

        .barcode {
            width: 100%;
            height: auto;
            margin: 0 0 1mm 0;
            padding: 0;
            overflow: visible;
            text-align: center;
        }

        .titulo {
            margin: 0;
            padding: 0;

            font-size: 7px;
            line-height: 7px;
            font-weight: bold;
        }

        .codigo {
            margin: 0.5mm 0 0 0;
            padding: 0;

            font-size: 9px;
            line-height: 9px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="etiqueta">

    <div class="barcode">
        {!! $etiqueta !!}
    </div>

    <div class="titulo">
        Etiqueta de equipo
    </div>

    <div class="codigo">
        {{ $codigo }}
    </div>

</div>

</body>
</html>