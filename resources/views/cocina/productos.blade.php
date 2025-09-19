@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center mt-5">Productos</h1>
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">            
            <div class="row mt-4">
                <!-- Aquí se incluye el componente Livewire para la tabla de productos -->
                @livewire('productos-table') 

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <!-- Aquí puedes agregar otros estilos si es necesario -->     
    
@stop

@section('js')

    <script> console.log("¡Hola! Estoy usando el paquete Laravel-AdminLTE"); </script>    
@stop
