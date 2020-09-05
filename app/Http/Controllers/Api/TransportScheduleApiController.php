<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\ScheduleTransportContainerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ScheduleTransportContainer;

class TransportScheduleApiController extends BaseApiController
{
    /**
     * @var ScheduleTransportContainerRepository
     */
    private $scheduleTransportContainerRepository;

    /**
     * Create a new controller instance.
     * @param ScheduleTransportContainerRepository $scheduleTransportContainerRepository
     *
     * @return void
     */
    public function __construct(
        ScheduleTransportContainerRepository $scheduleTransportContainerRepository
    )
    {
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
    }

    /**
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $booking = $this->bookingRepository->search($request->get('search',''));
            if ($booking) {
                return $this->success($booking);
            }
            return $this->error('Booking not found');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }
    
    /**
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooking($booking_id)
    {
        try {
            
            $booking = $this->bookingRepository->find($booking_id);
            if ($booking) {
                return $this->success($booking);
            }
            return $this->error('Booking not found');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        
    }
    
    public function autoCompleteBookingNo(Request $request){
        $data = Booking::select("booking_no as name")
                    ->where("booking_no","LIKE","%{$request->input('query')}%")
                    ->get();
                    
        return response()->json($data);
    }
    
    public function getContainerTrucksForSchedule(Request $request){
        $containerTrucksForSchedule = [];
        
        $pickup_plan = $request->get('pickup_plan');
        $delivery_plan = $request->get('delivery_plan');
        
        if(empty($pickup_plan) || empty($delivery_plan)){
            return [];
        }
        
        $containerTrucksForSchedule = $this->scheduleTransportContainerRepository->getContainerTrucksForSchedule($pickup_plan, $delivery_plan);
        
        return response()->json($containerTrucksForSchedule);
    }
    
    public function createSchedule(Request $request){
        if ($request->has('schedules')) {
            try {
                $driver = '';
                $container = '';
                // validate full schedule for booking
                $isFullScheduleForBookingContainer = true;
                
                $booking_id = !empty($request->schedules) ? $request->schedules[0]['booking_id']??'' : '';
                $container_id = !empty($request->schedules) ? $request->schedules[0]['container_id']??'' : '';
                
                if(empty($booking_id) || empty($container_id)){
                    return response()->json(["statusCode" => "NG_BOOKING_CONTAINER","errorMessge" => "Booking Container is not valid"], 400);
                }
                
                $isFullScheduleForBookingContainer = $this->scheduleTransportContainerRepository->isFullScheduleForBookingContainer($booking_id,$container_id);
                
                if($isFullScheduleForBookingContainer){
                    return response()->json(["statusCode" => "NG_FULL_SCHEDULE","errorMessge" => "Booking had been scheduled fully"], 400);
                }
                
                $schedule = $this->scheduleTransportContainerRepository->saveBooking($request, $container, $driver);
                
                return response()->json(["statusCode" => "OK",
                    "schedule_id" => $schedule[0]["id"],
                    "booking_container_detail_id" => $schedule[0]["booking_container_detail_id"]
                ], 200);
                
            } catch (\Exception $e) {
                return response()->json(["statusCode" => "NG","errorMessge" => $e->getMessage()], 400);
            }
        }
        
    }
    
    public function updateSchedule(Request $request){
        if ($request->has('schedules')) {
            try {
                $driver = '';
                $container = '';
                
                $schedule = $this->scheduleTransportContainerRepository->saveBooking($request, $container, $driver);
                
                return response()->json(["statusCode" => "OK",
                    "schedule_id" => $schedule[0]["id"],
                    "booking_container_detail_id" => $schedule[0]["booking_container_detail_id"]
                ]);
                
            } catch (\Exception $e) {
                return response()->json(["statusCode" => "NG","errorMessge" => $e->getMessage()]);
            }
        }
        
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
}
