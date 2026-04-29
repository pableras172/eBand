<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
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
    // Register Livewire's update route inside tenant middleware so tenancy
    // is initialized (and the session resolved) on every Livewire AJAX request.
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });

    require base_path('routes/web.php');
});
