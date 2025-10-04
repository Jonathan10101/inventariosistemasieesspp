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
                    <label class="form-label">Imagen del producto*</label><br>
                    <span>(Sube una imagen desde la computadora o toma una foto)</span>
                    <input type="file" wire:model="imagen" accept="image/*" class="form-control">
                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Tomar foto con cámara -->
                @if (!$imagen) {{-- Solo mostrar si NO hay imagen subida desde PC --}}
                    <div class="col-md-12 mt-3" id="camara">
                        <video id="video" width="300" height="200" autoplay></video>
                        <canvas id="canvas" class="d-none"></canvas>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" onclick="capturar()">Tomar foto</button>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                            @php
                                $preview = $imagen ? $imagen->temporaryUrl() : ($imagenBase64 ?? null);
                            @endphp

                            @if($preview)
                                <hr>
                                <div class="col">
                                    <p class="fw-ligth text-center">Imagen que se subirá</p>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <img src="{{ $preview }}" class="img-thumbnail" width="300" alt="Preview final">
                                </div>
                            @endif
                    </div>
                </div>     
               


                
                <hr>

                <!-- Campos del formulario -->
                <div class="col-md-12">
                    <label for="descripcionid" class="form-label">Descripción*</label>
                    <input type="text" id="descripcionid" wire:model.defer="descripcion" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="marcaid" class="form-label">Marca*</label>
                    <select id="marcaid" wire:model.defer="marca_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="modeloid" class="form-label">Modelo*</label>
                    <input type="text" id="modeloid" wire:model.defer="modelo" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('modelo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="numerodeserieid" class="form-label">No. de serie*</label>
                    <input type="text" id="numerodeserieid" wire:model.defer="nserie" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('nserie') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="estadodeusoid" class="form-label">Estado de uso*</label>
                    <select id="estadodeusoid" wire:model.defer="estado_uso_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($estadosdeuso as $estadodeuso)
                            <option value="{{ $estadodeuso->id }}">{{ $estadodeuso->estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_uso_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="areadeasignacionid" class="form-label">Area de asignación*</label>
                    <select id="areadeasignacionid" wire:model.defer="area_de_uso_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($areasdeasignacion as $areadeasignacion)
                            <option value="{{ $areadeasignacion->id }}">{{ $areadeasignacion->nombre }}</option>
                        @endforeach
                    </select>
                    @error('area_de_uso_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="ubicacionfisicaid" class="form-label">Ubicación fisica*</label>
                    <select id="ubicacionfisicaid" wire:model.defer="ubicacion_fisicas_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($ubicacionesifiscas as $ubicacionifisca)
                            <option value="{{ $ubicacionifisca->id }}">{{ $ubicacionifisca->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('ubicacion_fisicas_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="resguardanteid" class="form-label">Resguardante*</label>
                    <select id="resguardanteid" wire:model.defer="resguardante_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($resguardantes as $resguardante)
                            <option value="{{ $resguardante->id }}">{{ $resguardante->nombre1 }} {{ $resguardante->nombre2 }} {{ $resguardante->apellido1 }} {{ $resguardante->apellido2 }}</option>
                        @endforeach
                    </select>
                    @error('resguardante_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="puestodelresguardanteid" class="form-label">Puesto del resguardante*</label>
                    <select id="puestodelresguardanteid" wire:model.defer="puesto_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                    @error('puesto_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <!-- Subir archivo PDF del resguardo -->
                <div class="col-md-12 mt-3">
                    <label class="form-label">Archivo PDF del Resguardo*</label><br>
                    <span>(Sube el archivo firmado en PDF)</span>
                    <input type="file" wire:model="resguardo_pdf" accept="application/pdf" class="form-control">
                    @error('resguardo_pdf') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Botón Guardar -->
                <div class="col d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
