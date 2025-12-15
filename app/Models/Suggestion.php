<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'suggestions';
    public $timestamps = false; // manejamos fecha en 'fechacreacion'

    protected $fillable = [
        'fechacreacion',
        'titulo',
        'texto',
        'observaciones',
        'users_id',
        'anonimo',
    ];

    protected $casts = [
        'fechacreacion' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}
