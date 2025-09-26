<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;

class EstadoUso extends Model
{
    use HasFactory;
    protected $table  = "estado_uso";
    protected $fillable = ['estado'];


    public function resguardos()
    {
        return $this->hasMany(Resguardo::class);
    }
}
