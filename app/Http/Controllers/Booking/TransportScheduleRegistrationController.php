<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransportScheduleRequest;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\FixedAssetRepository;
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
     * @var FixedAssetRepository
     */
    private $fixedAssetRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * Create a new controller instance.
     * @param BookingRepository $bookingRepository
     * @param BookingContainerDetailRepository $bookingContainerDetailRepository
     * @return void
     */
    public function __construct(
        BookingRepository $bookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        ScheduleTransportContainerRepository $scheduleTransportContainerRepository,
        FixedAssetRepository $fixedAssetRepository,
        EmployeeRepository $employeeRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
        $this->fixedAssetRepository = $fixedAssetRepository;
        $this->employeeRepository = $employeeRepository;
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $bookingNo = $request->has('bookingNo')?$request->bookingNo:'';
        $driverNo = $request->has('driverNo')?$request->driverNo:'';
        $containerTruckNo = $request->has('containerTruckNo')?$request->containerTruckNo:'';
        $bookingContainerDetails = [];
        $example = [];
        $errorFlash = [];
        $statusApproved = Booking::STATUS_APPROVED;
        if ($bookingNo) {
            $bookingNo = $request->bookingNo;
            $bookingContainerDetails = $this->bookingRepository->fullSearch($bookingNo,'');
            if ($bookingContainerDetails) {
                $bookingContainerDetails = $bookingContainerDetails->toArray();
            } else {
                $errorFlash['booking'] = 'Could not find this Booking No.';
            }

            if ($driverNo) {
                $bookingContainerDetails['data_driver'] = $this->employeeRepository->search(['code' => $driverNo, 'type' => 'DRIVER']);
                if (!$bookingContainerDetails['data_driver']) {
                    $errorFlash['driver'] = 'Could not find this Driver No.';
                }
            } else if ($containerTruckNo) {
                $bookingContainerDetails['data_container_truck'] = $this->fixedAssetRepository->search(['code' => $containerTruckNo, 'type' => 'TRUCK']);
                if (!$bookingContainerDetails['data_container_truck']) {
                    $errorFlash['container_truck'] = 'Could not find this Container Truck.';
                }
            }
        }

        return view('transport.transport_schedule_registration_create', compact('bookingContainerDetails', 'bookingNo', 'driverNo', 'containerTruckNo', 'example', 'statusApproved'))->with('searchError', $errorFlash);
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
        $booking =  $this->bookingRepository->find($id);
        $redirectLink = '/booking/transport/schedule/registration?bookingNo='.$booking->booking_no;
        if ($booking && $request->has('schedules')) {
            try {
                $driver = '';
                $container = '';
                if ($request->has('container')) {
                    $container = $this->fixedAssetRepository->find($request->container);
                    if ($container) {
                        $redirectLink = $redirectLink.'&containerTruckNo='.$container->fixed_asset_code;
                    }
                }

                if ($request->has('driver')) {
                    $driver = $this->employeeRepository->find($request->driver);
                    if ($driver) {
                        $redirectLink = $redirectLink.'&driverNo='.$driver->employee_code;
                    }
                }

                $this->scheduleTransportContainerRepository->saveBooking($request, $container, $driver);

                return redirect($redirectLink)->with('status', 'message.save_success');
            } catch (\Exception $e) {
                return redirect($redirectLink)->with('status', 'message.save_error');
            }
        }
        return redirect($redirectLink)->with('status', 'message.save_error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $booking = $this->scheduleTransportContainerRepository->find($id);
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
            return redirect('/booking/transport/schedule/registration?bookingNo='.$booking->booking_no)->with('status', 'message.save_success');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }
            return redirect('/booking/transport/schedule/registration?bookingNo='.$booking->booking_no)->with('status', 'message.save_error');
        }
    }

    /**
     * @param TransportScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateUseds(TransportScheduleRequest $request) {
        $validate = [];
        foreach ($request->schedules as $index => $schedule) {
            $schedule['pickup_plan'] = Carbon::createFromFormat('d/m/Y H:i', $schedule['pickup_plan'])->format('Y-m-d H:i:s');
            $schedule['delivery_plan'] = Carbon::createFromFormat('d/m/Y H:i', $schedule['delivery_plan'])->format('Y-m-d H:i:s');

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

    /**
     * @param $schedule
     * @param string $columnName
     * @return mixed
     */
    protected function isPropertyUsed($schedule, $columnName = 'container_truck_id') {
        $compare = ScheduleTransportContainer::where(function ($query) use ($schedule) {
            $query->whereRaw("'{$schedule['pickup_plan']}' BETWEEN pickup_plan AND delivery_plan OR '{$schedule['delivery_plan']}' BETWEEN pickup_plan AND delivery_plan");
        })
            ->where($columnName, $schedule[$columnName]);
        if ($schedule['id']) {
            $compare = $compare->where('id', '<>', $schedule['id']);
        }
        return $compare->exists();

    }
}
