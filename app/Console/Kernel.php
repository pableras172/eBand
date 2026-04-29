<?php

namespace App\Console;

use App\Console\Commands\Tenancy\CreateTenantCommand;
use App\Console\Commands\UpdateConfigCache;
use App\Jobs\SendDailyCommentsNotification;
use App\Models\Tenant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateConfigCache::class,
        CreateTenantCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function (): void {
            Tenant::query()->get()->each(function (Tenant $tenant): void {
                $tenant->run(function (): void {
                    Artisan::call('notificaciones:enviar-actuaciones');
                });
            });
        })->mondays()->at('16:00');

        $schedule->call(function (): void {
            Tenant::query()->get()->each(function (Tenant $tenant): void {
                $tenant->run(function (): void {
                    dispatch(new SendDailyCommentsNotification);
                });
            });
        })->dailyAt('20:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

    }
}
