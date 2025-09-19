<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre1', 'nombre2', 'apellido1', 'apellido2'
    ];
}
