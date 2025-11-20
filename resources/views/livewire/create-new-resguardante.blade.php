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
                    <input type="text" id="nombre1label"  wire:model.defer="nombre1" class="form-control"  
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">

                    @error('nombre1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="nombre2label" class="form-label">Segundo nombre</label>
                    <input type="text" id="nombre2label" wire:model.defer="nombre2" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('nombre2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="apellido1label" class="form-label">Primer apellido*</label>
                    <input type="text" id="apellido1label" wire:model.defer="apellido1" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('apellido1') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="apellido2label" class="form-label">Segundo apellido</label>
                    <input type="text" id="apellido2label" wire:model.defer="apellido2" class="form-control"
                        onkeydown="if(event.key === ' ') event.preventDefault()"
                        oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')">
                    @error('apellido2') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="emaillabel" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="text"
                            id="emaillabel"
                            wire:model.defer="email"
                            class="form-control"
                            oninput="this.value = this.value.toLowerCase().replace(/\s/g, '')">
                        <span class="input-group-text">@ieesspp.com</span>
                    </div>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label for="passwordlabel" class="form-label">Password</label>

                    <div class="input-group">
                        <input type="password"
                            id="passwordlabel"
                            wire:model.defer="password"
                            class="form-control">

                        <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword()">
                            👁️‍🗨️
                        </span>
                    </div>

                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
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

<script>
function togglePassword() {
    let input = document.getElementById('passwordlabel');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
