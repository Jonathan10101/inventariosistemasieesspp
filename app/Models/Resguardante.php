<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\HistorialResguardo;

class Resguardante extends Model
{
    use HasFactory;
    protected $table  = "resguardantes";
    protected $fillable = ['nombre1','nombre2','apellido1','apellido2'];

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
        return $this->hasMany(Resguardo::class);
    }

    public function historialResguardos()
    {
        return $this->hasMany(HistorialResguardo::class, 'resguardante_id');
    }


}
