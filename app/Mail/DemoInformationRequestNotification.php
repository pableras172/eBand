<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoInformationRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nombreApellidos,
        public string $emailContacto,
        public string $telefonoContacto,
        public ?string $nombreBanda,
        public ?int $numeroMusicos,
        public string $notas,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de informacion desde modo demo',
            replyTo: [$this->emailContacto],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.demo.information-request-notification',
            with: [
                'nombreApellidos' => $this->nombreApellidos,
                'emailContacto' => $this->emailContacto,
                'telefonoContacto' => $this->telefonoContacto,
                'nombreBanda' => $this->nombreBanda,
                'numeroMusicos' => $this->numeroMusicos,
                'notas' => $this->notas,
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
