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
            if ($view->offsetExists('bandSetting') && $view->offsetGet('bandSetting') !== null) {
                return;
            }

            static $bandSetting = null;
            static $bandSettingLoadedForTenant = null;

            $currentTenantId = function_exists('tenant') && tenant() ? tenant('id') : 'central';

            if ($bandSettingLoadedForTenant !== $currentTenantId) {
                $bandSettingLoadedForTenant = $currentTenantId;

                try {
                    $bandSetting = Schema::hasTable('band_settings')
                        ? (BandSetting::query()->first() ?? new BandSetting(['activarcontactoinfo' => false]))
                        : new BandSetting(['activarcontactoinfo' => false]);
                } catch (\Throwable) {
                    $bandSetting = new BandSetting(['activarcontactoinfo' => false]);
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
