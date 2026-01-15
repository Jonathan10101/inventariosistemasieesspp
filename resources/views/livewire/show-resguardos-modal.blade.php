<div>
    <div class="row">
        <div class="col m-3">
            @forelse ($historiales as $historial)
                <hr>
           @if ($historial->imagen_evidencia)
                <a href="{{ asset('storage/' . $historial->imagen_evidencia) }}" target="_blank">
                    <img src="{{ asset('storage/' . $historial->imagen_evidencia) }}"
                        alt="Imagen del producto"
                        class="img-thumbnail"
                        width="100">
                </a>
            @else
                <span class="text-muted mt-1">Sin imagen</span>
            @endif

                <p><span class="text-bold">Estado de uso:</span> {{$historial->estadouso->estado}}</p>
                <p><span class="text-bold">Cantidad:</span> {{$historial->resguardo->cantidad}}</p>
                <p><span class="text-bold">Ubicación fisica:</span> {{$historial->ubicacionFisica->descripcion}}</p>
                <p><span class="text-bold">Fecha de asignación:</span> {{$historial->fecha_asignacion}}</p>
                <!--
                <p><span class="text-bold">Fecha de modificación:</span> {{$historial->resguardo->updated_at ?? 'N/A'}}</p>
                -->
                <p><span class="text-bold">Fecha de liberación:</span> {{ $historial->fecha_liberacion ?? 'N/A' }}</p>
                
                <p><span class="text-bold">Resguardante:</span> 
                    {{$historial->resguardante->nombre1}} {{$historial->resguardante->nombre2}} 
                    {{$historial->resguardante->apellido1}} {{$historial->resguardante->apellido2}}
                </p>
               
            @php
                $user = Auth::user();
            @endphp

            @if ($user->hasRole('Administrador') || $user->hasRole('Delegacion') || $user->hasRole('Subdirector') ||  $user->hasRole('Director') || $user->id == $historial->resguardante_id)
                <a href="{{ Storage::url($historial->resguardo_pdf) }}" 
                class="btn btn-primary mb-4"
                style="background-color:#171C63; border-color:#171C63; color:#fff;" 
                target="_blank">
                    <i class="fas fa-download"></i> Descargar Resguardo
                </a>
            @endif

            {{--
            <div class="row">
                <div class="col">
                    <label for="remplazarresguardo" class="form-label">Reemplazar PDF Resguardo</label>

                    <input
                        type="file"
                        id="remplazarresguardo"
                        class="form-control"
                        wire:model="pdfNuevo"
                        accept="application/pdf"
                    >

                    @error('pdfNuevo') <small class="text-danger">{{ $message }}</small> @enderror

                    <div class="mt-2">
                        <button class="btn"  style="background-color:#171C63; border-color:#171C63; color:#fff;"  wire:click="reemplazarPdf" wire:loading.attr="disabled">
                            Aceptar
                        </button>

                    </div>
                </div>
            </div>
            --}}

            @empty
                <div class="text-center">No se encontró historial.</div>
            @endforelse

            <!-- 👇 Enlaces de paginación -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $historiales->links() }}
            </div>
        </div>
    </div>
</div>
