<?php

namespace App\Mail;

use App\Models\Actuacion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserNoDisponible extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $actuacion;

    public $customText;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Actuacion $actuacion, $customText)
    {
        $this->user = $user;
        $this->actuacion = $actuacion;
        $this->customText = $customText;
    }

    /**
     * Get the message envelope with custom subject.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎯 Notificación de disponibilidad del usuario ' . $this->user->name
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.users.nodisponible',
            with: [
                'url' => config('app.url').'/listas/actuacion/'.$this->actuacion->id,
                'username' => $this->user->name,
                'actuacio' => $this->actuacion,
                'customText' => $this->customText,
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
