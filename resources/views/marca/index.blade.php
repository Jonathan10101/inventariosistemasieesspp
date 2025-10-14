@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
@stop

@section('content')
    
<div class="container mt-5">
    <div class="row justify-content-center">
        @livewire('marca-form')
    </div>
</div>

@stop
