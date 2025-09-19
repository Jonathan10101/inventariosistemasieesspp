<div class="col-12 p-0">
    <!-- resources/views/livewire/select-municipios.blade.php -->
<div class="d-flex">
    <div class="form-group col-6">
        <label for="estado">Estado*</label>
        <select id="estado" class="form-control" wire:model.lazy="estado_id" required>
            <option value="">Seleccione un estado</option>
            @foreach ($estados as $estado)
                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
            @endforeach
        </select>        
    </div>

    <div class="form-group col-6">
        <label for="municipio">Municipio*</label>
        <select id="municipio" class="form-control" wire:model="municipio_procedencia"  wire:change="cambiarMunicipio($event.target.value)" required>
            <option value="">Seleccione un municipio</option>
            @foreach ($municipios as $municipio)
                <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
            @endforeach
        </select>        
    </div>

    
</div>

</div>
