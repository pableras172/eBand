<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'orden',
        'icon',
    ];

    public const DEFAULT_ICON_PATH = 'images/defaults/instrument-default.svg';

    public function getIconUrlAttribute(): string
    {
        return static::resolveIconUrl($this->icon);
    }

    public static function resolveIconUrl(?string $icon): string
    {
        if (filled($icon)) {
            return asset('storage/imagenes/instruments/'.ltrim($icon, '/'));
        }

        return asset(self::DEFAULT_ICON_PATH);
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
