<?php

namespace App\Console;

use App\Jobs\SyncRelefCategoriesJob;
use App\Jobs\SyncRelefProductsJob;
use App\Jobs\SyncSamsonCategoriesJob;
use App\Jobs\SyncSamsonProductsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Nova\Trix\PruneStaleAttachments;

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
        $schedule->call(function () {
            (new PruneStaleAttachments)();
        })->daily();

        $schedule->call(function () {
          //SyncSamsonCategoriesJob::dispatch(); we dont sync categories anymore since august 2023

          SyncSamsonProductsJob::dispatch();

          //SyncRelefCategoriesJob::dispatch(); we dont sync categories anymore since august

          SyncRelefProductsJob::dispatch();
        })->dailyAt('03:00');
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
