<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoactuacion extends Model
{
    use HasFactory;

    public const DEFAULT_ICON_PATH = 'images/defaults/tipoactuacion-default.svg';

    public function getIconUrlAttribute(): string
    {
        return static::resolveIconUrl($this->icon);
    }

    public static function resolveIconUrl(?string $icon): string
    {
        if (filled($icon)) {
            return asset('storage/imagenes/tipoactuacion/'.ltrim($icon, '/'));
        }

        return asset(self::DEFAULT_ICON_PATH);
    }
}
