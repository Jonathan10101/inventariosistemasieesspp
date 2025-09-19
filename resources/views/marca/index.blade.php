@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- Encabezado de la página -->
     <div class="row">
        <div class=""></div>
        <div class="col">
            <h1 class="text-start mt-5 ml-5">Marcas</h1>
        </div>
        <div class=""></div>
    </div>    
@stop

@section('content')
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">            
            
                <!-- Aquí se incluye el componente Livewire para la tabla de productos -->
                <form action="">                    
                    <input type="text" class="form-control">
                    <input type="submit" value="Registrar"  class="btn btn-primary mt-4">
                </form>

            
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


