<?php

namespace App\Models\Partner;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner
 *
 * @property-read  int    $id
 * @property-read  string $email
 * @property-read  string $name
 * @property-read  Carbon $created_at
 * @property-read  Carbon $updated_at
 *
 * @package App\Models\Partner
 */
class Partner extends Model
{
    protected $table     = 'partners';

    protected $guarded   = ['id'];

    protected $dates     = [
        'created_at',
        'updated_at'
    ];

    protected $casts     = [
        'id'           => 'integer',
    ];

    protected $fillable  = [
        'email',
        'name',
    ];
}