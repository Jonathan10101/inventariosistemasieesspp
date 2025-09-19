<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipio;
use App\Models\Escolaridad;
use App\Models\Generaciones;
use App\Models\Inscripciones;
use App\Models\EstatusEstudiante;
use Carbon\Carbon;


class Estudiante extends Model
{
    use HasFactory;

    protected $table = "estudiantes";
    protected $dates = ['fecha_nacimiento'];


    protected $fillable = [
        'id',
        'nombre1', 'nombre2', 'apellido1', 'apellido2', 'matricula_cuip', 
        'municipio_id', 'curp', 'fecha_nacimiento', 'escolaridad_id', 'genero',
        'correo_electronico','celular','cuip'
    ];

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class,'municipio_id','id');
    }

    public function escolaridad()
    {
        return $this->belongsTo(Escolaridad::class,'escolaridad_id','id');        
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripciones::class,'estudiante_id','id');        
    }

    
    public function estatus()
    {
        return $this->hasMany(EstatusEstudiante::class)->latest();
    }

}
