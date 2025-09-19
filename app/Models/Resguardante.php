<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resguardante extends Model
{
    use HasFactory;
    protected $table  = "resguardantes";
    protected $fillable = ['nombre1','nombre2','apellido1','apellido2'];

}
