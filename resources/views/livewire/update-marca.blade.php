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
                    <label for="marca" class="form-label">Nombre de la marca*</label>
                    <input type="text" id="marca" wire:model.defer="marca" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <!-- Botón Guardar -->
                <div class="col d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>
        </form>
    </div>
</div>
