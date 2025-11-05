<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\HistorialResguardo;

class UbicacionFisica extends Model
{
    use HasFactory;
    protected $table = 'ubicacion_fisicas';
    protected $fillable = ['descripcion','imagen'];

    public function setAttribute($key, $value)
    {
        // Si el atributo es fillable y es string, lo convierte en mayúsculas
        if (in_array($key, $this->fillable) && is_string($value)) {
            $value = strtoupper($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function historialResguardos()
    {
        return $this->hasMany(HistorialResguardo::class, 'ubicacion_fisicas_id');
    }


}
