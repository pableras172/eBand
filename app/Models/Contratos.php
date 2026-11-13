<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contratos extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'poblacion',
        'fechainicio',
        'fechafin',
        'descripcion',
        'contacto',
        'telefono',
        'correo',
        'anyo',
        'dnicontacto',
        'observacions',
    ];

    public function actuaciones(): HasMany
    {
        return $this->hasMany(Actuacion::class, 'contratos_id');
    }
}
