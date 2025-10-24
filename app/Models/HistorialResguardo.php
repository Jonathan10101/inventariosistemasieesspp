<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\Resguardante;

class HistorialResguardo extends Model
{
    use HasFactory;
    protected $fillable = ['id','resguardo_id','resguardante_id','resguardo_pdf','fecha_asignacion','fecha_liberacion'];
    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_liberacion' => 'datetime',
    ];


    public function resguardo()
    {
        return $this->belongsTo(Resguardo::class);
    }

    public function resguardante()
    {
        return $this->belongsTo(Resguardante::class);
    }



}
