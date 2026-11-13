<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'totalPago',
        'confirmadausuaroi',
        'paymentresume_id',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fechaPago' => 'datetime',
            'fechaInicio' => 'datetime',
            'fechaFin' => 'datetime',
            'totalPago' => 'decimal:2',
            'confirmadausuaroi' => 'boolean',
            'paymentresume_id' => 'integer',
        ];
    }

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
