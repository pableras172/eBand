<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Mechanisms\HandleRequests\RequireLivewireHeaders;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'web',
])->group(function () {
    // Servicio de archivos aislados por tenant
    Route::get('/storage/{path}', function (string $path) {
        $cleanPath = ltrim($path, '/');
        if (str_contains($cleanPath, '..')) {
            abort(404);
        }

        // 1. Buscar en el storage aislado del tenant actual (storage/tenant{id}/app/public/...)
        $tenantFile = storage_path('app/public/'.$cleanPath);
        if (file_exists($tenantFile) && is_file($tenantFile)) {
            return response()->file($tenantFile, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        // 2. Fallback al storage central si fuera un recurso global
        $centralFile = base_path('storage/app/public/'.$cleanPath);
        if (file_exists($centralFile) && is_file($centralFile)) {
            return response()->file($centralFile, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        abort(404);
    })->where('path', '.*')->name('tenant.storage.asset');

    // Register Livewire's update route inside tenant middleware so tenancy
    // is initialized (and the session resolved) on every Livewire AJAX request.
    Livewire::setUpdateRoute(function ($handle, $path) {
        return Route::post($path, $handle)
            ->middleware([
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
                'web',
                RequireLivewireHeaders::class,
            ])
            ->name('tenant.livewire.update');
    });

    require base_path('routes/web.php');
});
