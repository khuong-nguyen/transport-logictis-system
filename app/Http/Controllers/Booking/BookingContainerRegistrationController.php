<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingContainerRegistrationController extends Controller
{
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * @var BookingContainerDetailRepository
     */
    private $bookingContainerDetailRepository;

    /**
     * Create a new controller instance.
     * @param BookingRepository $bookingRepository
     * @param BookingContainerDetailRepository $bookingContainerDetailRepository
     * @return void
     */
    public function __construct(
        BookingRepository $bookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $search = '';
        $bookingContainerDetails = [];
        $example = [];
        $statusApproved = Booking::STATUS_APPROVED;
        if ($request->has('search')) {
            $search = $request->get('search');
            $bookingContainerDetails = $this->bookingRepository->search($search,'');

            if ($bookingContainerDetails) {
                $bookingContainerDetails = $bookingContainerDetails->toArray();
                $example = new BookingContainerDetail();
                $example = $example->attributesToArray();
                return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'));
            }
            return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'))->with('searchError', 'Could not find this Booking No.');
        }
        return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking =  $this->bookingRepository->find($id);
        return view('transport.booking_container_registration_create', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking =  $this->bookingRepository->find($id);
        if ($request->has('save-container')) {
            try {
                $data = [];
                if ($booking->booking_status !== Booking::STATUS_APPROVED) {
                    $data = $this->bookingContainerDetailRepository->saveBooking($request);
                }
                return response()->json([
                    'error' => null,
                    'message' => 'Updated success!',
                    'data' => $data
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }

        }
        if ($request->has('confirm-booking')) {
            try {
                $data = [];
                if ($booking->booking_status !== Booking::STATUS_APPROVED) {
                    $data = $this->bookingRepository->update($booking, ['booking_status' => Booking::STATUS_APPROVED]);
                }

                return response()->json([
                    'error' => null,
                    'message' => 'Updated success!',
                    'data' => $data
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }

        }
        if ($booking && $request->has('containerbookingdetail') && $booking->booking_status !== Booking::STATUS_APPROVED) {
            try {
                $this->bookingContainerDetailRepository->saveBooking($request);
                return redirect('/booking/transport/registration?search='.$booking->booking_no)->with('status', 'message.save_success');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect('/booking/transport/registration?search='.$booking->booking_no)->with('status', 'message.save_error');
            }
        }
        return redirect('/booking/transport/registration?search='.$booking->booking_no)->with('status', 'message.save_error');
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $booking = $this->bookingContainerDetailRepository->find($id);
            if ($booking->booking_status !== Booking::STATUS_APPROVED) {
                $this->bookingContainerDetailRepository->destroy($booking);
                DB::commit();
            }
            if ($request->ajax()) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => true
                ], 200);
            }
            return redirect('/booking/transport/registration?search='.$booking->booking_no)->with('status', 'message.save_success');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }
            return redirect('/booking/transport/registration?search='.$booking->booking_no)->with('status', 'message.save_error');
        }
    }
}
