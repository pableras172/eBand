<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListasUser extends Model
{
    protected $table = "listas_user";   

    protected $fillable = [
        'disponible',
        'payment_id',
        'totalActuacion',
        'totalActo',
        'totalCoche'
    ];

    
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listas()
    {
        return $this->belongsTo(Listas::class);
    }
}
