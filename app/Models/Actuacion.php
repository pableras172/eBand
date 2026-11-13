<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Actuacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fechaActuacion',
        'descripcion',
        'tipoactuacions_id',
        'coches',
        'preciocoche',
        'musicos',
        'preciomusico',
        'totalcoches',
        'totalmusicos',
        'totalactuacion',
        'contratos_id',
        'pagado',
        'aplicaporcentaje',
        'noaplicapago',
        'observaciones',
        'porcentajepersonal',
        'is_draft',
        'furgonas',
        'preciofurgona',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function ($actuacion) {
            if (! $actuacion->lista()->exists()) {
                $actuacion->lista()->create([
                    'pagada' => 0,
                    'cuentas' => 0,
                ]);
            }
        });
    }

    public function lista(): HasOne
    {
        return $this->hasOne(Listas::class, 'actuacions_id');
    }

    public function listas(): HasMany
    {
        return $this->hasMany(Listas::class, 'actuacions_id');
    }

    public function contrato(): BelongsTo
    {
        return $this->belongsTo(Contratos::class, 'contratos_id');
    }

    public function tipoactuacion(): BelongsTo
    {
        return $this->belongsTo(Tipoactuacion::class, 'tipoactuacions_id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipoactuacion::class, 'tipoactuacions_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'actuacion_id');
    }
}
