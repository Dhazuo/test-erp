<?php

namespace App\Listeners;

use App\Events\SaleConserved;
use App\Models\User;
use App\Notifications\SaleConservedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationSaleConserved
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
     * @param  \App\Events\SaleConserved  $event
     * @return void
     */
    public function handle(SaleConserved $event)
    {
        $petitioner = User::where('id', $event->auth)->first();

        Notification::send($petitioner, new SaleConservedNotification($event->sale));
    }
}
