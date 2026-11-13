<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listas extends Model
{
    use HasFactory;

    protected $fillable = [
        'actuacions_id',
        'pagada',
        'cuentas',
    ];

    public function actuacion(): BelongsTo
    {
        return $this->belongsTo(Actuacion::class, 'actuacions_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('coche', 'pagada', 'cuentas', 'disponible', 'duda', 'furgona');
    }

    public function listasUsers(): HasMany
    {
        return $this->hasMany(ListasUser::class, 'listas_id');
    }
}
