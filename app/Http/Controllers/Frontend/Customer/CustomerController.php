<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Frontend\Reservation\Requests\StoreRequest;
use App\Models\Reservation\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * @package App\Http\Controllers\Frontend\Customer
 */
class CustomerController extends Controller
{
    /**
     * Create Reservation
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.customers.create');
    }
}
