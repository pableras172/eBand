<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{
    use HasFactory;

    protected $fillable = [
        'actuacions_id',
        'pagada',
        'cuentas',
    ];

    public function actuacion()
    {
        return $this->belongsTo(Actuacion::class, 'actuacions_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('coche', 'pagada', 'cuentas', 'disponible', 'duda', 'furgona');
    }
}
