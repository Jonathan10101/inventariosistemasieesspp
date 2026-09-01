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

        /*
        |--------------------------------------------------------------------------
        | ETIQUETA
        |--------------------------------------------------------------------------
        |
        | 48mm + 1mm izquierda + 1mm derecha = 50mm
        |
        */

        .etiqueta {
            width: 48mm;

            margin-left: 1mm;
            margin-right: 1mm;

            /* 5mm de espacio superior */
            padding-top: 5mm;

            text-align: center;
            overflow: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | CÓDIGO DE BARRAS
        |--------------------------------------------------------------------------
        */

        .barcode {
            width: 48mm;

            margin: 0;
            padding: 0;

            text-align: center;
        }

        /*
         * DNS1D genera un DIV interno.
         * Esto obliga a centrar ese DIV.
         */
        .barcode > div {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /*
        |--------------------------------------------------------------------------
        | TEXTO
        |--------------------------------------------------------------------------
        */

        .titulo {
            width: 100%;

            margin: 1mm 0 0 0;
            padding: 0;

            text-align: center;

            font-size: 7px;
            line-height: 7px;
            font-weight: bold;
        }

        .codigo {
            width: 100%;

            margin: 1mm 0 0 0;
            padding: 0;

            text-align: center;

            font-size: 10px;
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