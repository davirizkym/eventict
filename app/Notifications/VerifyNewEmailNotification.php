<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyNewEmailNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $newEmail
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = URL::temporarySignedRoute(
            'profile.email.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $this->user->id,
                'hash' => sha1($this->newEmail),
            ]
        );

        return (new MailMessage)
            ->subject('Konfirmasi Perubahan Alamat Email - Eventict Lab ICT')
            ->view('emails.verify-new-email', [
                'user' => $this->user,
                'newEmail' => $this->newEmail,
                'url' => $verificationUrl,
            ]);
    }
}
