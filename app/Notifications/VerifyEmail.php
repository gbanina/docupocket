<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Potvrdi svoju email adresu')
            ->view('emails.verify-email', [
                'url' => $this->verificationUrl($notifiable),
                'notifiable' => $notifiable,
                'appName' => config('app.name', 'DocuPocket'),
            ]);
    }
}
