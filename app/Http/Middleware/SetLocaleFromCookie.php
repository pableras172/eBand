<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleFromCookie
{
    public function handle($request, Closure $next)
    {
        // Obtener el valor de la cookie de preferencia de idioma
        $locale = $request->cookie('locale');

        // Establecer el idioma de la aplicación si la cookie está presente
        if ($locale && in_array($locale, ['ca_VL', 'es'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
