<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();


        $schedule->command(\App\Console\Commands\Crontab\SerializableJobCrontabCommand::class)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping() // 避免任务重复
            ->onOneServer()
        ;

//        $schedule->command(\App\Console\Commands\Crontab\UserCrontabCommand::class)
//            ->everyMinute()
//            ->runInBackground()
//            ->withoutOverlapping() // 避免任务重复
////            ->dailyAt('6:18')
//            ->onOneServer()
//        ;

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/Commands/Crontab');

        require base_path('routes/console.php');
    }
}
