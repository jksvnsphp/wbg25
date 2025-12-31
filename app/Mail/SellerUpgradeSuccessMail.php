<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerUpgradeSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $packageName;
    public $dashboardUrl;

    public function __construct($user, $packageName, $dashboardUrl)
    {
        $this->user = $user;
        $this->packageName = $packageName;
        $this->dashboardUrl = $dashboardUrl;
    }

    public function build()
    {
        return $this->subject('Your Seller Upgrade is Successful – Start Selling Today!')
                    ->view('mail.seller_upgrade_success');
    }
}
