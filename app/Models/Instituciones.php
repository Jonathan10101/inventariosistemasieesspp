<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cursos;

class Instituciones extends Model
{
    use HasFactory;

        
    protected $fillable = [
        'nombre'
    ];

    /*
    public function cursos()
    {
        return $this->belongsToMany(Cursos::class);    
    }
    */


    public function cursos()
    {
        return $this->belongsToMany(
            Curso::class,               // Modelo relacionado
            'cursos_instituciones',     // Tabla pivote
            'institucion_id',           // Clave foránea en la tabla pivote
            'curso_id'                  // Clave foránea del modelo relacionado
        );
    }

}
