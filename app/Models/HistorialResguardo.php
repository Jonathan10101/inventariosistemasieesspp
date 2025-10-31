<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;
use App\Models\Resguardante;
use App\Models\EstadoUso;
use App\Models\UbicacionFisica;
use App\Models\AreaDeUso;

class HistorialResguardo extends Model
{
    use HasFactory;

    protected $table = 'historial_resguardos';

    protected $fillable = [
        'resguardo_id',
        'resguardante_id',
        'fecha_asignacion',
        'fecha_liberacion',
        'fecha_baja',
        'resguardo_pdf',
        'baja_pdf',
        'evidencia_baja',
        'motivo_baja',
        'imagen_evidencia',

        'estado_uso_id',
        'area_de_uso_id',
        'ubicacion_fisicas_id',
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_liberacion' => 'datetime',
        'fecha_baja' => 'datetime',
    ];

    /* ================= RELACIONES ================= */

    public function resguardo()
    {
        return $this->belongsTo(Resguardo::class);
    }

    public function resguardante()
    {
        return $this->belongsTo(Resguardante::class);
    }

    /* ================= MÉTODOS ================= */

    public static function registrarAsignacion($resguardo, $resguardanteId, $pdfPath = null, $imagenPath = null,$estado_uso_id,$area_de_uso_id,$ubicacion_fisicas_id)
    {
        return self::create([
            'resguardo_id'      => $resguardo->id,
            'resguardante_id'   => $resguardanteId,
            'fecha_asignacion'  => now(),
            'resguardo_pdf'     => $pdfPath,
            'imagen_evidencia' => $imagenPath, // ← aquí guardas la foto o evidencia
            'tipo_evento'       => 'asignacion',
            'descripcion_evento'=> 'Equipo asignado al resguardante.',
            'estado_uso_id' => $estado_uso_id,
            'area_de_uso_id' => $area_de_uso_id,
            'ubicacion_fisicas_id' => $ubicacion_fisicas_id,
        ]);
}


    public function registrarLiberacion()
    {
        $this->update(['fecha_liberacion' => now()]);
    }

    public function registrarBaja($pdfPath, $evidenciaPath = null, $motivo = null)
    {
        $this->update([
            'fecha_baja' => now(),
            'baja_pdf' => $pdfPath,
            'evidencia_baja' => $evidenciaPath,
            'motivo_baja' => $motivo,
        ]);
    }

    /* ================= ACCESORES ================= */

    public function getFechaAsignacionFormattedAttribute()
    {
        return $this->fecha_asignacion?->format('d/m/Y H:i');
    }

    public function getFechaLiberacionFormattedAttribute()
    {
        return $this->fecha_liberacion?->format('d/m/Y H:i');
    }

    public function getFechaBajaFormattedAttribute()
    {
        return $this->fecha_baja?->format('d/m/Y H:i');
    }


    public function estadouso()
    {
        return $this->belongsTo(EstadoUso::class, 'estado_uso_id');
    }

    public function ubicacionFisica()
    {
        return $this->belongsTo(UbicacionFisica::class, 'ubicacion_fisicas_id');
    }

    
    public function areaDeUso()
    {
        return $this->belongsTo(AreaDeUso::class, 'area_de_uso_id');
    }

    
}