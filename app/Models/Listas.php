<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{
    use HasFactory;
   
    public function actuacion()
    {
        return $this->belongsTo(Actuacion::class, 'actuacions_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('coche', 'pagada', 'cuentas','disponible'); // También puedes incluir timestamps si los tienes en la tabla pivot
    }
}
