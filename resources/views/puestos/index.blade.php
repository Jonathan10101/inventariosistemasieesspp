@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @error('nombre')
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @enderror
    <!-- Encabezado de la página -->
     <div class="row">
        <div class=""></div>
        <div class="col">
            <h1 class="text-center mt-1">Puestos</h1>
        </div>
        <div class=""></div>
    </div>        
@stop

@section('content')
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col"></div>
        <div class="col-md-6">                        
            <form action="{{ route('puestos.store') }}" method="POST">
                @csrf
                <label for="descripcionlabel">Escribe el nombre del puesto y da click en el botón Registrar</label>
                <input type="text" name="nombre" id="descripcionlabel" autofocus class="form-control">
                <div class="col d-flex justify-content-end">
                    <input type="submit" value="Registrar" class="btn btn-primary mt-4">
                </div>
            </form>
        </div>
        <div class="col"></div>
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


