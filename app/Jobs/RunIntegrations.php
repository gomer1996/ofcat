<?php

namespace App\Jobs;

use App\Integrations\Relef\SyncRelefCategories;
use App\Integrations\Relef\SyncRelefProducts;
use App\Integrations\Samson\SyncSamsonCategories;
use App\Integrations\Samson\SyncSamsonProducts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunIntegrations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SyncSamsonCategories)();
        (new SyncSamsonProducts)();

        (new SyncRelefCategories())();
        (new SyncRelefProducts)();
    }
}
