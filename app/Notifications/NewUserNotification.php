<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    public $user;
    public $auth;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'user',
            'auth_id' => $this->auth["id"],
            'auth_name' => $this->auth["name"],
            'name' => $this->user->name,
            'role' => $this->user->role,
            'email' => $this->user->email,
        ];
    }
}
