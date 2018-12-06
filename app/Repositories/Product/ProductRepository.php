<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use App\Repostories\Contracts\Product\ProductRepository as ProductRepositoryContract;
use Recca0120\Repository\EloquentRepository;


class ProductRepository extends EloquentRepository implements ProductRepositoryContract
{
    /** @var  Product */
    protected $model;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}

