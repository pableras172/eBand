<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConfigHelper
{
    // Carga todas las configuraciones en caché
    public static function loadConfigurations(): array
    {
        return Cache::rememberForever('app_config', function (): array {
            if (! Schema::hasTable('configuration')) {
                return [];
            }

            return DB::table('configuration')->pluck('value', 'param')->toArray();
        });
    }

    // Obtiene un valor específico desde la caché
    public static function getConfigValue(string $param, mixed $default = null): mixed
    {
        $config = Cache::get('app_config', []);

        return $config[$param] ?? $default;
    }

    // Reinicia la caché de configuraciones
    public static function refreshConfigurations(): void
    {
        Cache::forget('app_config');
        self::loadConfigurations();
    }
}
