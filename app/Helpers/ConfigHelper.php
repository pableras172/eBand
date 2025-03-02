<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ConfigHelper
{
    // Carga todas las configuraciones en caché
    public static function loadConfigurations()
    {
        Cache::rememberForever('app_config', function () {
            return DB::table('configuration')->pluck('value', 'param')->toArray();
        });
    }

    // Obtiene un valor específico desde la caché
    public static function getConfigValue($param, $default = null)
    {
        $config = Cache::get('app_config', []);
        return $config[$param] ?? $default;
    }

    // Reinicia la caché de configuraciones
    public static function refreshConfigurations()
    {
        Cache::forget('app_config');
        self::loadConfigurations();
    }
}
