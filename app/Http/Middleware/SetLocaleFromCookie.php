<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleFromCookie
{
    public function handle($request, Closure $next)
    {
        $locale = $request->cookie('locale');

        if ($locale && in_array($locale, ['ca_VL', 'es'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
