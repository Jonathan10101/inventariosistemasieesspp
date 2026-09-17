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

    /* ====== MUTADORES PARA MAYÚSCULAS ====== */
    public function setEstadoAttribute($value)
    {
        $this->attributes['estado'] = mb_strtoupper($value, 'UTF-8');
    }

    public function resguardos()
    {
        return $this->hasMany(HistorialResguardo::class);
    }
}
