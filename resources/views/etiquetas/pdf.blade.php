<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Etiqueta {{ $codigo }}</title>

    <style>

        @page {
            size: 25mm 50mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 25mm;
            height: 50mm;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .etiqueta {
            width: 25mm;
            height: 50mm;

            padding: 2mm;

            text-align: center;

            overflow: hidden;
        }

        .barcode {
            width: 100%;

            text-align: center;

            margin-top: 4mm;
            margin-bottom: 3mm;
        }

        .titulo {
            font-size: 7px;
            font-weight: bold;

            margin-top: 2mm;
        }

        .codigo {
            font-size: 9px;
            font-weight: bold;

            margin-top: 2mm;
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