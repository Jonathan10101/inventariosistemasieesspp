@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    @error('nombre1')
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @enderror
    @error('apellido1')
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @enderror
    <!-- Encabezado de la página -->
     <div class="row">
        <div class=""></div>
        <div class="col">
            <h1 class="text-center mt-1 ml-5">Resguardante</h1>
        </div>
        <div class=""></div>
    </div>        
@stop

@section('content')
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col"></div>
        <div class="col-md-6">                        
            <form action="{{ route('resguardante.store') }}" method="POST">
                @csrf
                <label for="namemarcalabel">Escribe el nombre de la persona y da click en el botón Registrar</label>
                
    <div class="row">
        <div class="col-md-12 mt-3">
            <input type="text" name="nombre1" class="form-control" placeholder="Primer nombre" value="{{ old('nombre1') }}">
        </div>
        <div class="col-md-12 mt-3">
            <input type="text" name="nombre2" class="form-control" placeholder="Segundo nombre (opcional)" value="{{ old('nombre2') }}">
        </div>
        <div class="col-md-12 mt-3">
            <input type="text" name="apellido1" class="form-control" placeholder="Primer apellido" value="{{ old('apellido1') }}">
        </div>
        <div class="col-md-12 mt-3">
            <input type="text" name="apellido2" class="form-control" placeholder="Segundo apellido (opcional)" value="{{ old('apellido2') }}">
        </div>
    </div>
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


