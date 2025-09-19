<div class="modal-body">
    <form >
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
                <hr>
                <label for="cursosTomados" class="form-label d-block text-bold text-center">CURSOS TOMADOS</label>
                <hr>
                @if (!empty($inscripciones))
                    @foreach ($inscripciones as $inscripcion)
                        <p class="d-inline">{{format_text_full($inscripcion->cursos->nombre_curso)}}</p>
                        <button 
                            type="button" 
                            class="btn btn-warning btn-sm mt-1 mb-1 d-inline"
                            wire:click="save({{ $student->id }}, {{ $inscripcion->cursos->id }}, '{{ $inscripcion->cursos->nombre_curso }}')">
                            <i class="fas fa-download"></i> Certificado
                        </button>
                        <br>
                        
                    @endforeach
                @else
                    <p>Ninguno</p>
                @endif                                
            </div>
        </div>
    </form>
</div>
