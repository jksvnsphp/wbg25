<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerProfileUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $company;

    public function __construct($user, $company)
    {
        $this->user = $user;
        $this->company = $company;
    }

    public function build()
    {
        return $this->subject('Your Profile Has Been Successfully Updated')
            ->view('mails.seller_profile_updated');
    }
}
