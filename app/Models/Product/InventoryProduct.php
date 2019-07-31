<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property-read  int $id
 * @property  int $product_id
 * @property  int $inventory_id
 * @property  int $count
 * @property  int $vendor_id
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\Product
 */
class InventoryProduct extends Model
{
    protected $table     = 'inventory_products';

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
        'product_id'   => 'integer',
        'inventory_id' => 'integer',
        'count'        => 'integer',
        'vendor_id'    => 'integer'
    ];

    protected $fillable  = [
        'inventory_id',
        'product_id',
        'count',
        'vendor_id'
    ];
}
