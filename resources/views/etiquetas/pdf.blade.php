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

            background: #fff;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENEDOR PRINCIPAL
        |--------------------------------------------------------------------------
        */

        .etiqueta {

            width: 22mm;
            height: 47mm;

            /*
             * Margen físico de seguridad.
             * Evita que el contenido quede pegado
             * al borde de la etiqueta.
             */
            margin: 1.5mm;

            padding:
                3mm
                1.2mm
                2mm
                1.2mm;

            border: 0.25mm solid #222;

            text-align: center;

            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | ENCABEZADO
        |--------------------------------------------------------------------------
        */

        .tipo {

            font-size: 5px;

            font-weight: bold;

            letter-spacing: 0.5px;

            text-transform: uppercase;

            margin: 0;

            padding: 0;
        }


        .descripcion {

            font-size: 4px;

            color: #555;

            margin-top: 0.7mm;

            margin-bottom: 2mm;
        }


        /*
        |--------------------------------------------------------------------------
        | SEPARADOR
        |--------------------------------------------------------------------------
        */

        .separador {

            width: 14mm;

            margin:
                0
                auto
                3mm
                auto;

            border-top:
                0.2mm
                solid
                #333;
        }


        /*
        |--------------------------------------------------------------------------
        | CÓDIGO DE BARRAS
        |--------------------------------------------------------------------------
        */

        .barcode {

            width: 100%;

            margin:
                0
                auto
                2mm
                auto;

            padding: 0;

            text-align: center;
        }


        .barcode > div {

            margin-left: auto !important;
            margin-right: auto !important;
        }


        /*
        |--------------------------------------------------------------------------
        | NÚMERO
        |--------------------------------------------------------------------------
        */

        .numero-label {

            margin-top: 1mm;

            font-size: 4px;

            letter-spacing: 0.4px;

            text-transform: uppercase;

            color: #555;
        }


        .numero {

            margin-top: 0.7mm;

            font-size: 11px;

            line-height: 12px;

            font-weight: bold;

            letter-spacing: 0.4px;
        }


        /*
        |--------------------------------------------------------------------------
        | PIE
        |--------------------------------------------------------------------------
        */

        .pie {

            width: 100%;

            margin-top: 3mm;

            padding-top: 1.5mm;

            border-top:
                0.15mm
                solid
                #aaa;

            font-size: 4px;

            letter-spacing: 0.2px;

            color: #555;

            text-transform: uppercase;
        }

    </style>

</head>


<body>


<div class="etiqueta">


    <div class="tipo">

        ACTIVO INSTITUCIONAL

    </div>


    <div class="descripcion">

        Control de inventario

    </div>


    <div class="separador"></div>


    <div class="barcode">

        {!! $etiqueta !!}

    </div>


    <div class="numero-label">

        NÚMERO DE INVENTARIO

    </div>


    <div class="numero">

        {{ ltrim($codigo, '0') }}

    </div>


    <div class="pie">

        BIEN INVENTARIADO

    </div>


</div>


</body>

</html>