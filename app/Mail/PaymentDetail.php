<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentDetail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $userName;
    public $actuacionNombre;
    public $importe;
    public $observaciones;
    public $listasUsers;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->userName = $payment->user->name;
        $this->actuacionNombre = $payment->descripcion;
        $this->importe = number_format($payment->totalPago, 2, ',', '.');
        $this->observaciones = $payment->observaciones;
        
        // Obtener las actuaciones pagadas (ListasUser)
        $this->listasUsers = \App\Models\ListasUser::where('payment_id', $payment->id)
            ->join('listas', 'listas_user.listas_id', '=', 'listas.id')
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->select('listas_user.*', 'actuacions.fechaActuacion', 'actuacions.descripcion as actuacion_nombre')
            ->orderBy('actuacions.fechaActuacion', 'asc')
            ->get();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💰 Detalle de Pago - ' . $this->actuacionNombre
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.payment.detail',
            with: [
                'payment' => $this->payment,
                'userName' => $this->userName,
                'actuacionNombre' => $this->actuacionNombre,
                'importe' => $this->importe,
                'observaciones' => $this->observaciones,
                'listasUsers' => $this->listasUsers,
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
