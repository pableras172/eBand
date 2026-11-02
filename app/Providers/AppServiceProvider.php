<?php

namespace App\Providers;

use App\Helpers\ConfigHelper;
use App\Models\BandSetting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        View::composer('*', function ($view): void {
            static $bandSettingLoaded = false;
            static $bandSetting = null;

            if (! $bandSettingLoaded) {
                $bandSettingLoaded = true;

                if (Schema::hasTable('band_settings')) {
                    $bandSetting = BandSetting::query()->first();
                }
            }

            $view->with('bandSetting', $bandSetting);
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('superadmin');
        });

        if ($this->app->environment('testing')) {
            $this->loadMigrationsFrom(database_path('migrations/tenant'));
        }
    }
}
