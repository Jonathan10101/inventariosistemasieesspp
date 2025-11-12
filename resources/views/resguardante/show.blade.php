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
        <div class="col">
            <h1 class="text-left mt-1">
                RESGUARDOS DE :
                <span class="text-primary">
                    {{ $resguardante->nombre1 }} {{ $resguardante->nombre2 }}
                    {{ $resguardante->apellido1 }} {{ $resguardante->apellido2 }}
                </span>
            </h1>
        </div>
    </div>        
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>No. Serie</th>
                    <th>No. Inventario</th>
                    <th>Fecha Asignación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historiales as $historial)
                    @php
                        $resguardo = $historial->resguardo;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $historial->id }}</td>
                        <td>{{ $resguardo->descripcion ?? 'Sin descripción' }}</td>
                        <td>{{ $resguardo->marca->nombre ?? 'Sin marca' }}</td>
                        <td>{{ $resguardo->modelo ?? 'Sin modelo' }}</td>
                        <td>{{ $resguardo->nserie ?? 'N/A' }}</td>
                        <td>{{ $resguardo->nresguardo ?? 'N/A' }}</td>
                        <td>{{ $historial->fecha_asignacion_formatted ?? 'No registrada' }}</td>
                        <td class="text-center">
                            <a href="{{ route('inventario.index', ['search' => $resguardo->id]) }}" class="btn btn-dark btn-sm">
                                <i class="fas fa-eye"></i> Ver resguardo
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No tiene resguardos asignados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script> console.log("Vista de historial de resguardos cargada correctamente"); </script>
@stop
