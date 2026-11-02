<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActividadOpcion extends Model
{
    use HasFactory;

    protected $table = 'actividad_opciones';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'actividad_id',
        'titulo',
        'descripcion',
        'precio',
        'orden',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'orden' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Actividad, ActividadOpcion>
     */
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    /**
     * @return HasMany<ActividadInscripcionItem>
     */
    public function inscripcionItems(): HasMany
    {
        return $this->hasMany(ActividadInscripcionItem::class, 'actividad_opcion_id');
    }
}
