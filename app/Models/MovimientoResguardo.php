<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;


class MovimientoResguardo extends Model
{
    use HasFactory;
    protected $table  = "movimientos_resguardo";
    protected $fillable = ['resguardo_id','resguardante_id','fecha_entrega','fecha_recepcion','motivo'];

    public function resguardo()
    {
        return $this->belongsTo(Resguardo::class);
    }

}
