<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Template;
use App\Models\User;

class Bienvenida extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public Template $template)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.bienvenida',
            with: [
                'has_cta' => $this->template->has_cta,
                'button_link' => $this->template->button_link,
                'button_text' => $this->template->button_text,
                'title' => $this->template->title,
                'subject'  => $this->template->subject,
                'intro'  => $this->template->intro,
                'content_1' => $this->template->content_1,
                'content_2' => $this->template->content_2,
                'content_3' => $this->template->content_3
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
