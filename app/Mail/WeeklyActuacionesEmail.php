<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class WeeklyActuacionesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $actuaciones;
    public $fechaInicio;
    public $fechaFin;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $actuaciones, string $fechaInicio, string $fechaFin, string $userName = '')
    {
        $this->actuaciones = $actuaciones;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 Planning semanal  - ' . config('app.banda')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.actuaciones.weekly-summary',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
