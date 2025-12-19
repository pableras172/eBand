<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    use HasFactory;

    protected $fillable = [
    'latitude',
    'longitude',
    'poblacion',
    'descripcion', 
    'observacions',
];

    public function actuaciones()
    {
        return $this->hasMany('App\Models\Actuacion');
    }
}
