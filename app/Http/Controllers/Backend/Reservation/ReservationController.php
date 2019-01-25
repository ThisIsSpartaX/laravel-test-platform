<?php

namespace App\Http\Controllers\Backend\Reservation;

use App\Models\Reservation\Reservation;
use App\Http\Controllers\Controller;
use App\Models\Reservation\ReservationLog;
use App\Repositories\Reservation\ReservationRepository;
use App\Http\Controllers\Backend\Reservation\Requests\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ReservationController
 * @package App\Http\Controllers\Reservation
 */
class ReservationController extends Controller
{
    /** @var  ReservationRepository */
    protected $reservations;

    /**
     * Create a new controller instance.
     *
     * @param ReservationRepository $reservations
     */
    public function __construct(ReservationRepository $reservations)
    {
        $this->middleware('auth');

        $this->reservations = $reservations;
    }

    /**
     * Reservations lists
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $reservations = $this->reservations->newQuery()->orderBy('id', 'desc')->paginate(10);

        $statuses = Reservation::getStatusesList();

        $newReservations = $this->reservations->newQuery()->where('viewed', 0)->get();

        if($newReservations->count()) {
            $request->session()->put('success', 'You have ' .$newReservations->count(). ' new reservations.');
        }

        return view('admin.reservations.index', compact('reservations', 'statuses'));
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
        $reservations = $this->reservations->newQuery()->where('viewed', 0)->get();

        if($reservations->count()) {
            //$statuses = Reservation::getStatusesList();
            $request->session()->put('success', 'You have ' .$reservations->count(). ' new reservations.');
            $response['html'] = \View::make('notifications')->render();
            $request->session()->remove('success');
            //$response['html'] = \View::make('admin.reservations.list', compact('reservations', 'statuses'))->render();
        }

        return response()->json($response);
    }

    /**
     * Update Reservation
     *
     * @param UpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $reservation = $this->reservations->findOrFail($id);

        if($reservation->status != $request->get('status')) {

            \DB::beginTransaction();


            try {

                $reservation->status = $request->get('status');
                $reservation->update();

                $log = new ReservationLog();
                $log->reservation_id = $reservation->id;
                $log->status = $reservation->status;
                $log->user_id = \Auth::id();
                $log->save();

            } catch (\Exception $e) {
                \DB::rollBack();
                return redirect()->route('admin.reservations')->with('error', "Reservation was not updated. Error in DB");
            }

            \DB::commit();

            return redirect()->route('admin.reservations')->with('success', "Reservation ID ".$reservation->id." status was changed to " . $reservation->getStatusText() . '!');

        } else {
            return redirect()->route('admin.reservations');
        }
    }

    /**
     * View Reservation
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view(Request $request, int $id)
    {
        $reservation = $this->reservations->findOrFail($id);

        \DB::beginTransaction();

        try {
            $reservation->viewed = 1;
            $reservation->update();

        } catch (\Exception $e) {
            \DB::rollBack();
        }

        \DB::commit();

        $log = new ReservationLog();
        $log->reservation_id = $reservation->id;
        $log->status = 'viewed';
        $log->user_id = \Auth::id();
        $log->save();

        return response()->json([]);
    }
}
