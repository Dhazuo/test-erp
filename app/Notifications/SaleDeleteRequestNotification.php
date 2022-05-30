<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SaleDeleteRequestNotification extends Notification
{
    use Queueable;

    public $sale;
    public $auth;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sale, $auth)
    {
        $this->sale = $sale;
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
            'type' => 'sale_delete_request',
            'auth_id' => $this->auth["id"],
            'auth_name' => $this->auth["name"],
            'id' => $this->sale->id,
            'token' => $this->sale->token,
        ];
    }
}
