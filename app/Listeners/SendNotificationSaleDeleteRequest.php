<?php

namespace App\Listeners;

use App\Events\SaleDeleteRequest;
use App\Models\User;
use App\Notifications\SaleDeleteRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationSaleDeleteRequest
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
     * @param  \App\Events\SaleDeleteRequest  $event
     * @return void
     */
    public function handle(SaleDeleteRequest $event)
    {
        $users = User::where('role', '!=', 'seller')->get();

        Notification::send($users, new SaleDeleteRequestNotification($event->sale, $event->auth));
    }
}
