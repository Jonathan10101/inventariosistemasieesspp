<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 25mm 50mm;
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
            font-family: DejaVu Sans, sans-serif;
        }

        .etiqueta {
            width: 25mm;
            height: 50mm;

            margin: 0;
            padding: 2mm 1.5mm;

            text-align: center;

            overflow: hidden;
        }

        .titulo {
            font-size: 7px;
            font-weight: bold;
            margin: 0 0 2mm 0;
            padding: 0;
            line-height: 1.1;
        }

        .tipo {
            font-size: 6px;
            font-weight: bold;
            margin-bottom: 2mm;
        }

        .barcode {
            width: 100%;
            text-align: center;
            margin-top: 1mm;
        }

        .barcode > div {
            margin: 0 auto;
        }

        .codigo {
            font-size: 8px;
            font-weight: bold;
            margin-top: 2mm;
            letter-spacing: 0.5px;
        }

        .pie {
            font-size: 5px;
            margin-top: 2mm;
        }
    </style>
</head>

<body>

    <div class="etiqueta">

        <div class="titulo">
            INTEVI
        </div>

        <div class="tipo">
            UBICACIÓN FÍSICA
        </div>

        <div class="barcode">
            {!! $etiqueta !!}
        </div>

        <div class="codigo">
            {{ $codigo }}
        </div>

        <div class="pie">
            Inventario Tecnológico Institucional
        </div>

    </div>

</body>

</html>