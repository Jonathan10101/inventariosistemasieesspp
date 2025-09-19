<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UbicacionFisica extends Model
{
    use HasFactory;
    protected $table = 'ubicacion_fisicas';
    protected $fillable = ['descripcion'];

}
