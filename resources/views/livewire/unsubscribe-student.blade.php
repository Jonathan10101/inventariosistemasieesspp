<div>
        <form wire:submit.prevent="save">
            <div class="row g-3 mt-3">                            
                <div class="col-1"></div>
                <div class="col-md-10">
                    <label for="fechaBajaLabel" class="form-label">Fecha de baja</label>
                    <input type="date" 
                    class="form-control"  
                    wire:model.defer="fecha_baja_mount" 
                    id="fechaBajaLabel" 
                    require
                    @disabled(!empty($fecha_baja_mount))>
                    @error('fechaBaja') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-1"></div>
            </div>
            <div class="row g-3 mt-3">                            
                <div class="col-1"></div>
                <div class="col-md-10">
                    <label for="motivoBajaLabel" class="form-label">Motivo de baja</label>
                    <textarea name="motivoDeBaja" 
                    id="motivoBajaLabel" 
                    class="form-control" 
                    wire:model.defer="motivo_baja_mount" 
                    style="overflow:auto;resize:none"
                    rows="10" 
                    oninput="this.value = this.value.toUpperCase()" 
                    require
                    @disabled(!empty($motivo_baja_mount)) 
                    >
                    
                    </textarea>                
                    @error('motivoBaja') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-1"></div>
            </div>
               
                    
                

            <div class="row">
                <div class="col d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-primary mr-4 mb-3">Guardar</button>
                </div>
            </div>
        </form>
</div>
