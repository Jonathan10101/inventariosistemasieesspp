<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta {{ $codigo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Texto más pequeño */
        }
        .etiqueta {
            border: 1px solid #000;
            padding: 5px;
            display: inline-block;
            text-align: center;
            margin: 5px;
            width: 150px;   /* 👈 ancho reducido */
            height: auto;
        }
        .codigo-texto {
            font-size: 8px; /* 👈 número pequeño debajo */
            margin-top: 3px;
        }
        img, svg {
            max-width: 100%;
        }
    </style>
</head>
<body>
    
<div class="etiqueta" style="border:1px solid #000; padding:10px; text-align:center; width:160px; margin:10px;">
    {!! $etiqueta !!}
</div>

</body>
</html>
