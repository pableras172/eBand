<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListasUser extends Model
{
    protected $table = 'listas_user';

    protected $fillable = [
        'listas_id',
        'user_id',
        'disponible',
        'duda',
        'payment_id',
        'totalActuacion',
        'totalActo',
        'totalCoche',
        'coche',
        'furgona',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'disponible' => 'boolean',
            'duda' => 'boolean',
            'coche' => 'boolean',
            'furgona' => 'boolean',
            'pagada' => 'boolean',
            'cuentas' => 'boolean',
        ];
    }

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
