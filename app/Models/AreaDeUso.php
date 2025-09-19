<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaDeUso extends Model
{
    use HasFactory;
    protected $table = "area_de_uso";
    protected $fillable = ['nombre'];
}
