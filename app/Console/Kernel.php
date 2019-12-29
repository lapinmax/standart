<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('push:send')->hourlyAt(0);
        $schedule->command('check:horoscopes')->at('00:00');
        $schedule->command('check:horoscopes')->at('12:00');
        $schedule->command('check:horoscopes')->at('23:00');
        $schedule->command('check:horoscopes')->at('23:45');
        $schedule->command('rules:start')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleTimezone () {
        return 'America/New_York';
    }
}
