<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;

class EvidenciaResguardo extends Model
{
    use HasFactory;
    protected $table  = "evidencias_resguardo";
    protected $fillable = ['resguardo_id','fecha_evidencia','tipo','archivo','observaciones'];

    /* ====== MUTADORES PARA MAYÚSCULAS ====== */
    public function setArchivoAttribute($value)
    {
        $this->attribputes['archivo'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = mb_strtoupper($value, 'UTF-8');
    }

    public function resguardo()
    {
        return $this->belongsTo(Resguardo::class);
    }
    
}
