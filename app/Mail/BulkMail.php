<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BulkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $attachment;

    public function __construct($subject, $message, $attachment = null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->attachment = $attachment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }
   
    public function content(): Content
    {
        return new Content(
            view: 'mail.bulk', 
            with: ['messageContent' => $this->message]
        );
    }

   
    public function attachments(): array
    {
        if ($this->attachment) {
            return [
                Attachment::fromPath($this->attachment->getRealPath())
                    ->as($this->attachment->getClientOriginalName())
                    ->withMime($this->attachment->getMimeType()),
            ];
        }
        return [];
    }
}
