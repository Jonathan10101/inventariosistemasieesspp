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
                    <label for="marca" class="form-label">Primer nombre*</label>
                    <input type="text" id="marca" wire:model.defer="nombre1" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('nombre1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="marca" class="form-label">Segundo nombre</label>
                    <input type="text" id="marca" wire:model.defer="nombre2" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('nombre2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="marca" class="form-label">Primer apellido*</label>
                    <input type="text" id="marca" wire:model.defer="apellido1" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('apellido1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="marca" class="form-label">Segundo apellido</label>
                    <input type="text" id="marca" wire:model.defer="apellido2" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('apellido2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
               
                <div class="col-md-12 d-flex justify-content-end">
                    @error('nombreCompleto') <span class="text-danger">{{ $message }}</span> @enderror
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
