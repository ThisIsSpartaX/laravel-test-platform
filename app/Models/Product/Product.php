<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property-read  int $id
 * @property  string $name
 * @property  string $price
 * @property  int    $vendor_id
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\Product
 */
class Product extends Model
{
    protected $table     = 'products';

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
}
