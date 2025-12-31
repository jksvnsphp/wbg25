<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $resetUrl;
    public $expiresMinutes;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string $token
     */
    public function __construct($user, string $token)
    {
        $this->user = $user;
        $this->token = $token;

        // Build the reset URL (uses the named route 'password.reset' provided by Laravel's auth scaffolding)
        $this->resetUrl = route('password.reset', ['token' => $this->token, 'email' => $this->user->email]);

        // Read expiry from auth config (minutes)
        $passwordsConfig = config('auth.defaults.passwords', 'users');
        $this->expiresMinutes = config("auth.passwords.{$passwordsConfig}.expire", 60);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Reset Your Password – WBG24.com')
            ->view('emails.password_reset')      // HTML view
            ->text('emails.password_reset_plain')// Plain-text fallback
            ->with([
                'user' => $this->user,
                'resetUrl' => $this->resetUrl,
                'expiresMinutes' => $this->expiresMinutes,
            ]);
    }
}
