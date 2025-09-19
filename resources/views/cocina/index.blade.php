@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- Encabezado de la página -->
    <h1 class="text-center">Entradas</h1>
@stop

@section('content')
<div class="container mt-5">
    <!-- Fila para los campos de nombre, código de barras, fecha, cantidad y unidad de medida -->
    <div class="row justify-content-center">

        <div class="col-md-12 d-flex justify-content-end ml-4">
                  <!-- Fecha -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="fecha" placeholder="Fecha">
                        <label for="fecha">Fecha</label>
                    </div>
                </div>
        </div>


        <div class="col-md-12">

            <!-- Fila de formularios (todos en una sola línea) -->
            <div class="row mt-4">
                <!-- Nombre del producto -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nameproduct" placeholder="Nombre del producto">
                        <label for="nameproduct">Nombre del producto</label>
                    </div>
                </div>

                <!-- Código de barras -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="codigobarras" placeholder="Código de barras">
                        <label for="codigobarras">Código de barras</label>
                    </div>
                </div>


                <!-- Cantidad -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="cantidad" placeholder="Cantidad">
                        <label for="cantidad">Cantidad</label>
                    </div>
                </div>

                <!-- Unidad de medida -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" id="unidadMedida" aria-label="Unidad de medida">
                            <option selected>Seleccione unidad</option>
                            <option value="kilogramos">Kilogramos</option>
                            <option value="litros">Litros</option>
                            <option value="pieza">Pieza</option>
                            <option value="bote">Bote</option>
                            <option value="bulto">Bulto</option>
                            <option value="caja">Caja</option>
                            <option value="bidon">Bidón</option>
                            <option value="lata">Lata</option>
                            <option value="paquete">Paquete</option>
                            <option value="botella">Botella</option>
                            <option value="galon">Galón</option>
                            <option value="cubeta">Cubeta</option>
                            <option value="frasco">Frasco</option>
                            <option value="bolsa">Bolsa</option>
                            <option value="costal">Costal</option>
                            <option value="manojo">Manojo</option>
                            <option value="arpilla">Arpilla</option>
                        </select>
                        <label for="unidadMedida">Unidad de medida</label>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@stop

@section('css')
    <!-- Aquí puedes agregar otros estilos si es necesario -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script> console.log("¡Hola! Estoy usando el paquete Laravel-AdminLTE"); </script>
@stop
