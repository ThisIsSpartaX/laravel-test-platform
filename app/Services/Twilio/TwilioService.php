<?php

namespace App\Services\Twilio;

use App\Events\SmsNotificationEvent;
use Log;

class TwilioService // implements ShouldQueue
{
    public $smsEvent;

    public $service;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        $accountId = config('twilio.twilio.connections.twilio.sid');

        $token = config('twilio.twilio.connections.twilio.token');

        $fromNumber = config('twilio.twilio.connections.twilio.from');

        $this->service = new \Aloha\Twilio\Twilio($accountId, $token, $fromNumber);
    }

    public function sendSms($phone, $text)
    {
        try {
            $result = $this->service->message($phone, $text);
            Log::info('Message sent to number: ' . $phone);
        } catch (\Exception $e) {
            Log::error('Message not sent to number: ' . $phone);
            die($e->getMessage());
        }

        if($result->status == 'queued') {
            return true;
        }
    }
}
