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
        Commands\HeartBeat::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('heartbeat:check')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping()
            ->appendOutputTo('/tmp/stdout.log')
        ;

        // https://laravel.com/docs/5.6/horizon#notifications
        $schedule->command('site:create')
            ->everyMinute()
            ->onOneServer()
            ->withoutOverlapping()
            ->appendOutputTo('/tmp/stdout.log')
        ;
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
}
