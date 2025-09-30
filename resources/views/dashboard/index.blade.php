@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- Encabezado de la página -->
    
            
            {{--
            <livewire:student-stats />
            --}}
    
@stop

@section('content')
<div class="container mt-5">
    

    {{--
    @livewire('formulario')
    --}}

<div class="mt-8">
    {{--
    @livewire('comments')
    --}}
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
