<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;


class EstatusEstudiante extends Model
{
    use HasFactory;

    protected $fillable = ['estudiante_id', 'estatus', 'fecha_baja', 'motivo_baja'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
