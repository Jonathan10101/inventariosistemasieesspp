<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\Resguardante;
use App\Models\EvidenciaResguardo;

class SolicitudEvidencia extends Model
{
    use HasFactory;

     protected $fillable = [
        'resguardo_id','resguardante_id','scheduled_at','due_at','sent_at',
        'status','reminder_count','evidencia_id'
    ];

    public function resguardo() { return $this->belongsTo(Resguardo::class); }
    public function resguardante() { return $this->belongsTo(Resguardante::class); }
    public function evidencia() { return $this->belongsTo(EvidenciaResguardo::class, 'evidencia_id'); }
}
