<?php

namespace App\Models\Reservation;

use App\Services\Twilio\TwilioService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\SmsNotificationEvent;

/**
 * Class ReservationLog
 *
 * @property-read int $id
 * @property   string $reservation_id
 * @property   string $user_id
 * @property   string $text
 * @property   Carbon $created_at
 * @property   Carbon $updated_at
 *
 * @package App\Models\Reservation
 */
class ReservationLog extends Model
{
    protected $table = 'reservation_log';

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
    ];
}