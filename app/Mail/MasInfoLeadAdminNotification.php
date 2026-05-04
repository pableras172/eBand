<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MasInfoLeadAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $tipoSolicitud,
        public string $nombreCompleto,
        public string $emailContacto,
        public string $telefonoContacto,
        public ?string $entidad,
        public ?string $municipio,
        public ?string $mensaje,
        public int $leadId,
        public ?string $ipAddress,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo contacto desde /masinfo',
            replyTo: [$this->emailContacto],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.masinfo.admin-notification',
            with: [
                'tipoSolicitud' => $this->tipoSolicitud,
                'nombreCompleto' => $this->nombreCompleto,
                'emailContacto' => $this->emailContacto,
                'telefonoContacto' => $this->telefonoContacto,
                'entidad' => $this->entidad,
                'municipio' => $this->municipio,
                'mensaje' => $this->mensaje,
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
