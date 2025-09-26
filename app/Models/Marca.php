<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resguardo;


class Marca extends Model
{
    use HasFactory;
    protected $table  = "marcas";
    protected $fillable = ['nombre'];

    public function setAttribute($key, $value)
    {
        // Si el atributo es fillable y es string, lo convierte en mayúsculas
        if (in_array($key, $this->fillable) && is_string($value)) {
            $value = strtoupper($value);
        }
        return parent::setAttribute($key, $value);
    }

    
    public function resguardos()
    {
        return $this->hasMany(Resguardo::class);
    }

}
