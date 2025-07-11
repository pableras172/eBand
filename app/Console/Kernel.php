<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendDailyCommentsNotification;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\UpdateConfigCache::class,
    ];

    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('notificaciones:enviar-actuaciones')->mondays()->at('16:00');
        $schedule->job(new SendDailyCommentsNotification())->dailyAt('20:00');
        
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
