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
    public function index()
    {
        $reservations = $this->reservations->newQuery()->orderBy('id', 'desc')->paginate(25);

        $statuses = Reservation::getStatusesList();

        return view('admin.reservations.index', compact('reservations', 'statuses'));
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
}
