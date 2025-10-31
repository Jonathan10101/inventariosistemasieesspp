<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\HistorialResguardo;

class EstadoUso extends Model
{
    use HasFactory;
    protected $table  = "estado_uso";
    protected $fillable = ['estado'];


    public function resguardos()
    {
        return $this->hasMany(HistorialResguardo::class);
    }
}
