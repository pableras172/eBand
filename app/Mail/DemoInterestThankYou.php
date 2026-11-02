<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoInterestThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $nombre) {}

    /**
     * Create a new message instance.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu acceso demo de eBand ya esta listo',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.demo.interest-thank-you',
            with: [
                'nombre' => $this->nombre,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
