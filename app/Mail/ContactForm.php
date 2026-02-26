<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $banda;
    public $telefono;
    public $email;
    public $informacion;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $banda, $telefono, $email, $informacion)
    {
        $this->nombre = $nombre;
        $this->banda = $banda;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->informacion = $informacion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Nuevo contacto desde eBand - ' . $this->banda,
            replyTo: [$this->email]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact.form',
            with: [
                'nombre' => $this->nombre,
                'banda' => $this->banda,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'informacion' => $this->informacion,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
