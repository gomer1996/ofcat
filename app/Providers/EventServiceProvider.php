<?php

namespace App\Providers;

use App\Events\NewOrder;
use App\Listeners\RestoreCartOnLogin;
use App\Listeners\SendOrderConfirmationNotification;
use App\Listeners\StoreCartOnLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrder::class => [
            SendOrderConfirmationNotification::class,
        ],
        Login::class => [
            RestoreCartOnLogin::class
        ],
        Logout::class => [
            StoreCartOnLogout::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
