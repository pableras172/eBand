<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentresume extends Model
{
    use HasFactory;

    protected $table = 'paymentresume';

    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): float
    {
        if (array_key_exists('payments_sum_total_pago', $this->attributes)) {
            return (float) $this->attributes['payments_sum_total_pago'];
        }

        return (float) $this->payments()->sum('totalPago');
    }
}
