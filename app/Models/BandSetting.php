<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BandSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'nif_cif',
        'telefono',
        'email',
        'website',
        'logo',
        'iduserpresidente',
        'urlinstagram',
        'urlfacebook',
        'urltiktok',
        'activarcontactoinfo',
        'qr_contacto_masinfo',
    ];

    protected $attributes = [
        'activarcontactoinfo' => false,
    ];

    protected $casts = [
        'activarcontactoinfo' => 'boolean',
    ];

    public function presidente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduserpresidente');
    }
}
