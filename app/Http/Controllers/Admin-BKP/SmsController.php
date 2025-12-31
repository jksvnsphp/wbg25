<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GooglePlacesService;
use App\Services\TwilioService;

class SmsController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function sendTest()
    {
       // die("here");
        $this->twilio->sendSms('+919540972307', 'Hello! This is a test SMS from Laravel + Twilio 🚀');
        return "Message sent!";
    }
}
