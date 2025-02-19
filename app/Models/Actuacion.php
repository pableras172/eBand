<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contratos;
use App\Models\Listas;
use App\Models\Tipoactuacion;

class Actuacion extends Model
{
    use HasFactory;

    public function lista()
    {
        //return $this->hasMany(Listas::class, 'actuacions_id');
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
        return $this->belongsTo(TipoActuacion::class, 'tipoactuacions_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'actuacion_id');
    }


}
