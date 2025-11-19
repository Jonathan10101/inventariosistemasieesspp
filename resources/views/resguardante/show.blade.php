@extends('adminlte::page')

@section('title', 'Resguardos de '.$resguardante->nombre1." ".$resguardante->nombre2." ".$resguardante->apellido1." ".$resguardante->apellido2)

@section('content_header')
    <div class="page-header border-bottom m-3 mt-0">
        <div class="container-fluid py-4">
            <div class="d-flex align-items-center">
                <div class="title-accent me-3"></div>
                <div>
                    <h1 class="text-left mt-1">RESGUARDOS DE :
                        <span class="text-primary">
                            {{ $resguardante->nombre1 }} {{ $resguardante->nombre2 }}
                            {{ $resguardante->apellido1 }} {{ $resguardante->apellido2 }}
                        </span>
                    </h1>
                </div>
            </div>
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
                            <a href="{{ route('inventario.index', ['search' => $resguardo->id]) }}" class="btn btn-dark btn-sm" title="Ver resguardo">
                                <i class="fas fa-eye"></i>
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

    <div class="row">
        <div class="col">
             <div class="d-flex justify-content-end mt-3">
            {{ $historiales->links() }}
        </div>
        </div>
    </div>

</div>
@stop

@section('css')    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/ieesspptitleanimado.css') }}">
<link rel="stylesheet" href="{{ asset('css/ieessppformtable.css') }}">
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script> console.log("Vista de historial de resguardos cargada correctamente"); </script>
@stop
