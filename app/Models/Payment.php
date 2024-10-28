<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'users_id',
        'fechaPago',
        'descripcion',
        'fechaInicio',
        'fechaFin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function listasUsers()
    {
        return $this->hasMany(ListasUser::class);
    }

    public function paymentresume()
    {
        return $this->belongsTo(Paymentresume::class);
    }
}
