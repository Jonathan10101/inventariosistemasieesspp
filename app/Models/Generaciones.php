<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\inscripciones;


class Generaciones extends Model
{
    use HasFactory;

    protected $table = "generaciones";
    

    public function inscripciones()
    {
        return $this->hasMany(Inscripciones::class);
    }
}
