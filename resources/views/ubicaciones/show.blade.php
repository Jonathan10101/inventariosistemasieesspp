@extends('adminlte::page')

@section('title', 'Resguardos por ubicación')

@section('content_header')
<div class="mb-3 border-bottom pb-2">
    <h1 class="fw-semibold text-dark text-uppercase mb-1" style="color:#171C63 !important;">
        Resguardos en {{ $ubicacionFisica->descripcion }}
    </h1>
    <p class="text-secondary mb-0 fs-6">Historial de equipos asignados a esta ubicación</p>
</div>
@stop

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="text-center mb-4">
            @if($ubicacionFisica->imagen)
                <img src="{{ asset('storage/' . $ubicacionFisica->imagen) }}" 
                     alt="Imagen de ubicación"
                     class="rounded-1 border"
                     style="max-width: 280px;">
            @else
                <p class="text-muted fst-italic">Sin imagen de ubicación</p>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table align-middle text-center">
                <thead style="background-color: #171C63; color: #fff;">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
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
                        @php $resguardo = $historial->resguardo; @endphp
                        <tr>
                            <td>{{ $historial->id }}</td>
                            <td>
                                @if($historial->imagen_evidencia)
                                    <a href="{{ asset('storage/' . $historial->imagen_evidencia) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $historial->imagen_evidencia) }}" 
                                             alt="Evidencia"
                                             class="rounded-1 border"
                                             width="70">
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $resguardo->descripcion ?? 'Sin descripción' }}</td>
                            <td>{{ $resguardo->marca->nombre ?? 'Sin marca' }}</td>
                            <td>{{ $resguardo->modelo ?? 'Sin modelo' }}</td>
                            <td>{{ $resguardo->nserie ?? 'N/A' }}</td>
                            <td>{{ $resguardo->nresguardo ?? 'N/A' }}</td>
                            <td>{{ $historial->fecha_asignacion_formatted ?? 'No registrada' }}</td>
                            <td>
                                <a href="{{ route('inventario.index', ['search' => $resguardo->id]) }}" 
                                   class="btn btn-sm text-white"
                                   style="background-color:#171C63;">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">
                                <i class="fas fa-info-circle me-1"></i> No hay resguardos asignados en esta ubicación.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $historiales->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    body {
        background-color: #f4f6fa !important;
        font-family: 'Inter', 'Segoe UI', sans-serif !important;
    }
    .card {
        border-radius: 4px !important;
    }
    .btn {
        border-radius: 4px !important;
        transition: all 0.2s ease-in-out;
    }
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    table {
        border-radius: 4px;
    }
</style>
@stop
