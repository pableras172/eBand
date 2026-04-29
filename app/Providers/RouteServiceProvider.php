<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            $centralDomains = config('tenancy.central_domains', []);

            if ($centralDomains !== []) {
                $escapedDomains = array_map(
                    static fn (string $domain): string => preg_quote($domain, '/'),
                    $centralDomains,
                );

                Route::middleware('web')
                    ->domain('{central_domain}')
                    ->where([
                        'central_domain' => implode('|', $escapedDomains),
                    ])
                    ->group(base_path('routes/central.php'));
            }
        });
    }
}
