<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CustomResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Notification delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // Build password reset URL
        $resetUrl = url('/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email));

        // Get template from DB
        $template = DB::table('email_templates')->where('type', 'Reset Your Password')->first();

        if (!$template) {
            // fallback in case template missing
            return (new MailMessage)
                ->subject('Reset Your Password')
                ->line('We received a request to reset your password.')
                ->action('Reset Password', $resetUrl);
        }

        // Replace placeholders inside template body
       $body = str_replace(
    [
        '[User’s Name]',
        '🔗 Reset Password',
        '[Timeframe]',
        '[CompanyName]',
    ],
    [
        $notifiable->first_name ?? 'User',
        '<a href="' . $resetUrl . '">Reset Password</a>',
        '60 minutes',
        config('app.name'),
    ],
    $template->body
);


        // Build and return email
        return (new MailMessage)
            ->subject($template->subject)
            ->view('emails.dynamic-template', [
                'body' => $body
            ]);
    }
}
