<div>
    <div class="modal-body">
                        <form wire:submit.prevent="save" >
                        <div class="row g-3">
                            <div class="col-md-12">
                                <p>  Los campos marcados con (*) son obligatorios</p>                                
                            </div>                            
                            <div class="text-center">
                                <span class="text-bold">INFORMACIÓN GENERAL DEL CURSO</span>
                                <hr>
                            </div>
                            <!-- Campos del formulario -->
                            <div class="col-md-12">
                                <label for="name" class="form-label">Nombre del curso*</label>
                                <input type="text" id="name" wire:model.defer="name_of_course" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                @error('name_of_course') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="hours" class="form-label">Duración del curso (horas)*</label>
                                <input type="number" id="hours" wire:model.defer="duration_of_course" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                @error('duration_of_course') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="text-center">
                                <span class="text-bold">TIPO DE CURSO</span>
                                <hr>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                            <input type="radio" id="opcion_generacion" value="programa" 
                                wire:model="type_of_course">
                                <label for="opcion_generacion" class="mt-2 ml-1">Programa</label>
        
                            <input type="radio" id="opcion_curso" value="curso" 
                               wire:model="type_of_course"
                                class="ms-3">
                                <label for="opcion_curso" class="mt-2 ml-1">Curso</label>                                               
                            </div>
                            @error('type_of_course') <span class="text-danger">{{ $message }}</span> @enderror


                            <div class="row">
                                <div class="col d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                        </form>
    </div>
</div>
