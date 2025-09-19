<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Generaciones;
use  App\Models\Estudiante;
use  App\Models\Cursos;
use App\Models\Sedes;
use App\Models\Adscripciones;
use App\Models\Grupos;

class Inscripciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id', 'curso_id', 'grupo_id','adscripcion_id','sede_id','generacion_id','fecha_inicio','fecha_fin','promedio','fecha_validacion_inicial','fecha_validacion_final','fecha_de_ejecucion_inicial','fecha_de_ejecucion_final'
    ];

    protected $table = "inscripciones";



    public function generaciones()
    {
        return $this->belongsTo(Generaciones::class,'generacion_id','id');        
    }

    public function estudiantes()
    {
        return $this->belongsTo(Estudiante::class,'estudiante_id','id');
    }

    public function cursos()
    {
        return $this->belongsTo(Cursos::class,'curso_id','id');        
    }

    public function sedes(){
        return $this->belongsTo(Sedes::class,'sede_id','id');
    }
    
    public function adscripciones(){
        return $this->belongsTo(Adscripciones::class,'adscripcion_id','id');
    }

    public function grupos(){
        return $this->belongsTo(Grupos::class,'grupo_id','id');
    }

}
