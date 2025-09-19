<div>
    <div class="modal-body">
        <form wire:submit.prevent="save">
            <div class="row g-3">                            
                <div class="col-md-6">
                    <label for="fullname" class="form-label">Nombre completo</label>
                    <p>{{ $student->nombre1 }} {{ $student->nombre2 }} {{ $student->apellido1 }} {{ $student->apellido2 }}</p>
                </div>
                <div class="col-md-6">
                    <label for="matriculaLabel" class="form-label">Matrícula</label>
                    <p>{{ $student->matricula_cuip }}</p>
                </div>
                <div class="col-md-12">
                    
                <div class="text-center">
                    <span class="text-bold">CURSOS TOMADOS</span>
                    <hr>
                </div>
                    @if (!empty($inscripciones))
                        @foreach ($inscripciones as $inscripcion)
                            <p class="d-inline">{{format_text($inscripcion->cursos->nombre_curso)}}</p>
                            <br>
                        @endforeach
                    @else
                        <p>Ninguno</p>
                    @endif
                </div>
                <hr>
                <!-- Selector de opción entre Generación o Curso -->
            
                <div class="text-center">
                    <span class="form-label text-bold">TIPO DE REGISTRO</span>
                    <hr>
                <div>
                    

              
                    <input type="radio" id="opcion_generacion" value="generacion" 
                        wire:model="tipo_registro"
                        wire:click="setGeneracion">
                    <label for="opcion_generacion">Formación Inicial</label>
        
                    <input type="radio" id="opcion_curso" value="curso" 
                       wire:model="tipo_registro"
                        wire:click="setCurso" class="ms-3">
                    <label for="opcion_curso">Formación Continua</label>
                </div>
                </div>


                @if ($tipo_registro != '')

                    <div class="col-md-12">
                        <label for="labelcursoid" class="form-label">Nombre</label>
                        <select id="labelcursoid" wire:model.defer="curso_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($cursos as $curso)
                                @if(($curso->type_of_course == 'programa' && $tipo_registro === 'generacion') || ($curso->type_of_course == 'curso' && $tipo_registro === 'curso'))
                                    <option value="{{ $curso->id }}">{{ $curso->nombre_curso }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('curso_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    
                    <div class="col-md-12">
                        <label for="labelinstitucionid" class="form-label">Institución que contrato</label>
                        <select id="labelinstitucionid" wire:model.defer="institucion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($instituciones as $institucion)
                                {{--
                                @if(($curso->type_of_course == 'programa' && $tipo_registro === 'generacion') || ($curso->type_of_course == 'curso' && $tipo_registro === 'curso'))
                                --}}
                                    <option value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
                                {{--                                    
                                @endif
                                --}}
                            @endforeach
                        </select>
                        @error('institucion_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                        <label for="id_grupo" class="form-label">Grupo</label>
                        <select id="id_grupo" wire:model.defer="grupo_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre_grupo }}</option>
                            @endforeach
                        </select>
                        @error('grupo_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="id_sede" class="form-label">Sede</label>
                        <select id="id_sede" wire:model.defer="sede_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                            @endforeach
                        </select>
                        @error('sede_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="id_adscripcion" class="form-label">Adscripción</label>
                        <select id="id_adscripcion" wire:model.defer="adscripcion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($adscripciones as $adscripcion)
                                <option value="{{ $adscripcion->id }}">{{ $adscripcion->nombre_adscripcion }}</option>
                            @endforeach
                        </select>
                        @error('adscripcion_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>      
                    
              

                    {{--
                    <div class="col-md-6">
                        <label for="labeltutorid" class="form-label">Tutor</label>
                        <select id="labeltutorid" wire:model.defer="tutor_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">{{$instructor->nombre1}} {{$instructor->nombre2}} {{$instructor->apellido1}} {{$instructor->apellido2}}</option>
                            @endforeach
                        </select>
                        @error('tutor_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    --}}
                @endif                 
                
                




                <!-- Campos para Generación -->
                @if ($tipo_registro === 'generacion')
                    <div class="col-md-6">
                        <label for="generacion_id" class="form-label">Generación</label>
                        <select id="generacion_id" wire:model.defer="generacion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            
                            @foreach ($generacionesv2 as $generacion)
                            {{--
                                Esta validación es para que la generacion NINGUNA no pueda ser utilizada
                            --}}
                            @if($generacion->id == 1)
                                @continue
                            @endif
                                <option value="{{ $generacion->id }}">{{ $generacion->nombre_generacion }}</option>
                            @endforeach
                        </select>
                        @error('generacion_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Campos para Curso -->
                @if ($tipo_registro === 'curso')               
                    <div class="col-md-6">
                        {{$fecha_inicio_id}}
                        <label for="id_fecha_inicio" class="form-label">Fecha de inicio</label>
                        <input type="date" wire:model.defer="fecha_inicio_id" class="form-control">
                        @error('fecha_inicio_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="id_fecha_final" class="form-label">Fecha de terminación</label>
                        <input type="date" wire:model.defer="fecha_final_id" class="form-control">
                        @error('fecha_final_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
