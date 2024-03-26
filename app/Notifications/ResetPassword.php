<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view('mail.mail', ['code' => (string) $this->generateCode($notifiable), 'notifibale' => $notifiable, 'type' => 'password reset']);
    }

    public function generateCode($notifiable)
    {
        $code = mt_rand(100000, 999999);
        Cache::put($notifiable->email, $code, now()->addHour());
        return $code;
    }
}
