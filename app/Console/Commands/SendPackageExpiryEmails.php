<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\seller_package;
use Carbon\Carbon;

class SendPackageExpiryEmails extends Command
{
    protected $signature = 'packages:notify-expiry';
    protected $description = 'Send reminder emails to sellers before their packages expire.';

    public function handle()
    {
        $expiringPackages = seller_package::with('seller', 'package')
            ->whereNotNull('expire_at')
            ->whereDate('expire_at', '<=', Carbon::now()->addDays(7))
            ->where('payment_status', 'paid')
            ->get();

        foreach ($expiringPackages as $package) {
            $seller = $package->seller;
            $pkg = strtolower($package->package->type ?? '');

            $data = [
                'seller_name' => $seller->first_name,
                'expiry_date' => Carbon::parse($package->expire_at)->format('d M Y'),
                'renewal_link' => route('seller.upgrade.member.package'),
            ];

            $template = match ($pkg) {
                'silver' => 'mails.package-expire-silver',
                'gold' => 'mails.package-expire-gold',
                'platinum' => 'mails.package-expire-platinum',
                default => null,
            };

            if ($template) {
                Mail::send($template, $data, function ($message) use ($seller, $pkg) {
                    $subject = match ($pkg) {
                        'silver' => 'Your Silver Package is Expiring Soon – Renew Now!',
                        'gold' => 'Your Gold Package is About to Expire – Renew Today!',
                        'platinum' => 'Your Platinum Package is Expiring – Renew Now for Premium Benefits!',
                        default => 'Membership Expiration Notice',
                    };
                    $message->to($seller->email)
                        ->subject($subject);
                });

                $this->info("Expiry email sent to {$seller->email} ({$pkg})");
            }
        }

        $this->info('All expiring package notifications sent successfully.');
    }
}
