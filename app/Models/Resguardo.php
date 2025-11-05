<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca;
use App\Models\EstadoUso;
use App\Models\Resguardante;
use App\Models\Puesto;
use App\Models\AreaDeUso;
use App\Models\UbicacionFisica;
use App\Models\HistorialResguardo;

class Resguardo extends Model
{
    use HasFactory;

    protected $table = 'resguardos';

     protected $fillable = [
        'descripcion',
        'marca_id',
        'modelo',
        'nserie',
        'nresguardo',
        'resguardante_id',
        'puesto_id',
        'imagen',
        'estado_actual',
    ];

    
    /* ====== MUTADORES PARA MAYÚSCULAS ====== */
    public function setDescripcionAttribute($value)
    {
        $this->attributes['descripcion'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setModeloAttribute($value)
    {
        $this->attributes['modelo'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setNserieAttribute($value)
    {
        $this->attributes['nserie'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setNresguardoAttribute($value)
    {
        $this->attributes['nresguardo'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setEstadoActualAttribute($value)
    {
        $this->attributes['estado_actual'] = mb_strtoupper($value, 'UTF-8');
    }

    /* ================= RELACIONES ================= */
    public function historial()
    {
        return $this->hasMany(HistorialResguardo::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

   
    public function resguardante()
    {
        return $this->belongsTo(Resguardante::class, 'resguardante_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }


    /* ================= EVENTOS ================= */

    protected static function boot()
    {
        parent::boot();

        static::created(function ($resguardo) {
            $resguardo->update(['nresguardo' => $resguardo->id]);
        });
    }

    /* ================= MÉTODOS DE ESTADO ================= */

    public function marcarComoDisponible()
    {
        $this->update(['estado_actual' => 'disponible']);
    }

    public function marcarComoAsignado()
    {
        $this->update(['estado_actual' => 'asignado']);
    }

    public function marcarComoBaja()
    {
        $this->update(['estado_actual' => 'baja']);
    }
    
}
