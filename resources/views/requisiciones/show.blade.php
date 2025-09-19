@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <!-- Encabezado de la página -->
    <h1 class="text-center mt-4">REQUISICIONES</h1>
@stop

@section('content')


<h2>Requisicion {{$nRequisicion}}</h2>


<div class="container mt-4">
		<div class="row">
			<div class="col">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
                            <th>No</th>
                            <th>Unidad ejecutora</th>
							<th>Descripción de los bienes, arrendamientos o servicios</th>
							<th>Cantidad</th>
							<th>Unidad de medida</th>
                            <th>Fecha estimada en que se require</th>
                            <th>Observaciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
                            <td>1</td>
                            <td>3</td>
							<td>AZUCAR SIN MARCA A GRANEL</td>
							<td>4</td>
							<td>BULTO</td>
                            <td>15/11/24</td>
                            <td>BULTO DE 50 KG</td>
						</tr>
						<tr>
                            <td>2</td>
                            <td>3</td>
							<td>FRIJOL PERUANO SIN MARCA A GRANEL</td>
							<td>3</td>
							<td>BULTO</td>
                            <td>15/11/24</td>
                            <td>BULTO DE 25 KG</td>
						</tr>
                        <tr>
                            <td>3</td>
                            <td>3</td>
							<td>PAN BLANCO MARCA BIMBO</td>
							<td>23</td>
							<td>PAQUETE</td>
                            <td>15/11/24</td>
                            <td></td>
						</tr>
                        <tr>
                            <td>4</td>
                            <td>3</td>
							<td>GELATINA EN POLVO MARCA D GARY</td>
							<td>3</td>
							<td>BOTE</td>
                            <td>15/11/24</td>
                            <td></td>
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
