<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actuacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fechaActuacion',
        'descripcion',
        'tipoactuacions_id',
        'coches',
        'preciocoche',
        'musicos',
        'preciomusico',
        'totalcoches',
        'totalmusicos',
        'totalactuacion',
        'contratos_id',
        'pagado',
        'aplicaporcentaje',
        'noaplicapago',
        'observaciones',
        'porcentajepersonal',
        'is_draft',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public function lista()
    {
        // return $this->hasMany(Listas::class, 'actuacions_id');
        return $this->hasOne(Listas::class, 'actuacions_id');
    }

    public function contrato()
    {
        return $this->belongsTo(Contratos::class, 'contratos_id');
    }

    public function tipoactuacion()
    {
        return $this->belongsTo(Tipoactuacion::class, 'tipoactuacions_id');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipoactuacion::class, 'tipoactuacions_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'actuacion_id');
    }
}
