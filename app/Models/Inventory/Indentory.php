<?php

namespace App\Models\Inventory;

use App\Models\Product\InventoryProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property-read  int $id
 * @property  string $title
 * @property  string $location
 * @property  Carbon $created_at
 * @property  Carbon $updated_at
 *
 * @package App\Models\Product
 */
class Inventory extends Model
{
    protected $table     = 'inventories';

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
        'title'        => 'text',
        'location'    => 'text',
    ];

    protected $fillable  = [
        'id',
        'name',
        'location'
    ];

    public function products() {
        return $this->hasMany( InventoryProduct::class, 'inventory_id' );
    }
}
