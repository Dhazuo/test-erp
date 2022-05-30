<?php

namespace App\Listeners;

use App\Events\SaleDeleted;
use App\Models\User;
use App\Notifications\SaleDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationSaleDeleted
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
     * @param  \App\Events\SaleDeleted  $event
     * @return void
     */
    public function handle(SaleDeleted $event)
    {
        $petitioner = User::where('id', $event->seller)->first();
        $token = $event->token;

        Notification::send($petitioner, new SaleDeletedNotification($token));
    }
}
