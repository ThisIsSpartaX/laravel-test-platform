<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SmsNotificationEvent extends Event
{
    use SerializesModels;

    public $phone;
    public $text;

    /**
     * @param $phone
     * @param $text
     * Create a new event instance.
     */
    public function __construct($phone, $text)
    {
        $this->phone = $phone;
        $this->text = $text;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
