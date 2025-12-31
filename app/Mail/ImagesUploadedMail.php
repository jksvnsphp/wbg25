<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImagesUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $uploadedImagesCount;

    public function __construct($user, $uploadedImagesCount)
    {
        $this->user = $user;
        $this->uploadedImagesCount = $uploadedImagesCount;
    }

    public function build()
    {
        return $this->subject('Your Images Have Been Successfully Uploaded')
                    ->view('mail.images_uploaded');
    }
}
