<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Helpers\ConfigHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        ConfigHelper::loadConfigurations();

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('superadmin');
        });
    }
}
