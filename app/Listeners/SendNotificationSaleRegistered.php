<?php

namespace App\Listeners;

use App\Events\SaleRegistered;
use App\Models\User;
use App\Notifications\NewSaleNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationSaleRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SaleRegistered  $event
     * @return void
     */
    public function handle(SaleRegistered $event)
    {
        $users = User::where('role', '!=', 'seller')->get();
        Notification::send($users, new NewSaleNotification($event->sale, $event->auth));
    }
}
