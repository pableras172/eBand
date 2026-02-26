<?php

namespace App\Mail;

use App\Models\Paymentresume;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentresumeDetail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentresume;
    public $descripcion;
    public $fechaPago;
    public $payments;

    /**
     * Create a new message instance.
     */
    public function __construct(Paymentresume $paymentresume)
    {
        $this->paymentresume = $paymentresume;
        $this->descripcion = $paymentresume->descripcion;
        $this->fechaPago = \Carbon\Carbon::parse($paymentresume->created_at)->format('d/m/Y');
        
        // Obtener los pagos relacionados
        $this->payments = $paymentresume->payments()->with('user')->get();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📊 Resumen de Pagos - ' . $this->descripcion
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.paymentresume.detail',
            with: [
                'paymentresume' => $this->paymentresume,
                'descripcion' => $this->descripcion,
                'fechaPago' => $this->fechaPago,
                'payments' => $this->payments,
            ]
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
