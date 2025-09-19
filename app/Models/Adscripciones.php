<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inscripciones;

class Adscripciones extends Model
{
    use HasFactory;


    public function inscripciones()
    {
        return $this->hasMany(Inscripciones::class,'adscripcion_id','id');
    }
}
