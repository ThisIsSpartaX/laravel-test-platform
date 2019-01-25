<?php

namespace App\Http\Controllers\Frontend\Reservation;

use App\Http\Controllers\Frontend\Reservation\Requests\StoreRequest;
use App\Models\Reservation\Reservation;
use App\Http\Controllers\Controller;
use App\Models\Reservation\ReservationLog;
use App\Repositories\Reservation\ReservationRepository;
use App\Http\Requests\Order\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ReservationController
 * @package App\Http\Controllers\Frontend\Reservation
 */
class ReservationController extends Controller
{
    /** @var  ReservationRepository */
    public $reservations;

    /**
     * Create a new controller instance.
     *
     * @param ReservationRepository $reservations
     */
    public function __construct(ReservationRepository $reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * Create Reservation
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $reservation = new Reservation();

        return view('pages.reservations.create', compact('reservation'));
    }

    /**
     * Store Reservation
     *
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(StoreRequest $request)
    {
        $reservation = new Reservation();

        \DB::beginTransaction();

        try {

            $reservation->first_name = $request->get('first_name');
            $reservation->last_name = $request->get('last_name');
            $phone = preg_replace('~[^0-9]+~', '', $request->get('phone'));
            $reservation->phone = '1' . $phone;
            $reservation->email = $request->get('email');
            $reservation->children = ($request->get('children')) ? $request->get('children') : 0;
            $reservation->adults = $request->get('adults');
            $reservation->status = 'waiting';
            $reservation->viewed = 0;

            $total = $reservation->calculateTotalGuests($request->get('children'), $request->get('adults'));

            $reservation->save();

            $log = new ReservationLog();
            $log->reservation_id = $reservation->id;
            $log->status = $reservation->status;
            $log->user_id = 0;
            $log->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('reservations.create')->with('error', "Reservation was not created. Error in DB");
        }

        \DB::commit();

        //Set reservations cookie
        $reservations = [];

        if($request->cookie('reservations')) {
            $reservations = explode(',', $request->cookie('reservations'));
        }

        $reservations[$reservation->id] = $reservation->id;
        $reservations = implode(',', $reservations);

        return redirect()->route('reservations.index')->withCookie('reservations', $reservations)->with('success', "Your reservation for total number of ".$total." has been submitted.\nHostes has been notified. You will receive a text message to your phone when table is ready for you");
    }


    /**
     * Reservations lists
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reservations = $this->reservations->newQuery()->orderBy('id', 'asc')->where('status', 'waiting')->orWhere('status', 'in_progress')->orWhere('status', 'prepared')->paginate(100);

        return view('pages.reservations.index', compact('reservations'));
    }

    /**
     * Reservations refresh
     *
     * @return JsonResponse
     */
    public function refresh(Request $request)
    {
        $response = [];
        $response['data'] = '';

        $lastId = $request->query('last_id');
        $reservations = $this->reservations->newQuery()
            ->where( function ( $query )
            {
                $query->where( 'status', '=', 'waiting' )
                    ->orWhere( 'status', '=', 'in_progress' )
                    ->orWhere( 'status', '=', 'prepared' );
            })
            ->orderBy('id', 'asc')->get();

        if($reservations->count()) {
            $statuses = Reservation::getStatusesList();
            $response['html'] = \View::make('pages.reservations.list', compact('reservations', 'statuses'))->render();
        }

        return response()->json($response);
    }
}
