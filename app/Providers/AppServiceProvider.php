<?php

namespace App\Providers;

use App\Integrations\Samson\SyncSamsonProducts;
use App\Jobs\ImportProductsJob;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(ImportProductsJob::class, function ($app) {
//            return new ImportProductsJob($app->make(SyncSamsonProducts::class));
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
