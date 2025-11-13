<div >
    <div class="modal-body">
        <form wire:submit.prevent="save">
            <div class="row g-3">

                <div class="col-md-12">
                    <p>Los campos marcados con (*) son obligatorios</p>                                
                </div>                            
                
                <hr>

                <!-- Campo: Nombre de la ubicación física -->
                <div class="col-md-12">
                    <label for="ubicacionfisica" class="form-label">Nombre de la ubicación física*</label>
                    <input type="text" id="ubicacionfisica" wire:model.defer="ubicacionfisica" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('ubicacionfisica') 
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Campo: Imagen -->
                <div class="col-md-12">
                    <label for="imagenid" class="form-label">Imagen (opcional)</label>
                    <input type="file" id="imagenid" wire:model="imagen" class="form-control" accept="image/png, image/jpeg, image/jpg">
                    @error('imagen') 
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror

                    <!-- Vista previa -->
                 @if ($imagen)
                    <div class="mt-3 text-center">
                        @if (is_object($imagen))
                            {{-- Imagen nueva cargada (aún no guardada) --}}
                            <img src="{{ $imagen->temporaryUrl() }}" class="img-fluid rounded shadow" width="150" alt="Vista previa">
                        @else
                            {{-- Imagen ya guardada en storage --}}
                            <img src="{{ asset('storage/' . $imagen) }}" class="img-fluid rounded shadow" width="150" alt="Vista previa">
                        @endif
                    </div>
                @endif

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
