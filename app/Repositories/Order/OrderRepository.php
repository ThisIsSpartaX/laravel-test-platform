<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;
use App\Repostories\Contracts\Order\OrderRepository as OrderRepositoryContract;
use Recca0120\Repository\EloquentRepository;


class OrderRepository extends EloquentRepository implements OrderRepositoryContract
{
    /** @var  Order */
    protected $model;

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}

