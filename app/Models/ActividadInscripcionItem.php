<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActividadInscripcionItem extends Model
{
    use HasFactory;

    protected $table = 'actividad_inscripcion_items';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'actividad_inscripcion_id',
        'actividad_opcion_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<ActividadInscripcion, ActividadInscripcionItem>
     */
    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(ActividadInscripcion::class, 'actividad_inscripcion_id');
    }

    /**
     * @return BelongsTo<ActividadOpcion, ActividadInscripcionItem>
     */
    public function opcion(): BelongsTo
    {
        return $this->belongsTo(ActividadOpcion::class, 'actividad_opcion_id');
    }
}
