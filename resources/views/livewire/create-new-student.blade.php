<div>
    <div class="modal-body">
                        <form wire:submit.prevent="save" >
                        <div class="row g-3">
                            <div class="col-md-12">
                                <p>  Los campos marcados con (*) son obligatorios</p>                                
                            </div>                            
                            <div class="text-center">
                                <span class="text-bold">INFORMACIÓN GENERAL DEL USUARIO</span>
                                <hr>
                            </div>
                            <!-- Campos del formulario -->
                             <div class="col-md-6">
                                <label for="apellido1" class="form-label">Primer apellido*</label>
                                <input type="text" id="apellido1" wire:model.defer="apellido1" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('apellido1') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="apellido2" class="form-label">Segundo apellido</label>
                                <input type="text" id="apellido2" wire:model.defer="apellido2" class="form-control" oninput="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="col-md-6">
                                <label for="nombre1" class="form-label">Primer nombre*</label>
                                <input type="text" id="nombre1" wire:model.defer="nombre1" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('nombre1') <span class="text-danger">{{ $message }}</span> @enderror                                
                            </div>
                            <div class="col-md-6">
                                <label for="nombre2" class="form-label">Segundo nombre</label>
                                <input type="text" id="nombre2" wire:model.defer="nombre2" class="form-control" oninput="this.value = this.value.toUpperCase()">
                            </div>         
                            <div class="col-md-6">
                                <label for="curp" class="form-label">CURP*</label>
                                <input type="text" id="curp" wire:model.defer="curp" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('curp') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>   
                            <div class="col-md-6">
                                <label for="genero" class="form-label">Sexo*</label>
                                <select id="genero" wire:model.defer="genero" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <option value="H">Masculino</option>
                                    <option value="M">Femenino</option>
                                </select>
                                @error('genero') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>  

                            @livewire('select-municipios')         

                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento*</label>
                                <input type="date" id="fecha_nacimiento" wire:model.defer="fecha_nacimiento" class="form-control">
                                @error('fecha_nacimiento') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>   

                            <div class="text-center">
                                <span class="text-bold">DATOS ESCOLARES</span>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <label for="id_escolaridad" class="form-label">Escolaridad*</label>
                                <select id="id_escolaridad" wire:model.defer="id_escolaridad" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($escolaridades as $escolaridad)
                                        <option value="{{ $escolaridad->id }}">{{ $escolaridad->nivel_escolaridad }}</option>
                                    @endforeach
                                </select>
                                @error('id_escolaridad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="matricula_cuip" class="form-label">Matrícula</label>
                                <input type="text" id="matricula_cuip" wire:model.defer="matricula_cuip" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('matricula_cuip') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>     
                            <div class="col-md-6">
                                <label for="cuip" class="form-label">CUIP</label>
                                <input type="text" id="cuip" wire:model.defer="cuip" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('cuip') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>     

                            <div class="text-center">
                                <span class="text-bold">DATOS DE CONTACTO</span>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <label for="celular">Número de celular*</label>
                                <input type="number" wire:model.defer="celular" id="celular" class="form-control" >
                                @error('celular') <span class="text-danger">{{ $message }}</span> @enderror
                                {{--
                                @error('celular')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                
                                @if ($errors->has('celular'))
                                    <span class="text-danger">{{ $celular }}</span>
                                @endif
                                --}}
                            </div>
                            <div class="col-md-6">
                                <label for="correo_electronico" class="form-label">Correo electrónico*</label>
                                <input type="email" id="correo_electronico" wire:model.defer="correo_electronico" class="form-control"  oninput="this.value = this.value.toLowerCase()">
                                @error('correo_electronico') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>                        

                            {{--
                            <div class="col-md-6">
                                <label for="municipio_procedencia" class="form-label">Municipio*</label>
                                <select id="municipio_procedencia" wire:model.defer="municipio_procedencia" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($municipios as $municipio)
                                        <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                    @endforeach
                                </select>
                                @error('municipio_procedencia') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            --}}
                                
                            <div class="col-md-12 text-center mt-3 d-none">
                            <!-- Botón para mostrar/ocultar los campos adicionales -->
                                <button type="button" class="btn btn-info" wire:click="toggleAdditionalFields">
                                    {{ $showAdditionalFields ? 'Cancelar asignación de curso' : 'Asignar curso' }}
                                </button>
                            </div>

                        @if ($showAdditionalFields)
                            <hr>

                            <div class="col-md-12">
                                <label for="id_curso" class="form-label">Curso</label>
                                <select id="id_curso" wire:model.defer="id_curso" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($cursos && $cursos->isNotEmpty())                                
                                        @foreach($cursos as $curso)
                                            <option value="{{ $curso->id }}">{{ $curso->nombre_curso }}</option>
                                        @endforeach
                                    @else
                                        <p>No hay cursos disponibles.</p>
                                    @endif
                                </select>                                
                            </div>
                            <div class="col-md-6">
                                <label for="id_grupo" class="form-label">Grupo</label>
                                <select id="id_grupo" wire:model.defer="id_grupo" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($grupos && $grupos->isNotEmpty())                                
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                                        @endforeach
                                    @else
                                        <p>No hay grupos disponibles.</p>
                                    @endif
                                </select>                                
                            </div>
                            <div class="col-md-6">
                                <label for="id_sede" class="form-label">Sede</label>
                                <select id="id_sede" wire:model.defer="id_sede" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($sedes && $sedes->isNotEmpty())                                
                                        @foreach($sedes as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                                        @endforeach
                                    @else
                                        <p>No hay sedes disponibles.</p>
                                    @endif
                                </select>                                
                            </div>
                            <div class="col-md-6">
                                <label for="id_adscripcion" class="form-label">Adscripción</label>
                                <select id="id_adscripcion" wire:model.defer="id_adscripcion" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($adscripciones && $adscripciones->isNotEmpty())                                
                                        @foreach($adscripciones as $adscripcion)
                                            <option value="{{ $adscripcion->id }}">{{ $adscripcion->nombre_adscripcion }}</option>
                                        @endforeach
                                    @else
                                        <p>No hay adscripciones disponibles.</p>
                                    @endif
                                </select>                                
                            </div>
                            
                            <div class="col-md-6">
                                <label for="generacion_id" class="form-label">Generación</label>
                                <select id="generacion_id" wire:model.defer="generacion_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @if ($generacionesv2 && $generacionesv2->isNotEmpty())  
                                        @foreach($generacionesv2 as $generacion)
                                            <option value="{{ $generacion->id }}">{{ $generacion->nombre_generacion }}</option>
                                        @endforeach
                                    @else
                                        <p>No hay generaciones disponibles.</p>
                                    @endif
                                </select>                                
                            </div>
                            

                            <div class="col-md-6">
                                <label for="id_fecha_inicio" class="form-label">Fecha de inicio</label>
                                <input type="date" name="id_fecha_inicio"  class="form-control">                                                    
                            </div>
                            <div class="col-md-6">
                                <label for="id_fecha_final" class="form-label">Fecha final</label>
                                <input type="date" name="id_fecha_final" class="form-control">                                                    
                            </div>

                        @endif

                            <div class="row">
                                <div class="col d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                        </form>
    </div>
</div>
