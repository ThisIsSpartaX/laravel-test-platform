<?php

namespace App\Repositories\Reservation;

use App\Models\Reservation\Reservation;
use App\Repostories\Contracts\Reservation\ReservationRepository as ReservationRepositoryContract;
use Recca0120\Repository\EloquentRepository;


class ReservationRepository extends EloquentRepository implements ReservationRepositoryContract
{
    /** @var  Reservation */
    protected $model;

    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }
}

