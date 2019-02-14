<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        $installer = resolve('installer');

        if($installer->installed()){
            $schedule->command('trades:cancel')->everyMinute()->withoutOverlapping();

            if(config()->get('currency.api_key')){
                $schedule->command('currency:update --openexchangerates')->hourly();
            }

            $schedule->command('presence:update')->everyMinute()->withoutOverlapping();

            $schedule->command('users:deactivate')->everyMinute()->withoutOverlapping();

            $schedule->command('users:delete')->everyMinute()->withoutOverlapping();
        }

        $schedule->call(function(){
            Cache::forever('cron.timestamp', now());
        })->everyMinute();
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
