<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationUserRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if ($event->user->hasRole('manager')) {
            $admin = User::where('id', 1)->first();
            Notification::send($admin, new NewUserNotification($event->user, $event->auth));
        }
        if ($event->user->hasRole('seller')) {
            $users = User::where('role', '!=', 'seller')->get();
            Notification::send($users, new NewUserNotification($event->user, $event->auth));
        }

    }
}
