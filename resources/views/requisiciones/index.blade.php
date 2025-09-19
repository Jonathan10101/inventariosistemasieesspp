@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- Encabezado de la página -->
     
<div class="container mt-4">
    <div class="row">
        <div class="col d-flex justify-content-start mb-4">
            <h1 class="text-start mt-4">Requisiciones</h1>

            @can("requisiciones.index")
                <p>ERES Cocina</p>
            @endcan    

           

        </div>
    </div>
</div>

@stop

@section('content')

<!--
@livewire('tablarequisiciones')
-->


<div class="container mt-4">
        <div class="row">
            <div class="col d-flex justify-content-end mb-4">
                <input type="submit" value="Agregar +" class="btn btn-primary">
            </div>
        </div>
		<div class="row">
			<div class="col">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
                            <th>No</th>
                            <th>Semana que abarca</th>
							<th>Fecha de elaboración</th>
                            <th>Acciones</th>
							
						</tr>
					</thead>
					<tbody>
						<tr>
                            <td>4</td>
                            <td>SEMANA DEL 18 AL 22 DE NOVIEMBRE 2024</td>
							<td>13 DE NOVIEMBRE DEL 2024</td>
                            <td class="d-flex justify-content-center
                            ">
							    <input type="submit" value="Ver" class="btn btn-primary w-50 ">
                            </td>
						</tr>
						<tr>
                            <td>3</td>
                            <td>SEMANA DEL 11 AL 15 DE NOVIEMBRE 2024</td>
							<td>6 DE NOVIEMBRE DEL 2024</td>                         
                            <td class="d-flex justify-content-center">  
                                <input type="submit" value="Editar" class="btn btn-dark w-25 d-inline m-1">
                                <input type="submit" value="Ver" class="btn btn-primary  w-25 d-inline m-1">
                            </td>
						</tr>
                        <tr>
                            
                           
						</tr>
                        <tr>
                       

						</tr>
						
					</tbody>
				</table>
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
