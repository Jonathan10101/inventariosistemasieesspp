<div>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.js"></script>


    <div class="modal-body">
                        <form wire:submit.prevent="save">
                        <div class="col-md-12">
                                <p>  Los campos marcados con (*) son obligatorios</p> 
                                <div class="row">
                                    <hr>
                                    <div class="col d-flex justify-content-center">
                                    @if($student->estatus[0]->estatus=="ACTIVO")
                                      <button type="button"
                                         wire:click="unsubscribeStudent({{$this->id_estudiante}})"  class="btn btn-light btn-sm mt-1 mb-1 d-inline">                                
                                            <i class="fas fa-user-minus mr-2"></i> Dar de baja
                                        </button>     
                                    @else
                                        <button type="button"
                                         wire:click="unsubscribeStudent({{$this->id_estudiante}},'true')"  class="btn btn-light btn-sm mt-1 mb-1 d-inline">                                
                                            <i class="fas fa-eye mr-2"></i> Ver detalles de baja
                                        </button>  
                                    @endif                                     
                                    </div>
                                    <hr class="mt-3">                        
                                </div>     
                                
                     
                        </div>
                        <div class="text-center">
                                <span class="text-bold">INFORMACIÓN GENERAL DEL USUARIO</span>
                                <hr>
                            </div>
                        <div class="row g-3">
                            <!-- Campos del formulario -->
                             <div class="col-md-6">
                                <label for="apellido1" class="form-label">Primer apellido*</label>
                                <input type="text" id="apellido1" wire:model.defer="apellido1" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                @error('apellido1') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="apellido2" class="form-label">Segundo apellido*</label>
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

                            @livewire('select-municipios',['idMunicipio'=>$municipio_procedencia])
                          
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

                   
                            <div class="col-md-6">
                                <label for="matricula_cuip" class="form-label">Matrícula*</label>
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
                                <input type="number" wire:model.defer="celular" id="celular" class="form-control @error('celular') is-invalid @enderror" >                                
                                @if ($errors->has('celular'))
                                    <span class="text-danger">{{ $errors->first('celular') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="correo_electronico" class="form-label">Correo electrónico*</label>
                                <input type="email" id="correo_electronico" wire:model.defer="correo_electronico" class="form-control" oninput="this.value = this.value.toLowerCase()">
                                @error('correo_electronico') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="text-center">
                                <hr>
                                <span class="text-bold">CURSOS TOMADOS</span>
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <!--
                                <label for="cursosTomados" class="form-label d-block">Cursos tomados</label>
                                -->
                                @if(!empty($inscripciones))
                                    @foreach($inscripciones as $inscripcion)

                                        <p class="d-inline">{{format_text($inscripcion->cursos->nombre_curso)}}</p>                                              
                                        <button     type="button"
                                         wire:click="updateCourse({{$inscripcion->cursos->id}},{{$inscripcion->grupo_id}},{{$inscripcion->adscripcion_id}},
                                        {{$inscripcion->sede_id}},{{$inscripcion->generacion_id}},'{{$inscripcion->generaciones->fecha_inicio}}',
                                        {{$inscripcion->generaciones->fecha_terminacion}},{{$inscripcion->id}},
                                        '{{$inscripcion->fecha_validacion_inicial}}','{{$inscripcion->fecha_validacion_final}}','{{$inscripcion->fecha_de_ejecucion_inicial}}','{{$inscripcion->fecha_de_ejecucion_final}}')"  class="btn btn-light btn-sm mt-1 mb-1 d-inline">                                
                                            <i class="fas fa-edit"></i> Editar
                                        </button>                   
                         
                                        


                                        <br>
                                    @endforeach
                                @else
                                    <p>Ninguno</p>
                                @endif
                            </div>

                            
    <!-- Paginación -->
    <div class="d-flex justify-content-end mt-3">

    </div>


                            <div class="row">
                                <div class="col d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>



                          
                        </div>
                        </form>
    </div>















    @push('js')

@livewireScripts

@endpush
</div>
