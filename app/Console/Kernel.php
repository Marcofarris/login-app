<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use \Datetime;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
           // da mettere in modulo la differenza
             DB::table('orders')->whereRaw('minute(current_timestamp())-minute(created_at) = 1')->whereRaw('second(current_timestamp())-second(created_at) = 0')->whereRaw('id between 0 and 100000')->delete();

            //DB::table('orders')->whereRaw('id between 0 and 100000')->delete();
        })->everySecond();
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
