<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: 25mm 50mm;
            margin: 0;
        }

        html,
        body {
            width: 25mm;
            height: 50mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .etiqueta {
            width: 23mm;

            margin-left: 1mm;
            margin-right: 1mm;

            padding-top: 5mm;

            text-align: center;
        }

        .barcode {
            width: 100%;
            text-align: center;
        }

        .barcode > div {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .titulo {
            margin-top: 1mm;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
        }

        .codigo {
            margin-top: 0.5mm;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
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