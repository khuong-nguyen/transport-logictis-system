<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ScheduleTransportContainerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\BookingContainerDetail;
use App\ContainerBooking;
use App\Booking;
use App\FixedAsset;
class EloquentScheduleTransportContainerRepository extends EloquentBaseRepository implements ScheduleTransportContainerRepository
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function serverPaginationFilteringFor(Request $request) : LengthAwarePaginator
    {
        $query = $this->allWithBuilder();

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query->paginate($request->get('per_page', 10));
    }

    public function getWithContainerByBookingId($id)
    {
        return $this->model->query()->with('container')->where('booking_id',$id)->get();
    }

    public function saveBooking($request, $container = '', $driver = '') {

        DB::beginTransaction();
        try {
            $result = [];
            
            foreach ($request->schedules as $data) {
                if ($data['delivery_plan'] && $data['pickup_plan']) {
                    $delivery_plan = Carbon::createFromFormat('d/m/Y H:i', $data['delivery_plan']);
                    
                    $pickup_plan = Carbon::createFromFormat('d/m/Y H:i', $data['pickup_plan']);
                    
                    $completed_date = !empty($data['completed_date'])? Carbon::createFromFormat('d/m/Y H:i', $data['completed_date']) : null ;
                    
                    if ($delivery_plan->gt($pickup_plan)) {
                        if ($container) {
                            $data['container_truck_id'] = $container->id;
                            $data['container_truck_code'] = $container->fixed_asset_code;
                        }
                        if ($driver) {
                            $data['driver_id'] = $driver->id;
                            $data['driver_name'] = $driver->employee_code;
                        }
                        $data['delivery_plan'] = $delivery_plan->format('Y-m-d H:i:s');
                        $data['pickup_plan'] = $pickup_plan->format('Y-m-d H:i:s');
                        $data['completed_date'] = !empty($completed_date) ? $completed_date->format('Y-m-d H:i:s'):null;
                        
                        if ($data['id']) {
                            $oldContainer = $this->find($data['id']);
                            
                            if(in_array($oldContainer->schedule_status,['ASSIGNED','REFUSE'])){
                                //update booking container detail
                                if(empty($oldContainer->container_no)){
                                    $old = BookingContainerDetail::find($oldContainer->booking_container_detail_id);
                                    if(!empty($old)){
                                        $old->update(['container_no'=> $data['container_no'] ]);
                                    }
                                }
                                $data['booking_container_detail_id'] = $oldContainer->booking_container_detail_id;
                                $this->update($oldContainer, $data);
                            }
                            
                            $result[] = $data;
                            
                        } else {

                            $filter = collect([$data])
                                ->whereNotNull('booking_id')
                                ->whereNotNull('booking_no')
                                ->whereNotNull('booking_container_id')
                                ->whereNotNull('container_truck_code')
                                ->whereNotNull('driver_name')
                                ->values()->pop();
                            
                            // insert booking_container_detail
                            if(empty($data['booking_container_detail_id'])){
                                $booking_container_detail = [
                                    'booking_container_id' => $filter['booking_container_id'],
                                    'booking_id' => $filter['booking_id'],
                                    'booking_no' => $filter['booking_no'],
                                    'measure' => 1,
                                    'package' => 1,
                                    'container_no' => $filter['container_no'],
                                    'container_id' => $filter['container_id'],
                                ];
                                
                                $booking_container_detail = BookingContainerDetail::create($booking_container_detail);
                                if($booking_container_detail){
                                    $filter['booking_container_detail_id'] = $booking_container_detail->id;
                                }
                            }
                            
                            if ($filter) {
                                $current_date = new \DateTime();
                                $assigned_date = $current_date->format('Y-m-d H:m:s');
                                $filter['assigned_date'] = $assigned_date;
                                $record = $this->create($filter);
                                $data['id'] = $record->id;
                                $data['booking_container_detail_id'] = $record->booking_container_detail_id;
                                $result[] = $data;
                            }
                        }
                    }
                }
                $this->updateScheduleStatusForBooking($data["booking_id"]);
            }
            
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getContainerTrucksForSchedule($pickup_plan,$delivery_plan, $yyyy_mm_dd = false){
        $containerTrucksForSchedule = [];
        if($yyyy_mm_dd == false){
            $pickup_plan = Carbon::createFromFormat('d/m/Y H:m', $pickup_plan)->format('Y-m-d H:m:s');
            $delivery_plan = Carbon::createFromFormat('d/m/Y H:m', $delivery_plan)->format('Y-m-d H:m:s');
        }
        // get Container Truck have no schedule base on pickup_plan and delivery_plan
        
        $noHaveScheduleContainerTruck = FixedAsset::where('fixed_asset_type','TRUCK')
                                             ->whereNotIn('id', function($query) use($pickup_plan,$delivery_plan){
                                                    $query->select('container_truck_id')->from('scheduled_transport_container')
                                                    ->whereRaw("((pickup_plan <= '".$pickup_plan."' and delivery_plan > '".$pickup_plan."')")
                                                    ->orWhereRaw("(pickup_plan > '".$pickup_plan."' and pickup_plan < '".$delivery_plan."'))")
                                                                ->whereNull('scheduled_transport_container.deleted_at');
                                                    ;
                                        })->get();
                                                          
        // get Rank of Container Trucks in current month
        $firstDateCurrentMonth = date('Y-m-01 00:00:00');
        $endDateCurrentMonth = date('Y-m-t 23:59:59');
        
        $rankContainerTruckCurrentMonth = $this->model->groupBy('container_truck_id','container_truck_code')
                                                                    ->select('container_truck_id','container_truck_code',DB::raw('count(id) as rank'))
                                                                    ->where('pickup_plan', '>=',$firstDateCurrentMonth )
                                                                    ->where('pickup_plan', '<=',$endDateCurrentMonth)
                                                                    ->orderBy('rank')
                                                                    ->get()->toArray();
                                                                    
                                                                    
        foreach($noHaveScheduleContainerTruck as &$containerTruck){
            $noRank = true;
            foreach($rankContainerTruckCurrentMonth as $rankTruck){
                if($containerTruck['id'] == $rankTruck['container_truck_id']){
                    $containerTruck['rank'] = $rankTruck['rank'];
                    $containerTrucksForSchedule[] = $containerTruck;
                    $noRank = false;
                }
            }
            if($noRank){
                $containerTruck['rank'] = 0;
                $containerTrucksForSchedule[] = $containerTruck;
            }
        }
        
        // sort by rank
        array_multisort(array_column($containerTrucksForSchedule, 'rank'), SORT_ASC, $containerTrucksForSchedule);
        
        return $containerTrucksForSchedule;
    }
    
    public function listTransportSummary(){
        $listTransportSummary = [];
       // get list container truck
        $listContainerTruck = FixedAsset::where('fixed_asset_type','TRUCK')->get();
        foreach($listContainerTruck as $truck){
            $import_transport_total = $this->importTransportTotal($truck->id);
            $export_transport_total = $this->exportTransportTotal($truck->id);
            $listTransportSummary[] =[
                "fixed_asset_code" => $truck->fixed_asset_code,
                "driver_code" => $truck->driver_code,
                "driver_name" => $truck->driver_name,
                "transport_schedule_nearly" => $this->transportScheduleNearly($truck->id),
                "transport_status_today" => $this->transportStatusToday($truck->id),
                "import_transport_total" => $import_transport_total,
                "export_transport_total" => $export_transport_total,
                "transport_total" => $import_transport_total + $export_transport_total
            ];
        }

        return $listTransportSummary;
    }
    
    public function transportStatusToday($container_truck_id){
        $transportStatusToday = "Empty";
        $startTimeCurrentDate = date('Y-m-d 00:00:00');
        $endTimeCurrentDate = date('Y-m-d 23:59:59');
        $schedules = $this->model->where('pickup_plan', '>=',$startTimeCurrentDate )
                                 ->where('pickup_plan', '<=',$endTimeCurrentDate)
                                ->where('container_truck_id' ,$container_truck_id)
                                ->get();
        
        if(count($schedules)>0){
            $transportStatusToday = "Run";
        }
        
        return $transportStatusToday;
        
    }
    
    public function transportScheduleNearly($container_truck_id){
        $transportScheduleNearly = "";
        $startTimeCurrentDate = date('Y-m-d 00:00:00');
        $endTimeCurrentDate = date('Y-m-d 23:59:59');
        $schedule = $this->model->where('container_truck_id' ,$container_truck_id)->orderBy('pickup_plan', 'DESC')->first();
        if(!empty($schedule)){
            $transportScheduleNearly = $schedule->pickup_plan. " ~ " . $schedule->delivery_plan;
        }
        
        
        return $transportScheduleNearly;
        
    }
    
    public function importTransportTotal($container_truck_id){
        $importTransportTotal = 0;
        // get Rank of Container Trucks in current month
        $firstDateCurrentMonth = date('Y-m-01 00:00:00');
        $endDateCurrentMonth = date('Y-m-t 23:59:59');
        $schedule = $this->model->join('booking','scheduled_transport_container.booking_id','=', 'booking.id')
            ->where('pickup_plan', '>=',$firstDateCurrentMonth )
            ->where('pickup_plan', '<=',$endDateCurrentMonth)
            ->where('booking_type', '=', "IMPORT")
            ->where('container_truck_id' ,$container_truck_id)->count();
        
        if(!empty($schedule)){
            $importTransportTotal = $schedule;
        }
        
        
        return $importTransportTotal;
        
    }
    
    public function exportTransportTotal($container_truck_id){
        $exportTransportTotal = 0;
        // get Rank of Container Trucks in current month
        $firstDateCurrentMonth = date('Y-m-01 00:00:00');
        $endDateCurrentMonth = date('Y-m-t 23:59:59');
        $schedule = $this->model->join('booking','scheduled_transport_container.booking_id','=', 'booking.id')
        ->where('pickup_plan', '>=',$firstDateCurrentMonth )
        ->where('pickup_plan', '<=',$endDateCurrentMonth)
        ->where('booking_type', '=', "EXPORT")
        ->where('container_truck_id' ,$container_truck_id)->count();
        
        if(!empty($schedule)){
            $exportTransportTotal = $schedule;
        }

        return $exportTransportTotal;
    }
    
    public function isFullScheduleForBookingContainer($booking_id,$container_id){
        $isFullScheduleForBookingContainer = true;
        
        if(!empty($booking_id) && !empty($container_id)){
            $booking_container = ContainerBooking::where('booking_id',$booking_id)
                                                    ->where('container_id', $container_id)
                                                    ->first();
            
            if(!empty($booking_container)){
                // get schedule count for booking base on container_id.
                $scheduledBookingContainerCount = $this->model
                ->where('booking_id', $booking_id)
                ->where('container_id',$booking_container->container_id)
                ->count();
                
                if($scheduledBookingContainerCount < $booking_container->vol){
                    $isFullScheduleForBookingContainer = false;
                }
            }
        }
        
        return $isFullScheduleForBookingContainer;
    }
    
    public function updateScheduleStatusForBooking($booking_id){
        
        $scheduleStatus = 'FULL';
        $hasEmpty = false;
        $hasFull = false;
        
        if(!empty($booking_id)){
            $booking_containers = ContainerBooking::where('booking_id',$booking_id)
            ->get();    
            // get schedule count for booking base on container_id.
            foreach($booking_containers as $booking_container){
                $scheduledBookingContainerCount = $this->model
                ->where('booking_id', $booking_id)
                ->where('container_id',$booking_container->container_id)
                ->whereNull('deleted_at')
                ->count();
                
                if($scheduledBookingContainerCount == 0){
                    $scheduleStatus = 'EMPTY';
                    $hasEmpty = true;
                }elseif($scheduledBookingContainerCount == $booking_container->vol && $scheduledBookingContainerCount > 0){
                    $hasFull = true;
                }
                
                if($scheduledBookingContainerCount < $booking_container->vol && $scheduledBookingContainerCount > 0){
                    // Update Partial
                    $scheduleStatus = "PARTIAL";
                   
                    $booking = Booking::find($booking_id);
                    $booking->update(["schedule_status" => $scheduleStatus]);
                    return $scheduleStatus;
                    
                }elseif($scheduledBookingContainerCount == $booking_container->vol &&  $scheduleStatus == 'EMPTY'){
                    // Update Partial
                    $scheduleStatus = "PARTIAL";
                    
                    $booking = Booking::find($booking_id);
                    $booking->update(["schedule_status" => $scheduleStatus]);
                    
                    return $scheduleStatus;
                    
                }elseif($hasEmpty && $hasFull){
                    // Update Partial
                    $scheduleStatus = "PARTIAL";
                    
                    $booking = Booking::find($booking_id);
                    $booking->update(["schedule_status" => $scheduleStatus]);
                    
                    return $scheduleStatus;
                }
            }
            
            $booking = Booking::find($booking_id);
            $booking->update(["schedule_status" => $scheduleStatus]);
            
            return $scheduleStatus;
            
        }
    }

    public function getTransportScheduleForDriver($driver_id, $from, $to){
        $from = Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d');
        $schedules = $this->model->query()
            ->with('container')
            ->with(['booking' => function($q){
                $q->with(['shipper','consignee']);
            }])
            ->where('driver_id' ,$driver_id)
            ->whereIn('schedule_status',['ASSIGNED','INPROCESS'])
            ->whereBetween(DB::raw('DATE(pickup_plan)'), [$from, $to])
            ->orderBy('pickup_plan', 'DESC')
            ->get();
            
        return $schedules;
    }
    
    public function confirmTransportScheduleFromDriver($driver_id, $schedule_id){
        $schedule = $this->find($schedule_id);
        if($schedule){
            $current_date = new \DateTime();
            $confirm_date = $current_date->format('Y-m-d H:m:s');
            $schedule->update(
                    [
                        'schedule_status' => 'INPROCESS',
                        'inprocess_date' => $confirm_date
                    ]
                );
        }
        return $schedule;
    }
    
    public function refuseTransportScheduleFromDriver($driver_id, $schedule_id){
        $schedule = $this->find($schedule_id);
        if($schedule){
            $current_date = new \DateTime();
            $refuse_date = $current_date->format('Y-m-d H:m:s');
            $schedule->update(
                [
                    'schedule_status' => 'REFUSE',
                    'refuse_date' => $refuse_date
                ]
                );
        }
        return $schedule;
    }
    
    public function completedTransportScheduleFromDriver($driver_id, $schedule_id){
        $schedule = $this->find($schedule_id);
        if($schedule){
            $current_date = new \DateTime();
            $completed_date = $current_date->format('Y-m-d H:m:s');
            $schedule->update(
                [
                    'schedule_status' => 'COMPLETED',
                    'completed_date' => $completed_date
                ]
                );
        }
        return $schedule;
    }

    public function autoScheduleForBooking($booking_id){
        $booking = Booking::find($booking_id);
        if($booking->booking_status <> 'ORDER'){
            // 1.Begin autoScheduleForBooking
            // 2.Check schedule_status for Booking
            if($booking->schedule_status <> 'FULL'){
                $container_bookings = ContainerBooking::with('schedules')
                    ->where('booking_id',$booking_id)->get();
                foreach($container_bookings as $container_booking){
                    $scheduleCount = $container_booking->schedules ? $container_booking->schedules->count() : 0;
                    $createCount = $container_booking->vol - $scheduleCount;
                    if($createCount > 0){
                        $delivery_plan = $booking->sailling_due_date;
                        $pickup_plan = $booking->pick_up_dt;
                        $current_date = new \DateTime();
                        $assigned_date = $current_date->format('Y-m-d H:m:s');

                        $containerTrucksForSchedule = $this->getContainerTrucksForSchedule($pickup_plan,$delivery_plan,true);
                        
                        if(count($containerTrucksForSchedule) > 0){
                            for($i = 1; $i <= $createCount; $i++){
                                if(!isset($containerTrucksForSchedule[$i - 1])){
                                    break;
                                }
                                // create schedule for container booking
                                $newSchedule = [
                                    "booking_id" => $booking->id,
                                    "booking_no" => !empty($booking->booking_no)
                                                        ? $booking->booking_no : (!empty($booking->virtual_booking_no)
                                                        ? $booking->virtual_booking_no : $booking->request_order_no),
                                    "container_id" => $container_booking->container_id,
                                    "container_no" => null,
                                    "booking_container_id" => $container_booking->id,
                                    "pickup_plan" => $pickup_plan,
                                    "delivery_plan" => $delivery_plan,
                                    "assigned_date" => $assigned_date,
                                    "container_truck_id" => $containerTrucksForSchedule[$i - 1]["id"],
                                    "container_truck_code" => $containerTrucksForSchedule[$i - 1]["fixed_asset_code"],
                                    "driver_id" => $containerTrucksForSchedule[$i - 1]["driver_id"],
                                    "driver_name" => $containerTrucksForSchedule[$i - 1]["driver_name"],
                                    "pickup_address" => $booking->pickup_address,
                                    "delivery_address" => $booking->delivery_address
                                ];

                                $booking_container_detail = [
                                    'booking_container_id' => $newSchedule['booking_container_id'],
                                    'booking_id' => $newSchedule['booking_id'],
                                    'booking_no' => $newSchedule['booking_no'],
                                    'measure' => 1,
                                    'package' => 1,
                                    'container_no' => $newSchedule['container_no'],
                                    'container_id' => $newSchedule['container_id'],
                                ];
                                
                                $booking_container_detail = BookingContainerDetail::create($booking_container_detail);
                                if($booking_container_detail){
                                    $newSchedule['booking_container_detail_id'] = $booking_container_detail->id;
                                }
                                $record = $this->create($newSchedule);
                            }
                        }
                    }
                }
            }
        }
        
    }
}
