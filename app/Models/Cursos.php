<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inscripciones;
use App\Models\Instituciones;

class Cursos extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'nombre_curso', 'duracion_en_horas','type_of_course','activo'
    ];
    

    public function inscripciones()
    {
        return $this->hasMany(Inscripciones::class,'curso_id','id');        
    }

    /*
    public function instituciones()
    {
        return $this->belongsToMany(Instituciones::class,'curso_id','id');
    }
    */

    public function instituciones()
    {
        return $this->belongsToMany(
            Instituciones::class,         // Modelo relacionado
            'cursos_instituciones',     // Tabla pivote
            'curso_id',                 // Clave foránea en la tabla pivote
            'institucion_id'            // Clave foránea del modelo relacionado
        );
    }


  
}
