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
        }

        .etiqueta {
            width: 48mm;
            height: 23mm;
            margin: 0;
            padding: 1mm;

            text-align: center;
            overflow: hidden;
        }

        .barcode {
            margin: 0;
            padding: 0;
            height: 10mm;
            overflow: hidden;
        }

        .titulo {
            margin: 0;
            padding: 0;

            font-size: 7px;
            line-height: 8px;
            font-weight: bold;
        }

        .codigo {
            margin: 0;
            padding: 0;

            font-size: 9px;
            line-height: 10px;
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