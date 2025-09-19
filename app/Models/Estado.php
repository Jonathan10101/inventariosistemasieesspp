<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipio;


class Estado extends Model
{
    use HasFactory;


    
    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }


}
