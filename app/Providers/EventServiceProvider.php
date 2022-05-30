<?php

namespace App\Providers;

use App\Events\SaleConserved;
use App\Events\SaleDeleted;
use App\Events\SaleDeleteRequest;
use App\Events\SaleRegistered;
use App\Events\UserRegistered;
use App\Listeners\SendNewUserNotification;
use App\Listeners\SendNotificationSaleConserved;
use App\Listeners\SendNotificationSaleDeleted;
use App\Listeners\SendNotificationSaleDeleteRequest;
use App\Listeners\SendNotificationSaleRegistered;
use App\Listeners\SendNotificationUserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            SendNotificationUserRegistered::class
        ],
        SaleRegistered::class => [
            SendNotificationSaleRegistered::class
        ],
        SaleDeleteRequest::class => [
            SendNotificationSaleDeleteRequest::class
        ],
        SaleDeleted::class => [
            SendNotificationSaleDeleted::class
        ],
        SaleConserved::class => [
            SendNotificationSaleConserved::class
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
