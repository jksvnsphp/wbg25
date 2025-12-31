<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\EmailTemplate;

class MailService
{
    /* =========================================================================
     | 📨 1. USER & ACCOUNT EMAILS
     |=========================================================================*/

     protected function getEmailTemplate($type, array $data = [])
{
    $template = EmailTemplate::where('type', $type)->where('status', 1)->first();

    if (!$template) {
        // fallback subject & view (in case admin didn’t define it)
        return [
            'subject' => ucfirst(str_replace('_', ' ', $type)),
            'body' => view("mails.$type", $data)->render() ?? ''
        ];
    }

    // Replace placeholders like [UserName] or [Link]
    $body = $template->body;
    foreach ($data as $key => $value) {
        $body = str_replace(['[' . $key . ']', '{{' . $key . '}}'], $value, $body);
    }

    return [
        'subject' => $template->subject,
        'body' => $body
    ];
}
    /**
     * Send account verification email after registration.
     */

    public function sendVerificationEmail($user, string $verificationUrl): void
    {
        try {
            $data = [
                'user_name' => $user->first_name ?? $user->name ?? 'User',
                'verification_url' => $verificationUrl,
            ];

            Mail::send('mails.verification-email', $data, function ($message) use ($user) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($user->email)
                        ->subject('Verify Your Email Address!');
            });
        } catch (\Throwable $e) {
            Log::error('sendVerificationEmail failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     | 🧾 2. LISTING CONFIRMATION EMAILS
     |=========================================================================*/

    /**
     * Send listing confirmation for product/tender/news/RFQ.
     */
    public function sendListingConfirmation(array $data): void
    {
        try {
            $template = 'mails.listing-confirmation';
            Mail::send($template, $data, function ($message) use ($data) {
                $subject = match ($data['listing_type'] ?? 'listing') {
                    'product' => 'Your Product Has Been Successfully Listed!',
                    'tender' => 'Your Tender Has Been Published Successfully!',
                    'news' => 'Your News Article Has Been Posted!',
                    'rfq' => 'Your RFQ Has Been Published Successfully!',
                    'multiple' => 'Your Products Are Now Live – Start Connecting!',
                    default => 'Your Listing is Live on WBG24!'
                };
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['email'])->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('sendListingConfirmation failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     | 🚫 3. LIMIT REACHED EMAILS
     |=========================================================================*/

    /**
     * Notify seller that a package limit (product/tender/news) is reached.
     */
    public function sendLimitReachedEmail(array $data): void
    {
        try {
            $template = match ($data['limit_type'] ?? '') {
                'product' => 'mails.limit-product-reached',
                'tender' => 'mails.limit-tender-reached',
                'news' => 'mails.limit-news-reached',
                default => null
            };

            if (!$template) return;

            Mail::send($template, $data, function ($message) use ($data) {
                $subject = match ($data['limit_type'] ?? '') {
                    'product' => "You've Reached Your Product Limit – Upgrade for More Listings!",
                    'tender' => "You've Reached Your Tender Submission Limit – Upgrade Today!",
                    'news' => "You've Reached Your News Posting Limit – Upgrade for More Exposure!",
                    default => 'Limit Reached – Upgrade Your Account'
                };
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['email'])->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('sendLimitReachedEmail failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     | 💼 4. TENDER & RFQ EMAILS
     |=========================================================================*/

    /**
     * Counter Offer (Seller sends, Buyer receives)
     */
    public function sendTenderCounterOfferEmails(array $data): void
    {
        try {
            // Confirmation to Seller
            Mail::send('mails.tender-counter-offer-seller', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['seller']->email)
                        ->subject($data['seller_subject'] ?? 'Your Counter Offer Has Been Sent Successfully!');
            });

            // Notification to Buyer
            Mail::send('mails.tender-counter-offer-buyer', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['buyer']->email)
                        ->subject($data['buyer_subject'] ?? 'New Counter Offer Received for Your Tender/RFQ!');
            });
        } catch (\Throwable $e) {
            Log::error('sendTenderCounterOfferEmails failed: ' . $e->getMessage());
        }
    }

    /**
     * Accepted / Rejected Counter Offer (updates both)
     */
    public function sendTenderCounterOfferUpdate(array $data): void
    {
        try {
            Mail::send('mails.tender-counter-offer-update', $data, function ($message) use ($data) {
                $subject = ($data['status'] ?? 'update') === 'Accepted'
                    ? '✅ Counter Offer Accepted – Tender Deal Confirmed!'
                    : '❌ Counter Offer Rejected – Tender RFQ Update';
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to([$data['buyer']->email, $data['seller']->email])
                        ->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('sendTenderCounterOfferUpdate failed: ' . $e->getMessage());
        }
    }

    /**
     * Tender deal confirmation emails to Buyer & Seller.
     */
    public function sendTenderDealEmails(array $data): void
    {
        try {
            Mail::send('mails.tender-deal-seller', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['seller']->email)
                        ->subject($data['seller_subject'] ?? 'Tender Deal Confirmed – Process Order Now!');
            });

            Mail::send('mails.tender-deal-buyer', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['buyer']->email)
                        ->subject($data['buyer_subject'] ?? 'Tender Deal Confirmed – Next Steps!');
            });

            Mail::send('mails.tender-deal-update', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to([$data['buyer']->email, $data['seller']->email])
                        ->subject($data['both_subject'] ?? 'Deal Confirmed – Tender RFQ Finalized!');
            });
        } catch (\Throwable $e) {
            Log::error('sendTenderDealEmails failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     | 💳 5. ORDER & PAYMENT EMAILS
     |=========================================================================*/

    /**
     * Order confirmation or payment emails to both parties.
     */
    public function sendOrderPaymentEmails(array $data): void
    {
        try {
            // Seller
            Mail::send('mails.order-payment-seller', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['seller']->email)
                        ->subject($data['seller_subject'] ?? 'Order Confirmation!');
            });

            // Buyer
            Mail::send('mails.order-payment-buyer', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['buyer']->email)
                        ->subject($data['buyer_subject'] ?? 'Your Order Has Been Placed!');
            });
        } catch (\Throwable $e) {
            Log::error('sendOrderPaymentEmails failed: ' . $e->getMessage());
        }
    }

    /**
     * Shipment status updates for both Buyer & Seller.
     */
    public function sendOrderShipmentUpdate(array $data): void
    {
        try {
            Mail::send('mails.order-shipment-update', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to([$data['buyer']->email, $data['seller']->email])
                        ->subject($data['subject'] ?? 'Shipment Update – Your Order is on the Way!');
            });
        } catch (\Throwable $e) {
            Log::error('sendOrderShipmentUpdate failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     | 💎 6. MEMBERSHIP & PACKAGE EMAILS
     |=========================================================================*/

    /**
     * Membership expiration or renewal reminders.
     */
    public function sendPackageExpiryEmail(array $data): void
    {
        try {
            $template = match (strtolower($data['package_type'] ?? '')) {
                'silver' => 'mails.package-expire-silver',
                'gold' => 'mails.package-expire-gold',
                'platinum' => 'mails.package-expire-platinum',
                default => 'mails.package-expire-generic'
            };

            $subject = match (strtolower($data['package_type'] ?? '')) {
                'silver' => 'Your Silver Package is Expiring Soon – Renew Now!',
                'gold' => 'Your Gold Package is About to Expire – Renew Today!',
                'platinum' => 'Your Platinum Package is Expiring – Renew Now for Premium Benefits!',
                default => 'Membership Expiration Notice'
            };

            Mail::send($template, $data, function ($message) use ($data, $subject) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['seller']->email)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('sendPackageExpiryEmail failed: ' . $e->getMessage());
        }
    }

    /**
     * Membership upgrade / purchase confirmation.
     */
    public function sendPackageUpgradeConfirmation(array $data): void
    {
        try {
            Mail::send('mails.membership-upgrade-confirmation', $data, function ($message) use ($data) {
                $message->from('no-reply@wbg24.com', 'World Business Guide – WBG24.com');
                $message->to($data['seller']->email)
                        ->subject('Your Membership Has Been Upgraded Successfully!');
            });
        } catch (\Throwable $e) {
            Log::error('sendPackageUpgradeConfirmation failed: ' . $e->getMessage());
        }
    }
}
