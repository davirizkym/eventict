<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketIssuedNotification extends Notification
{
    use Queueable;

    public Registration $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration->loadMissing(['event', 'user']);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $eventTitle = $this->registration->event->title ?? 'Kegiatan Eventict';
        $ticketCode = $this->registration->registration_code;

        return (new MailMessage)
            ->subject("E-Tiket Resmi Terbit: {$eventTitle} ({$ticketCode}) - Eventict Lab ICT")
            ->view('emails.ticket-issued', [
                'user' => $notifiable,
                'registration' => $this->registration,
                'event' => $this->registration->event,
                'portalUrl' => route('peserta.dashboard', ['tab' => 'tiket']),
            ]);
    }
}
