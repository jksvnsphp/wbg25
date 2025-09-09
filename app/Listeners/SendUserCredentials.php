<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserCredentials implements ShouldQueue
{
    use InteractsWithQueue;
    public function handle(UserCreated $event): void
    {
        //
        $user = $event->user;
     
        Mail::send('mail.send-credentials', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Credentials from WBG24');
        });
    }
}
