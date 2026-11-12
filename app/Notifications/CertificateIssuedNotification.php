<?php

namespace App\Notifications;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CertificateIssuedNotification extends Notification
{
    use Queueable;

    public Certificate $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate->loadMissing(['event', 'user', 'registration']);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $eventTitle = $this->certificate->event->title ?? 'Kegiatan Laboratorium ICT';
        $certNumber = $this->certificate->certificate_number;

        return (new MailMessage)
            ->subject("E-Sertifikat Telah Terbit: {$eventTitle} - Eventict Lab ICT")
            ->view('emails.certificate-issued', [
                'user' => $notifiable,
                'certificate' => $this->certificate,
                'event' => $this->certificate->event,
                'registration' => $this->certificate->registration,
                'portalUrl' => route('peserta.dashboard', ['tab' => 'sertifikat']),
            ]);
    }
}
