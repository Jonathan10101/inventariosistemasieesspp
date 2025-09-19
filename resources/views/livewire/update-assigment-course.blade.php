<div>


        <div class="modal-body">
                        <form wire:submit.prevent="save">
                        <div class="col-md-12">
                                <p>  Los campos marcados con (*) son obligatorios</p>                                
                        </div>
                        <div class="row g-3">           
                            <div class="col-md-12">
                                <label for="id_curso" class="form-label">Curso*</label>
                                    <select id="id_curso" wire:model.defer="id_curso" class="form-control">
                                        <option value="{{ $id_curso }}" selected>
                                            {{ $cursos->firstWhere('id', $id_curso)->nombre_curso }}
                                        </option>
                                        {{-- 
                                        @if ($cursos && $cursos->isNotEmpty())                                
                                            @foreach($cursos as $curso)
                                            <!-- Evitar el curso seleccionado -->
                                                @if($curso->id != $id_curso)
                                                    <option value="{{ $curso->id }}">{{ $curso->nombre_curso }}</option>
                                                @endif
                                            @endforeach
                                            <!-- Mostrar el curso seleccionado por defecto -->
                                            @if($id_curso)
                                                    <option value="{{ $id_curso }}" selected>
                                                        {{ $cursos->firstWhere('id', $id_curso)->nombre_curso }}
                                                    </option>
                                            @endif
                                        @else
                                            <option>No hay cursos disponibles.</option>
                                        @endif
                                        --}}

                                    </select>
                            </div>


                            <div class="col-md-6 mt-4 mb-4">
                                <div class="col text-center mb-3">
                                    <label for="id_fecha_validacion" class="form-label">Fecha de validación</label><br>
                                </div>
                                <div class="col d-flex justify-content-around">
                                    <label for="fvi" class="text-dark">Inicial</label>
                                    <label for="fvf">Final</label>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <input type="date" wire:model.defer="fecha_validacion_id_inicial" id="fvi" class="form-control">
                                    <input type="date" wire:model.defer="fecha_validacion_id_final" id="fvf" class="form-control">
                                </div>
                                <div class="col">
                                    @error('fecha_validacion_id_inicial') <span class="text-danger">{{ $message }}</span> @enderror
                                    @error('fecha_validacion_id_final') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-4 mb-4">
                                <div class="col text-center mb-3">
                                    <label for="id_fecha_final" class="form-label">Fecha de ejecucion</label><br>
                                </div>
                                <div class="col d-flex justify-content-around">
                                    <label for="fei">Inicial</label>
                                    <label for="fef">Final</label>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <input type="date" wire:model.defer="fecha_ejecucion_id_inicial" id="fei" class="form-control">
                                    <input type="date" wire:model.defer="fecha_ejecucion_id_final" id="fef" class="form-control">
                                </div>
                                <div class="col">
                                    @error('fecha_ejecucion_id_inicial') <span class="text-danger">{{ $message }}</span> @enderror
                                    @error('fecha_ejecucion_id_final') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>                            

                                            

                            <div class="col-md-6">
                                <label for="id_grupo" class="form-label">Grupo*</label>
                                <select id="id_grupo" wire:model.defer="id_grupo" class="form-control">                                                                
                                    @if ($grupos && $grupos->isNotEmpty())                                
                                            @foreach($grupos as $grupo)
                                                @if($grupo->id != $id_grupo) {{-- Evitar el grupo seleccionado --}}
                                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                                                @endif
                                            @endforeach
                                            {{-- Mostrar el grupo seleccionado por defecto --}}
                                            @if($id_grupo)
                                                <option value="{{ $id_grupo }}" selected>
                                                    {{ $grupos->firstWhere('id', $id_grupo)->nombre_grupo }}
                                                </option>
                                            @endif
                                        @else
                                            <option>No hay grupos disponibles.</option>
                                    @endif
                                </select>                                
                            </div>
                            <div class="col-md-6">
                                <label for="id_sede" class="form-label">Sede*</label>
                                <select id="id_sede" wire:model.defer="id_sede" class="form-control">                                                 
                                    @if ($sedes && $sedes->isNotEmpty())                                
                                            @foreach($sedes as $sede)
                                                @if($sede->id != $id_sede) {{-- Evitar la sede seleccionada --}}
                                                    <option value="{{ $sede->id }}">{{ $grupo->nombre_sede }}</option>
                                                @endif
                                            @endforeach
                                            {{-- Mostrar la sede seleccionada por defecto --}}
                                            @if($id_sede)
                                                <option value="{{ $id_sede }}" selected>
                                                    {{ $sedes->firstWhere('id', $id_sede)->nombre_sede }}
                                                </option>
                                            @endif
                                        @else
                                            <option>No hay sedes disponibles.</option>
                                    @endif
                                </select>                                
                            </div>
                            <div class="col-md-6">                                
                                <label for="id_adscripcion" class="form-label">Adscripción*</label>
                                
                                <select id="id_adscripcion" wire:model.defer="id_adscripcion" class="form-control">                                                                          
                                    @if ($adscripciones && $adscripciones->isNotEmpty())                                
                                            @foreach($adscripciones as $adscripcion)
                                                @if($adscripcion->id != $id_adscripcion) {{-- Evitar la adscripcion seleccionada --}}
                                                    <option value="{{ $adscripcion->id }}">{{ $adscripcion->nombre_adscripcion }}</option>
                                                @endif
                                            @endforeach
                                            {{-- Mostrar la adscripcion seleccionada por defecto --}}
                                            @if($id_adscripcion)
                                                <option value="{{ $id_adscripcion }}" selected>
                                                    {{ $adscripciones->firstWhere('id', $id_adscripcion)->nombre_adscripcion }}
                                                </option>
                                            @endif
                                        @else
                                            <option>No hay adscripciones disponibles.</option>
                                    @endif
                                </select>                                
                            </div>

                            {{--
                            <div class="col-md-6">
                                <label for="id_fecha_inicioL" class="form-label">Fecha de validación*</label>
                                <input type="date" wire:model="fecha_validacion_id"  class="form-control" required>                                                                                                                                                    
                            </div>
                            <div class="col-md-6">
                                <label for="id_fecha_finalF" class="form-label">Fecha de ejecución*</label>                                
                                <input type="date" wire:model="fecha_ejecucion_id" class="form-control" required>                                                    
                            </div>
                               --}}
                            
                            

                            
                        @if ($id_generacion == 1)
                            <div class="col-md-6">
                                <label for="id_fecha_inicioL" class="form-label">Fecha de inicio*</label>
                                {{--
                                @if ($id_generacion == 1)
                                    {{ $inscripcion->fecha_inicio }}                                    
                                @else
                                    {{ $fecha_inicio_id }}                                    
                                @endif
                                --}}
                                <input type="date" wire:model="fecha_inicio_id"  class="form-control" required>                                                                                                                                                    
                            </div>
                            <div class="col-md-6">
                                <label for="id_fecha_finalF" class="form-label">Fecha de terminación*</label>                                
                                {{--
                                @if ($id_generacion == 1)
                                    {{ $inscripcion->fecha_fin }}                                    
                                @else
                                    {{ $fecha_final_id }}                                    
                                @endif
                                --}}
                                <input type="date" wire:model="fecha_final_id" class="form-control" required>                                                    
                            </div>
                        @else
                            <div class="col-md-6">
                                <label for="generacion_id_label" class="form-label">Generación*</label>
                                <select id="generacion_id_label" wire:model.defer="id_generacion" class="form-control">                                                                        
                                    @if ($generacionesv2 && $generacionesv2->isNotEmpty())                                                                    
                                            @foreach($generacionesv2 as $generacion)        
                                                @if($generacion->id == 1)
                                                    @continue
                                                @endif               
                                                                                                                               
                                                @if($generacion->id != $id_generacion) {{-- Evitar la generacion seleccionada --}}
                                                    <option value="{{ $generacion->id }}">{{ $generacion->nombre_generacion }}</option>
                                                @endif
                                            @endforeach
                                            {{-- Mostrar la generacion seleccionada por defecto --}}
                                            @if($id_generacion)                                            
                                                <option value="{{ $id_generacion }}" selected>
                                                    {{ $generacionesv2->firstWhere('id', $id_generacion)->nombre_generacion }}
                                                </option>
                                            @endif
                                        @else
                                            <option>No hay generaciones disponibles.</option>
                                    @endif
                                </select>                                
                            </div>
                        @endif



                        </div>





                        <div class="row">
                            <div class="col d-flex justify-content-end mt-5">
                                <button type="submit" class="btn btn-primary ">Guardar</button>
                            </div>
                        </div>    
                          
                        
                        </form>
        </div>
</div>
