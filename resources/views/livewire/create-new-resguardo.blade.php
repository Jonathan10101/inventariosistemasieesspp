<div wire:ignore.self>
    <div class="modal-body">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="row g-3">

                <div class="col-md-12">
                    <p>Los campos marcados con (*) son obligatorios</p>                                
                </div>                            

                <div class="text-center">
                    <span class="text-bold">INFORMACIÓN GENERAL DEL RESGUARDO</span>
                    <hr>
                </div>

                <!-- Subir imagen desde PC -->
                <div class="col-md-12" id="imgpc">
                    <label class="form-label">Imagen del producto</label><br>
                    <span>(Sube una imagen desde la computadora)</span>
                    <input type="file" wire:model="imagen" accept=".jpg, .jpeg, .png" class="form-control">
                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                
                <!-- Tomar foto con cámara -->
                {{-- 
                @if (!$imagen)
                    <div class="col-md-12 d-flex justify-content-center mt-3" id="camara">
                        <video id="video" width="300" height="200" autoplay></video>
                        <canvas id="canvas" class="d-none"></canvas>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center mt-3" id="camara">
                        <div class="mt-2">
                            <button type="button" class="btn" style="background-color:#171C63; border-color:#171C63; color:#fff;" onclick="capturar()">Tomar foto</button>
                        </div>
                    </div>
                @endif
                --}}    

                <div class="row">
                    <div class="col">
                            @php
                                $preview = $imagen ? $imagen->temporaryUrl() : ($imagenBase64 ?? null);
                            @endphp

                            @if($preview)
                                <hr>
                                <div class="col">
                                    <p class="text-center">Imagen que se subirá</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <img src="{{ $preview }}"  class="img-thumbnail" width="300" alt="Preview final">
                                </div>
                            @endif
                    </div>
                </div>     
               


                
                <hr>

                <!-- Campos generales -->
                <div class="col-md-12">
                    <label class="form-label">Descripción*</label>
                    <input type="text" wire:model.defer="descripcion" class="form-control text-uppercase">
                    @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Marca*</label>
                    <select wire:model.defer="marca_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Modelo*</label>
                    <input type="text" wire:model.defer="modelo" class="form-control text-uppercase">
                    @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">No. de serie</label>
                    <input type="text" placeholder="Dejar en blanco cuando sea N/A" wire:model.defer="nserie" class="form-control text-uppercase">
                    @error('nserie') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Estado, Área, Ubicación -->
                <div class="col-md-12">
                    <label class="form-label">Estado de uso*</label>
                    <select wire:model.defer="estado_uso_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($estadosdeuso as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_uso_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Área de asignación*</label>
                    <select wire:model.defer="area_de_uso_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($areasdeasignacion as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                    @error('area_de_uso_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="ubicacionfisicaid" class="form-label">Ubicación fisica*</label>
                   <select 
                        wire:model.live="ubicacion_fisicas_id"
                        wire:key="select-ubicacion"
                        class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($ubicacionesifiscas as $ubicacion)
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->descripcion }}</option>
                        @endforeach
                    </select>

                    @error('ubicacion_fisicas_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if($imagenSeleccionada)
                    <div class="mt-3 text-center">
                        <img src="{{ asset('storage/' . $imagenSeleccionada) }}" 
                            alt="Imagen de la ubicación" 
                            class="img-fluid rounded border" 
                            style="max-width: 300px;">
                    </div>
                @endif

                <!-- Resguardante -->
                <div class="col-md-12">
                    <label class="form-label">Resguardante*</label>
                    <select wire:model.defer="resguardante_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($resguardantes as $resguardante)
                            <option value="{{ $resguardante->id }}">
                                {{ $resguardante->apellido1 }} {{ $resguardante->apellido2 }} {{ $resguardante->nombre1 }} {{ $resguardante->nombre2 }}
                            </option>
                        @endforeach
                    </select>
                    @error('resguardante_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Puesto del resguardante*</label>
                    <select wire:model.defer="puesto_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                    @error('puesto_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Subir archivo PDF -->
                <div class="col-md-12 mt-3">
                    <label class="form-label">Archivo PDF del Resguardo*</label>
                    <small class="d-block text-muted mb-1">(Sube el archivo firmado en PDF)</small>
                    <input type="file" wire:model="resguardo_pdf" accept="application/pdf" class="form-control">
                    @error('resguardo_pdf') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Botón Guardar -->
                <div class="col-12 d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color:#171C63; border-color:#171C63; color:#fff;">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>


                
            </div>
        </form>
    </div>
</div>

<script>
let video = document.getElementById('video');
let streamGlobal = null; // guardamos el stream global para poder cerrarlo

function iniciarCamara() {
    // Si ya hay un stream activo, lo cerramos
    if (streamGlobal) {
        streamGlobal.getTracks().forEach(track => track.stop());
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            streamGlobal = stream; // guardamos el stream actual
            video.srcObject = stream;
        })
        .catch(err => console.log("No se puede acceder a la cámara: " + err));
}

function capturar() {
    const canvas = document.getElementById('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    const dataURL = canvas.toDataURL('image/png');

    // Enviar a Livewire
    @this.set('imagenBase64', dataURL);

    // Reiniciar la cámara para poder tomar otra foto
    iniciarCamara();
}

// Iniciar cámara al cargar la página/modal
iniciarCamara();
</script>

