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

        .barcode {
            width: 100%;
            margin: 0;
            padding: 0;
            text-align: center;
            overflow: visible;
        }

        .etiqueta {
            width: 48mm;
            height: 18mm;

            margin-left: 1mm;
            margin-right: 1mm;

            /* 0.5 cm desde arriba */
            padding-top: 5mm;

            text-align: center;
            overflow: hidden;
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