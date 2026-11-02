<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoInterestAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nombreCompleto,
        public string $email,
        public int $leadId,
        public ?string $ipAddress,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo interesado en demo de eBand',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.demo.admin-interest-notification',
            with: [
                'nombreCompleto' => $this->nombreCompleto,
                'email' => $this->email,
                'leadId' => $this->leadId,
                'ipAddress' => $this->ipAddress,
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
