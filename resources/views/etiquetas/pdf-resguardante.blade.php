<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>
        Etiquetas del resguardante
        {{ $resguardante->nombre1 }}
        {{ $resguardante->apellido1 }}
    </title>

    <style>

        @page {
            size: 25mm 50mm;
            margin: 0;
        }

        html,
        body {
            width: 25mm;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /*
        |--------------------------------------------------------------------------
        | PÁGINA INDIVIDUAL
        |--------------------------------------------------------------------------
        */

        .pagina {
            position: relative;

            width: 25mm;
            height: 50mm;

            margin: 0;
            padding: 0;

            overflow: hidden;

            page-break-after: always;
        }

        /*
        |--------------------------------------------------------------------------
        | EVITAR PÁGINA VACÍA AL FINAL
        |--------------------------------------------------------------------------
        */

        .pagina:last-child {
            page-break-after: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENEDOR ROTADO
        |--------------------------------------------------------------------------
        |
        | El diseño interno continúa siendo de 50 x 25 mm.
        | La página física es de 25 x 50 mm.
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

        .titulo {
            width: 100%;

            margin: 1mm 0 0 0;
            padding: 0;

            font-size: 7px;
            line-height: 7px;
            font-weight: bold;

            text-align: center;
        }

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

@foreach ($etiquetas as $item)

    <div class="pagina">

        <div class="rotacion">

            <div class="etiqueta">

                <div class="barcode">
                    {!! $item['etiqueta'] !!}
                </div>

                <div class="titulo">
                    Etiqueta de equipo
                </div>

                <div class="codigo">
                    {{ $item['codigo'] }}
                </div>

            </div>

        </div>

    </div>

@endforeach

</body>

</html>