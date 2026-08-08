@extends('adminlte::page')

@section('title', 'Periodo de prueba finalizado')

@section('content_header')
    <div class="container-fluid">
        <h1 class="m-0 font-weight-bold">
            Periodo de prueba finalizado
        </h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9">
                <div class="card shadow-sm border-0">
                    <div
                        class="card-header text-white"
                        style="background-color: #171C63;"
                    >
                        <h3 class="card-title font-weight-bold mb-0">
                            Continúe utilizando INTEVI
                        </h3>
                    </div>

                    <div class="card-body text-center px-4 py-5">
                        <div
                            class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
                            style="
                                width: 82px;
                                height: 82px;
                                background: rgba(23, 28, 99, 0.10);
                                color: #171C63;
                                font-size: 36px;
                            "
                        >
                            <i class="fas fa-clock"></i>
                        </div>

                        <h2
                            class="font-weight-bold mb-3"
                            style="color: #171C63;"
                        >
                            Sus 7 días de prueba han terminado
                        </h2>

                        <p class="text-muted lead mb-4">
                            Su información, inventarios, resguardos,
                            documentos y configuraciones permanecen
                            almacenados de forma segura.
                        </p>

                        <p class="mb-4">
                            Active su licencia para recuperar inmediatamente
                            el acceso completo a la plataforma.
                        </p>

                        <a
                            href="https://intevi.app/"
                            class="btn btn-lg px-5 text-white"
                            style="background-color: #171C63;"
                        >
                            <i class="fas fa-unlock-alt mr-2"></i>
                            Solicitar activación
                        </a>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-link text-muted"
                                >
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop