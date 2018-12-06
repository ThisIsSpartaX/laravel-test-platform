<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderProduct
 *
 * @property-read  int    $id
 * @property  int    $order_id
 * @property  int    $product_id
 * @property  int    $quantity
 * @property  float  $price
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\OrderProduct
 */
class OrderProduct extends Model
{
    protected $table     = 'order_products';

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
        'order_id'     => 'integer',
        'partner_id'   => 'integer',
    ];

    protected $fillable  = [
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo( Product::class, 'product_id' );
    }

    public function calculateSum()
    {
        return $this->price * $this->quantity;
    }
}