<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'titulo',
        'tipo',
        'descripcion',
        'lugar',
        'fecha',
        'fecha_limite_inscripcion',
        'estado',
        'instrucciones_pago',
        'notified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'fecha_limite_inscripcion' => 'datetime',
            'notified_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<ActividadOpcion>
     */
    public function opciones(): HasMany
    {
        return $this->hasMany(ActividadOpcion::class, 'actividad_id')->orderBy('orden')->orderBy('id');
    }

    /**
     * @return HasMany<ActividadInscripcion>
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(ActividadInscripcion::class, 'actividad_id');
    }

    /**
     * Scope para filtrar actividades abiertas para inscripción.
     *
     * @param  Builder<Actividad>  $query
     */
    public function scopeAbiertas(Builder $query): void
    {
        $query->where('estado', 'abierta');
    }

    /**
     * Determina si la actividad admite inscripciones actualmente.
     */
    public function puedeInscribirse(): bool
    {
        return $this->estado === 'abierta' && Carbon::now()->lessThanOrEqualTo($this->fecha_limite_inscripcion);
    }

    /**
     * Devuelve el icono / emoji representativo según el tipo.
     */
    public function getIconoAttribute(): string
    {
        return match ($this->tipo) {
            'comida' => '🍽️',
            'cena' => '🍷',
            'excursion' => '🚌',
            default => '🎉',
        };
    }

    /**
     * Comprueba si el tipo de actividad requiere campo de alergias/observaciones.
     */
    public function requiereAlergias(): bool
    {
        return in_array($this->tipo, ['comida', 'cena'], true);
    }
}
