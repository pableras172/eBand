<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActividadInscripcion extends Model
{
    use HasFactory;

    protected $table = 'actividad_inscripciones';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'actividad_id',
        'user_id',
        'nombre_manual',
        'asiste',
        'fecha_inscripcion',
        'total',
        'observaciones_alergias',
        'pagado',
        'metodo_pago',
        'fecha_pago',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'asiste' => 'boolean',
            'fecha_inscripcion' => 'datetime',
            'fecha_pago' => 'datetime',
            'total' => 'decimal:2',
            'pagado' => 'boolean',
        ];
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->user ? $this->user->name : ($this->nombre_manual ?: 'Invitado / Asistente');
    }

    /**
     * @return BelongsTo<Actividad, ActividadInscripcion>
     */
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    /**
     * @return BelongsTo<User, ActividadInscripcion>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany<ActividadInscripcionItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(ActividadInscripcionItem::class, 'actividad_inscripcion_id');
    }
}
