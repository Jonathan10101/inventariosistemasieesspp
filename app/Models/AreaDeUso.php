<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\HistorialResguardo;

class AreaDeUso extends Model
{
    use HasFactory;
    protected $table = "area_de_uso";
    protected $fillable = ['nombre'];

    /* ====== MUTADORES PARA MAYÚSCULAS ====== */
    public function setAttribute($key, $value)
    {
        // Si el atributo es fillable y es string, lo convierte en mayúsculas
        if (in_array($key, $this->fillable) && is_string($value)) {
            $value = strtoupper($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function resguardos()
    {
        return $this->hasMany(HistorialResguardo::class);
    }
    
}
