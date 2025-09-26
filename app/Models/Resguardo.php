<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resguardo extends Model
{
    use HasFactory;
    protected $table  = "resguardo";
    protected $fillable = ['id','descripcion','marca_id','modelo','nserie','nresguardo','estado_uso_id','area_de_uso_id','ubicacion_fisicas_id','resguardante_id','puesto_id'];
}
