<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property-read  int $id
 * @property  string $name
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\Product
 */
class Product extends Model
{
    protected $table     = 'products';

    protected static $statuses = [
        '1' => 'In Stock',
        '2' => 'Out of Stock',
        '3' => 'Discontinued',
    ];

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
        'price'        => 'float',
        'vendor_id'    => 'integer',
    ];

    protected $fillable  = [
        'name',
        'price',
        'vendor_id'
    ];

    public function inventoryProducts() {
        return $this->hasMany( InventoryProduct::class, 'product_id' );
    }

    public function getPrice() {
        return $this->price;
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
