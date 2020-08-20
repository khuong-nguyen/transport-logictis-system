<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransportScheduleRequest;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ScheduleTransportContainerRepository;
use App\ScheduleTransportContainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @var ScheduleTransportContainerRepository
     */
    private $scheduleTransportContainerRepository;

    /**
     * Create a new controller instance.
     * @param BookingRepository $bookingRepository
     * @param BookingContainerDetailRepository $bookingContainerDetailRepository
     * @return void
     */
    public function __construct(
        BookingRepository $bookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        ScheduleTransportContainerRepository $scheduleTransportContainerRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
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
    public function update(TransportScheduleRequest $request, $id)
    {
        $booking =  $this->bookingRepository->find($id);
        if ($booking && $request->has('schedules')) {
            try {
                $this->scheduleTransportContainerRepository->saveBooking($request);
                return redirect('/booking/transport/schedule/registration?search='.$booking->booking_no)->with('status', 'message.save_success');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect('/booking/transport/schedule/registration?search='.$booking->booking_no)->with('status', 'message.save_error');
            }
        }
        return redirect('/booking/transport/schedule/registration?search='.$booking->booking_no)->with('status', 'message.save_error');
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
            $schedule['etd'] = Carbon::createFromFormat('d/m/Y H:i', $schedule['etd'])->format('Y-m-d H:i:s');
            $schedule['eta'] = Carbon::createFromFormat('d/m/Y H:i', $schedule['eta'])->format('Y-m-d H:i:s');

            if ($schedule['container_truck_id']) {
                if($this->isPropertyUsed($schedule, 'container_truck_id')) {
                    $validate['schedules.'.$index.'.container_truck_code'] = ['This container truck was used during the selected period'];
                }
            }
            if ($schedule['driver_id']) {
                if($this->isPropertyUsed($schedule, 'driver_id')) {
                    $validate['schedules.'.$index.'.driver_code'] = ['This driver was used during the selected period'];
                }
            }
        }
        if (!$validate) {
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
            $query->whereRaw("'{$schedule['etd']}' BETWEEN etd AND eta OR '{$schedule['eta']}' BETWEEN etd AND eta");
        })
            ->where($columnName, $schedule[$columnName])
            ->exists();

    }
}
