<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransportScheduleRequest;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingRepository;
use App\ScheduleTransportContainer;
use Illuminate\Http\Request;

class TransportScheduleRegistrationController extends Controller
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
        $bookingNo = '';
        $driverNo = '';
        $containerTruckNo = '';
        $bookingContainerDetails = [];
        $example = [];
        $statusApproved = Booking::STATUS_APPROVED;
        if ($request->has('bookingNo')) {
            $bookingNo = $request->bookingNo;
            $bookingContainerDetails = $this->bookingRepository->fullSearch($bookingNo,'');
            if ($bookingContainerDetails) {
                $bookingContainerDetails = $bookingContainerDetails->toArray();
            }
//            dd($bookingContainerDetails);
            if ($request->has('driverNo')) {

            } else if ($request->has('containerTruckNo')) {

            }
        }
        return view('transport.transport_schedule_registration_create', compact('bookingContainerDetails', 'bookingNo', 'driverNo', 'containerTruckNo', 'example', 'statusApproved'));
        if ($request->has('bookingNo')) {
            $search = $request->get('bookingNo');
            $bookingContainerDetails = $this->bookingRepository->search($search,'');

            if ($bookingContainerDetails) {
                $bookingContainerDetails = $bookingContainerDetails->toArray();
                $example = new BookingContainerDetail();
                $example = $example->attributesToArray();
                return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'));
            }
            return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'))->with('searchError', 'Could not find this Booking No.');
        }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateUseds(TransportScheduleRequest $request) {
        $validate = [];
        foreach ($request->schedules as $index => $schedule) {
            if ($schedule['container_truck_id']) {
                if($this->isPropertyUsed($schedule, 'container_truck_id')) {
                    $validate['schedules.'.$index.'.container_truck_code'] = ['This container truck was used during the selected period'];
                }
            }
            if ($schedule['driver_id']) {
                if($this->isPropertyUsed($schedule, 'driver_code')) {
                    $validate['schedules.'.$index.'.driver_id'] = ['This driver was used during the selected period'];
                }
            }
        }
        if ($validate) {
            return response()->json([
                'error' => null,
                'message' => 'Pass data!',
                'data' => []
            ], 200);
        }
        return response()->json([
            'errors' => $validate,
            'message' => 'The given data was invalid.'
        ], 403);
    }

    protected function isPropertyUsed($schedule, $columnName = 'container_truck_id') {
        return ScheduleTransportContainer::where(function ($query) use ($schedule) {
            $query->wherebetween('etd', [$schedule['etd'], $schedule['eta']])
                ->orwherebetween('eta', [$schedule['etd'], $schedule['eta']]);
        })
            ->where('container_truck_id', $this->car_id)
            ->exists();
    }
}
