<?php

namespace App\Models\Order;

use App\Models\Partner\Partner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property-read  int    $id
 * @property  int    $status
 * @property  string $client_email
 * @property  int    $partner_id
 * @property  Carbon $delivery_dt
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\Order
 */
class Order extends Model
{
    protected $table     = 'orders';

    protected static $statuses = [
        '0'  => 'New',
        '10' => 'Approved',
        '20' => 'Completed'
    ];

    protected $guarded   = ['id'];

    protected $dates     = [
        'delivery_dt',
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
        'partner_id'   => 'integer',
    ];

    protected $fillable  = [
        'status',
        'client_email',
        'partner_id',
        'delivery_dt',
    ];

    public function orderProducts()
    {
        return $this->hasMany( OrderProduct::class, 'order_id' );
    }

    public function partner()
    {
        return $this->belongsTo( Partner::class, 'partner_id', 'id' );
    }

    public function calculateSum()
    {
        $total = Order::newQuery()->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->where('orders.id', $this->id)
            ->sum(\DB::raw('order_products.price * order_products.quantity'));

        return $total;

    }

    public function getStatusText() {
        return self::$statuses[$this->status];
    }

    public static function getStatusesCodes() {
        return array_keys(self::$statuses);
    }

    public static function getStatusesList() {
        return self::$statuses;
    }
}