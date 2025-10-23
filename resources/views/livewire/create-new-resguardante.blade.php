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
                    <label for="nombre1label" class="form-label">Primer nombre*</label>
                    <input type="text" id="nombre1label" wire:model.defer="nombre1" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('nombre1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="nombre2label" class="form-label">Segundo nombre</label>
                    <input type="text" id="nombre2label" wire:model.defer="nombre2" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('nombre2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="apellido1label" class="form-label">Primer apellido*</label>
                    <input type="text" id="apellido1label" wire:model.defer="apellido1" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('apellido1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="apellido2label" class="form-label">Segundo apellido</label>
                    <input type="text" id="apellido2label" wire:model.defer="apellido2" class="form-control" oninput="this.value = this.value.toUpperCase()">
                    @error('apellido2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <div class="col-md-12 d-flex justify-content-end">
                    @error('nombreCompleto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- Botón Guardar -->
                <div class="col d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>
        </form>
    </div>
</div>
