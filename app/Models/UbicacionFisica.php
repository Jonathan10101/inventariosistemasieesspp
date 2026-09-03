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
        /*
         * Solamente convierte la descripción a mayúsculas.
         * Nunca modifica la ruta de la imagen.
         */
        if ($key === 'descripcion' && is_string($value)) {
            $value = mb_strtoupper(
                trim($value),
                'UTF-8'
            );
        }

        return parent::setAttribute($key, $value);
    }

    public function historialResguardos()
    {
        return $this->hasMany(
            HistorialResguardo::class,
            'ubicacion_fisicas_id'
        );
    }


}
