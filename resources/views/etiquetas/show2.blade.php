<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta {{ $codigo }}</title>
    <style>
        .etiqueta {
            border: 1px solid #000;
            padding: 10px;
            display: inline-block;
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="etiqueta">
        {!! $etiqueta !!}
    </div>
</body>
</html>
