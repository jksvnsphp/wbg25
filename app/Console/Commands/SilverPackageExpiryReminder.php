<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicMail;
use Carbon\Carbon;

class SilverPackageExpiryReminder extends Command
{
    protected $signature = 'notify:seller-package-expiry';

    protected $description = 'Notify sellers when their package is about to expire';

    public function handle()
    {
        $daysBefore = 5; // notify 5 days before expiry
        $targetDate = Carbon::now()->addDays($daysBefore)->format('Y-m-d');

        // Fetch sellers whose package expires on target date
       $packages = DB::table('seller_packages')
    ->join('users', 'users.id', '=', 'seller_packages.seller_id')
    ->join('member_packages', 'member_packages.id', '=', 'seller_packages.package_id')
   /// ->where('member_packages.type', 'silver')  // only silver packages
    ->where('seller_packages.payment_status', 'paid')
    ->whereDate('seller_packages.expire_at', $targetDate)
    ->select(
        'users.name',
        'users.email',
        'users.id as seller_id',
        'seller_packages.expire_at',
        'seller_packages.id as package_record_id',
        'member_packages.type as package_type',
        'member_packages.name as package_name',
        'member_packages.price as package_price',
        'member_packages.validDays'
    )
    ->get();


        if ($packages->isEmpty()) {
            $this->info('No expiring packages today.');
            return;
        }

        

        foreach ($packages as $row) {

            // Build Renewal Payment Link
            // Example: /renew-package/{seller_id}/{package_record_id}
           
            // Load email template
            if ($row->package_type == 'silver') {
                $template = DB::table('email_templates')->where('type', 'Silver Package is Expiring')->first();
            }else if ($row->package_type == 'gold') {
                $template = DB::table('email_templates')->where('type', 'Gold Package Expiration')->first();
            } else if ($row->package_type == 'platinum') {
                $template = DB::table('email_templates')->where('type', 'Platinum Package Expiration Notice')->first();
            } else if ($row->package_type == 'bronce') {
                $template = DB::table('email_templates')->where('type', 'Silver Package is Expiring')->first();
            } else {
                continue; // skip if package type is unrecognized
            }

           // $template = DB::table('email_templates')->where('type', 'Seller Package Expiry Reminder')->first();
            if (!$template) { 
                  $this->info('Email template "Seller Package Expiry Reminder" not found.');
               // return;
            }

            $paymentLink = url('/renew-package/' . $row->seller_id . '/' . $row->package_record_id);

            // Replace placeholders
            $body = str_replace(
                [
                    '[Seller’s Name]',
                    '[Expiration Date]',
                    '[Insert Payment Link]'
                ],
                [
                    $row->name,
                    Carbon::parse($row->expire_at)->format('d M, Y'),
                    '<a href="' . $paymentLink . '">Renew Now</a>'
                ],
                $template->body
            );

            // Send the email
            Mail::to($row->email)->send(
                new DynamicMail($template->subject, $body)
            );
        }

        $this->info('Seller package expiry reminder emails sent successfully.');
    }
}
