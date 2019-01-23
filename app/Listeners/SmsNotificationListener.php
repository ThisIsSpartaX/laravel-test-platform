<?php

namespace App\Listeners;

use App\Events\SmsNotificationEvent;
use Log;
use Twilio;

class SmsNotificationListener // implements ShouldQueue
{
    public $smsEvent;

    public $service;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        $accountId = config('twilio.twilio.connections.sid');

        $token = config('twilio.twilio.connections.token');

        $fromNumber = config('twilio.twilio.connections.from');

        $this->service = new Twilio($accountId, $accountId, $token, $fromNumber);
    }

    /**
     * @param \App\Events\SmsNotificationEvent $smsEvent
     */
    public function handle(SmsNotificationEvent $smsEvent)
    {
        try {
            $result = $this->service->message($smsEvent->phone, $smsEvent->text);
            Log::info('Message sent to number: ' . $smsEvent->phone);
        } catch (\Exception $e) {
            Log::error('Message not sent to number: ' . $smsEvent->phone);
            die($e->getMessage());
        }

        var_dump($result);
    }
}
