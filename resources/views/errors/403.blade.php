@extends('adminlte::page')

@section('title', 'Acceso denegado')

@section('content_header')
@stop

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="card shadow-sm border-0" style="max-width: 600px; width: 100%;">
        <div class="card-body text-center p-5">

            <div class="mb-4">
                <i class="fas fa-shield-alt text-primary" style="font-size: 70px;"></i>
            </div>

            <h1 class="fw-bold text-dark mb-3" style="font-size: 1.9rem;">Acceso Restringido</h1>

            <p class="text-muted fs-5 mb-4">
                Lo sentimos, pero no tienes permisos para acceder a este módulo del sistema.  
                Si crees que esto es un error, comunícate con el administrador.
            </p>

            <a href="{{ route('inventario.index') }}" class="btn btn-primary px-4">
                <i class="fas fa-boxes me-2"></i> Ir al inventario
            </a>

            <div class="mt-4 text-muted small">
                Código de error: <strong>403</strong> &middot;
                {{ now()->format('F j, Y g:i A') }}
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    body {
        background-color: #f8f9fc;
        color: #343a40;
    }

    .card {
        border-radius: 12px;
        background-color: #ffffff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    h1 {
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background-color: #004085;
        border-color: #004085;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #002752;
        border-color: #002752;
    }

    .text-muted small {
        color: #6c757d !important;
    }
</style>
@stop

@section('js')
<script>
    console.log("403 | Access Denied page loaded successfully (Inventario redirect).");
</script>
@stop
