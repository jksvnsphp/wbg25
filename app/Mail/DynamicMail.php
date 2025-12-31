<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $body;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectText, $body)
    {
        $this->subjectText = $subjectText;
        $this->body = $body;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.dynamic-template')
                    ->with([
                        'body' => $this->body
                    ]);
    }
}
    