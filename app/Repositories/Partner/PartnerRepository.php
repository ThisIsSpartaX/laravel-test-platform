<?php

namespace App\Repositories\Partner;

use App\Models\Partner\Partner;
use App\Repostories\Contracts\Partner\PartnerRepository as PartnerRepositoryContract;
use Recca0120\Repository\EloquentRepository;


class PartnerRepository extends EloquentRepository implements PartnerRepositoryContract
{
    /** @var  Partner */
    protected $model;

    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}

