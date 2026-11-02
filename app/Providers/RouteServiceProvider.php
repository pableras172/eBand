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

        RateLimiter::for('demo-access', function (Request $request) {
            return Limit::perMinute(5)->by((string) $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            if ($this->app->environment('testing')) {
                Route::middleware('web')
                    ->group(base_path('routes/central.php'));

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));

                return;
            }

            $centralDomains = config('tenancy.central_domains', []);
            $primaryDomain = $centralDomains[0] ?? (parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost');

            Route::middleware('web')
                ->domain($primaryDomain)
                ->group(base_path('routes/central.php'));

            foreach (array_slice($centralDomains, 1) as $additionalDomain) {
                Route::middleware('web')
                    ->domain($additionalDomain)
                    ->group(function () use ($primaryDomain) {
                        Route::fallback(function () use ($primaryDomain) {
                            return redirect()->to((request()->isSecure() ? 'https://' : 'http://').$primaryDomain.request()->getRequestUri());
                        });
                    });
            }
        });
    }
}
