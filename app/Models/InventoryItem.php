<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_category_id',
        'year',
        'nombre',
        'cantidad',
        'valor_unitario',
        'estado',
        'observaciones',
        'depreciation_rate',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'cantidad' => 'integer',
        'valor_unitario' => 'decimal:2',
        'depreciation_rate' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function responsables(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inventory_item_user')
            ->withPivot('asignado_en');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function getValorTotalAttribute(): float
    {
        return $this->cantidad * $this->valor_unitario;
    }

    public function getValorResidualAttribute(): float
    {
        if (! $this->purchase_date) {
            return $this->valor_total;
        }

        $years = now()->diffInYears($this->purchase_date);
        $depreciation = $this->valor_total * ($this->depreciation_rate / 100) * $years;

        return max(0, $this->valor_total - $depreciation);
    }
}
