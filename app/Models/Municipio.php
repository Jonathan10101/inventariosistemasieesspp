<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\Estado;



class Municipio extends Model
{
    use HasFactory;

    
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class,'municipio_id', 'id');
    }


    public function estado()
    {
        return $this->belongsTo(Estado::class,'estado_id','id');
    }
}
