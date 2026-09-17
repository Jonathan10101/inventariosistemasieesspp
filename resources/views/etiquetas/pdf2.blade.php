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
        | CONTENEDOR ROTADO
        |--------------------------------------------------------------------------
        |
        | La página física es 25 x 50 mm.
        | El diseño interno es 50 x 25 mm.
        |
        | Se gira 90 grados para que la impresora
        | detecte correctamente el PDF como vertical.
        |
        */

        .rotacion {
            position: absolute;

            width: 50mm;
            height: 25mm;

            top: 0;
            left: 25mm;

            transform-origin: top left;
            transform: rotate(90deg);
        }

        /*
        |--------------------------------------------------------------------------
        | ETIQUETA
        |--------------------------------------------------------------------------
        */

        .etiqueta {
            width: 48mm;

            margin-left: 1mm;
            margin-right: 1mm;

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
            width: 100%;

            margin: 0;
            padding: 0;

            text-align: center;
        }

        .barcode > div {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /*
        |--------------------------------------------------------------------------
        | TÍTULO
        |--------------------------------------------------------------------------
        */

        .titulo {
            width: 100%;

            margin: 1mm 0 0 0;
            padding: 0;

            font-size: 7px;
            line-height: 7px;
            font-weight: bold;

            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | CÓDIGO
        |--------------------------------------------------------------------------
        */

        .codigo {
            width: 100%;

            margin: 0.5mm 0 0 0;
            padding: 0;

            font-size: 10px;
            line-height: 10px;
            font-weight: bold;

            text-align: center;
        }

    </style>

</head>

<body>

<div class="rotacion">

    <div class="etiqueta">

        <div class="barcode">
            {!! $etiqueta !!}
        </div>

        <div class="titulo">
            Etiqueta de ubicación
        </div>

        <div class="codigo">
            {{ $codigo }}
        </div>

    </div>

</div>

</body>

</html>