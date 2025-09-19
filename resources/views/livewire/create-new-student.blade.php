<div>
    <div class="modal-body">
                    <form wire:submit.prevent="save" >
                        <div class="row g-3">
                            <div class="col-md-12">
                                <p>  Los campos marcados con (*) son obligatorios</p>                                
                            </div>                            
                            <div class="text-center">
                                <span class="text-bold">INFORMACIÓN GENERAL DEL RESGUARDO</span>
                                <hr>
                            </div>
                            <!-- Campos del formulario -->
                            <div class="col-md-12">
                                <label for="descripcionid" class="form-label">Descripción*</label>
                                <input type="text" id="descripcionid" wire:model.defer="descripcion" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('descripcionid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="marcaid" class="form-label">Marca*</label>
                                <select id="marcaid" wire:model.defer="marca" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('marcaid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="modeloid" class="form-label">Modelo*</label>
                                <input type="text" id="modeloid" wire:model.defer="modelo" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('modeloid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="numerodeserieid" class="form-label">No. de serie*</label>
                                <input type="text" id="numerodeserieid" wire:model.defer="numerodeserie" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('numerodeserieid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="numeroderesguardoid" class="form-label">No. de resguardo*</label>
                                <input type="text" id="numeroderesguardoid" wire:model.defer="numeroderesguardo" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('numeroderesguardoid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="estadodeusoid" class="form-label">Estado de uso*</label>
                                <select id="estadodeusoid" wire:model.defer="estadodeuso" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($estadosdeuso as $estadodeuso)
                                        <option value="{{ $estadodeuso->id }}">{{ $estadodeuso->estado }}</option>
                                    @endforeach
                                </select>
                                @error('estadodeusoid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="areadeasignacionid" class="form-label">Area de asignación*</label>
                                <select id="areadeasignacionid" wire:model.defer="areadeasignacion" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($areasdeasignacion as $areadeasignacion)
                                        <option value="{{ $areadeasignacion->id }}">{{ $areadeasignacion->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('areadeasignacionid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="ubicacionfisicaid" class="form-label">Ubicación fisica*</label>
                                <select id="ubicacionfisicaid" wire:model.defer="ubicacionfisica" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($ubicacionesifiscas as $ubicacionifisca)
                                        <option value="{{ $ubicacionifisca->id }}">{{ $ubicacionifisca->descripcion }}</option>
                                    @endforeach
                                </select>
                                @error('ubicacionfisicaid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="resguardanteid" class="form-label">Resguardante*</label>
                                <select id="resguardanteid" wire:model.defer="resguardante" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($resguardantes as $resguardante)
                                        <option value="{{ $resguardante->id }}">{{ $resguardante->nombre1 }} {{ $resguardante->nombre2 }} {{ $resguardante->apellido1 }} {{ $resguardante->apellido2 }}</option>
                                    @endforeach
                                </select>
                                @error('resguardanteid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="puestodelresguardanteid" class="form-label">Puesto del resguardante*</label>
                                <select id="puestodelresguardanteid" wire:model.defer="puestodelresguardante" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($puestos as $puesto)
                                        <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('puestodelresguardanteid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>








                            <div class="row">
                                <div class="col d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
</div>
