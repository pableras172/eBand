<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUserRegistration extends Mailable
{
    use Queueable, SerializesModels;
    

    /**
     * Create a new message instance.
     */
    public function __construct(

        public User $user,

    ) {}

    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from')['address'], config('mail.from')['name']),
            subject: 'Nuevo usuario en '.config('app.banda'),
        );
    }*/

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.users.newuser',
            with: [
                'url' => config('app.url').'\/users\/'.$this->user->id.'/edit',
                'username'=>$this->user->name,
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
