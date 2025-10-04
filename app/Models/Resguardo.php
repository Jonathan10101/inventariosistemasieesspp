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

class Resguardo extends Model
{
    use HasFactory;
    protected $table  = "resguardo";
    protected $fillable = ['id','descripcion','marca_id','modelo','nserie','nresguardo','estado_uso_id','area_de_uso_id','ubicacion_fisicas_id','resguardante_id','puesto_id','imagen','resguardo_pdf'];

    public function marca()
    {
        return $this->belongsTo(Marca::class,'marca_id','id');        
    }

    public function estadouso()
    {
        return $this->belongsTo(EstadoUso::class,'estado_uso_id','id');        
    }

    public function ubicacionFisica(){
        return $this->belongsTo(UbicacionFisica::class,'ubicacion_fisicas_id','id');
    }

    public function resguardante()
    {
        return $this->belongsTo(Resguardante::class,'resguardante_id','id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class,'puesto_id','id');
    }

    public function areadeasignacion()
    {
        return $this->belongsTo(AreaDeUso::class,'area_de_uso_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($resguardo) {
            // Una vez creado, asignamos el mismo valor que el id
            $resguardo->nresguardo = $resguardo->id;
            $resguardo->save();
        });
    }





}
