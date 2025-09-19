<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacén Cocina | IEESSPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">

    <div class="row">
        <div class="col d-flex justify-content-center mt-4">
            <h1>Entradas</h1>
        </div>    
    </div>
    
    <!-- Fila para los tres campos (nombre, unidad y cantidad) -->
    <div class="row mt-4">
        <!-- Nombre del producto (más grande) -->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="nameproduct" placeholder="Nombre del producto">
                <label for="nameproduct">Nombre del producto</label>
            </div>
        </div>
        
        <!-- Unidad de medida (más pequeño) -->
        <div class="col-md-3">
            <div class="form-floating">        
                <input type="date" class="form-control" id="fecha" placeholder="Fecha">
                <label for="fecha">Fecha</label>
            </div>
        </div>

        <!-- Stock (más pequeño) -->
        <div class="col-md-3">
            <div class="form-floating">
                <input type="number" class="form-control" id="cantidad" placeholder="Cantidad">
                <label for="cantidad">Cantidad</label>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
