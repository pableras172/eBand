<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureReadOnlyDemo
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('demo.read_only')) {
            return $next($request);
        }

        $allowedRoutes = config('demo.read_only_allowed_routes', []);
        $routeName = $request->route()?->getName();

        if ($request->session()->get('demo_mode')
            && ! in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)
            && ! in_array($routeName, $allowedRoutes, true)) {
            if ($request->expectsJson()) {
                abort(403, 'Modo demo: operacion no permitida en solo lectura.');
            }

            return redirect()->back()->with('error', 'Modo demo activo: no se permiten cambios.');
        }

        return $next($request);
    }
}
