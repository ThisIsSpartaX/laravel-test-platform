<?php

namespace App\Models\Reservation;

use App\Services\Twilio\TwilioService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\SmsNotificationEvent;

/**
 * Class Reservation
 *
 * @property-read int $id
 * @property   string $first_name
 * @property   string $last_name
 * @property   string $phone
 * @property   string $email
 * @property   int    $children
 * @property   int    $adults
 * @property   string $status
 * @property   Carbon $created_at
 * @property   Carbon $updated_at
 *
 * @package App\Models\Reservation
 */
class Reservation extends Model
{
    protected $table = 'reservations';

    protected static $statuses = [
        'waiting'  => 'Waiting',
        'in_progress' => 'In Progress',
        'prepared' => 'Prepared',
        'seated' => 'Seated'
    ];

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
    ];

    protected $fillable  = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'children',
        'adults',
        'status'
    ];

    public function getTotalGuests()
    {
        return (int)$this->children + (int)$this->adults;
    }

    public function getStatusText()
    {
        return self::$statuses[$this->status];
    }

    public static function getStatusesCodes()
    {
        return array_keys(self::$statuses);
    }

    public static function getStatusesList()
    {
        return self::$statuses;
    }

    public function calculateTotalGuests($children, $adults)
    {
        return $children + $adults;
    }

    protected static function boot()
    {
        parent::boot();

        self::updated(function($model){
            if($model->status == 'prepared') {
                $phone = $model->phone;
                $text = 'Your table is ready, please see your hostes';
                self::sendSMS($phone, $text);
            }
            if($model->status == 'seated') {
                $phone = $model->phone;
                $text = 'Thank you for using our innovative table reservation system';
                self::sendSMS($phone, $text);
            }
        });
    }

    public static function sendSMS($phone, $pushText) {

        $twilio = new TwilioService();

        return $twilio->sendSms($phone, $pushText);

        //\Event::fire(new SmsNotificationEvent('+'.$phone, $pushText));
    }

    public function getAvailableStatuses() {
        $statuses = self::getStatusesList();
        if($this->status == 'waiting') {

        }
        if($this->status == 'in_progress') {
            unset($statuses['waiting']);
        }
        if($this->status == 'prepared') {
            unset($statuses['waiting']);
            unset($statuses['in_progress']);
        }
        if($this->status == 'seated') {
            unset($statuses['prepared']);
            unset($statuses['in_progress']);
            unset($statuses['waiting']);
        }
        return $statuses;
    }
}