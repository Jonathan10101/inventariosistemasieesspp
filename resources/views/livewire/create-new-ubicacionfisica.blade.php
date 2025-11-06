<div wire:ignore.self>
    <div class="modal-body">
        <form wire:submit.prevent="save">
            <div class="row g-3">

                <div class="col-md-12">
                    <p>Los campos marcados con (*) son obligatorios</p>                                
                </div>                            
                
                <hr>

                <!-- Campos del formulario -->
                <div class="col-md-12">
                    <label for="ubicacionfisica" class="form-label">Nombre de la ubicación física*</label>
                    <input type="text" id="ubicacionfisica" wire:model.defer="ubicacionfisica" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('ubicacionfisica') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <!-- Botón Guardar -->
                <div class="col d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>
        </form>
    </div>
</div>
