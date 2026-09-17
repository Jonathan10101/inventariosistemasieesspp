<img src="vendor/adminlte/dist/img/ieesspptransparente.png" alt="Foto">

<table>
    <thead>
        <tr >
            <th style="color:#171C63;font-weight: bold; width:450px;background-color:gray;text-align:center;font-size:14px;">Descripción</th>
            <th style="color:#171C63;font-weight: bold; width:150px;background-color:gray;text-align:center;font-size:14px;">Marca</th>
            <th style="color:#171C63;font-weight: bold; width:400px;background-color:gray;text-align:center;font-size:14px;">Modelo</th>
            <th style="color:#171C63;font-weight: bold; width:225px;background-color:gray;text-align:center;font-size:14px;">Núm. de serie</th>
            <th style="color:#171C63;font-weight: bold; width:150px;background-color:gray;text-align:center;font-size:14px;">Núm. de inventario</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resguardos as $resguardo)
            <tr>
                <td>{{$resguardo->descripcion}}</td>
                <td style="text-align:center;">{{$resguardo->marca->nombre}}</td>
                <td>{{$resguardo->modelo}}</td>
                <td style="text-align:center;">{{$resguardo->nserie}}</td>
                <td style="text-align:center;">{{$resguardo->id}}</td>
            </tr>
        @endforeach
    </tbody>
</table>