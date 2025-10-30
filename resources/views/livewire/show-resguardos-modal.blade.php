<div>
    <div class="row">
        <div class="col m-3">
                @forelse ($historiales as $historial)
                    <p><span class="text-bold">Fecha de asignación:</span> {{$historial->fecha_asignacion}}</p>
                    <p><span class="text-bold">Resguardante:</span> {{$historial->resguardante->nombre1}} {{$historial->resguardante->nombre2}} {{$historial->resguardante->apellido1}} {{$historial->resguardante->apellido2}}</p>
                    <a href="{{ Storage::url($historial->resguardo_pdf) }}" class="btn btn-primary mb-4" target="_blank">
                        <i class="fas fa-download"></i> Descargar Resguardo                  
                    </a>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">No se encontro historial.</td>
                    </tr>
                @endforelse
        </div>
    </div>

</div>
