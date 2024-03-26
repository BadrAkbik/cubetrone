<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class VerifyEmail extends Notification
{
    use Queueable;

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->view('mail.mail', ['code' => (string) $this->generateCode($notifiable), 'notifibale' => $notifiable, 'type' => 'email verification']);
    }


    public function generateCode($notifiable)
    {
        $code = mt_rand(100000, 999999);
        Cache::put($notifiable->email, $code, now()->addHour());
        return $code;
    }
}
