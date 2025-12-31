<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBulkMail extends Mailable
{
     public $subjectText;
    public $body;

    public function __construct($subjectText, $body)
    {
        $this->subjectText = $subjectText;
        $this->body = $body;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('mail.bulk-mail')
                    ->with([
                        'body' => $this->body,
                    ]);
    }
}
