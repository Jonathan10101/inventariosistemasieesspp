<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class Escolaridad extends Model
{
    use HasFactory;
    protected $table = "escolaridad";
    protected $fillable = [
        'nivel_escolaridad', 'descripcion'
    ];


    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class,'escolaridad_id', 'id');
        

    }
}
