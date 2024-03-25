<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contratos;
use App\Models\Listas;

class Actuacion extends Model
{
    use HasFactory;

    public function listas()
    {
        return $this->hasMany(Listas::class, 'actuacions_id');
    }

    public function contrato()
    {
        return $this->belongsTo(Contratos::class, 'contratos_id');
    }
}
