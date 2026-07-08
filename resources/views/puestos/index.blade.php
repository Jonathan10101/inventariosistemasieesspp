@extends('adminlte::page')

@section('title', 'Puestos')

@section('content_header')
    {{-- 
    <div class="page-header border-bottom m-3 mt-0">
        <div class="container-fluid py-4">
            <div class="d-flex align-items-center">
                <div class="title-accent me-3"></div>
                <div>
                    <h1 class="page-title mb-1">Puestos</h1>
                </div>
            </div>
        </div>
    </div>
    --}}
@stop

@section('content')
<div class="fade-in">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @livewire('puesto-form')
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/ieesspptitleanimado.css') }}">
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script> console.log("Interfaz IEESSPP profesional cargada ✔️"); </script>
@stop
