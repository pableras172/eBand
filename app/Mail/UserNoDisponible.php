<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Actuacion;

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
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.users.nodisponible',
            with: [
                'url' => config('app.url').'/listas/actuacion/'.$this->actuacion->id,
                'username'=>$this->user->name,
                'actuacio'=>$this->actuacion,
                'customText' => $this->customText, // Pasar el nuevo campo de texto a la plantilla de correo
            ],
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
