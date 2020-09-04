<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ScheduleTransportContainerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\BookingContainerDetail;
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
                            
                            //update booking container detail
                            if(empty($oldContainer->container_no)){
                                $old = BookingContainerDetail::find($oldContainer->booking_container_detail_id);
                                if(!empty($old)){
                                    $old->update(['container_no'=> $data['container_no'] ]);
                                }
                            }
                            
                            $this->update($oldContainer, $data);
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
                                    'container_no' => $filter['container_no']
                                ];
                                
                                $booking_container_detail = BookingContainerDetail::create($booking_container_detail);
                                if($booking_container_detail){
                                    $filter['booking_container_detail_id'] = $booking_container_detail->id;
                                }
                            }
                            
                            if ($filter) {
                                
                                $record = $this->create($filter);
                                $data['id'] = $record->id;
                                $result[] = $data;
                            }
                        }
                    }
                }
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getContainerTrucksForSchedule($pickup_plan,$delivery_plan){
        $containerTrucksForSchedule = [];

        $pickup_plan = Carbon::createFromFormat('d/m/Y H:m', $pickup_plan)->format('Y-m-d H:m:s');
        $delivery_plan = Carbon::createFromFormat('d/m/Y H:m', $delivery_plan)->format('Y-m-d H:m:s');
        
        // get Container Truck have no schedule base on pickup_plan and delivery_plan
        
        $noHaveScheduleContainerTruck = FixedAsset::where('fixed_asset_type','TRUCK')
                                             ->whereNotIn('id', function($query) use($pickup_plan,$delivery_plan){
                                                    $query->select('container_truck_id')->from('scheduled_transport_container')
                                                                ->whereRaw("pickup_plan >= '".$pickup_plan."' and pickup_plan <= '".$delivery_plan."'")
                                                                ->orWhereRaw("delivery_plan > '".$pickup_plan."' and delivery_plan <= '".$delivery_plan."'");
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
        
        Return $transportStatusToday;
        
    }
    
    public function transportScheduleNearly($container_truck_id){
        $transportScheduleNearly = "";
        $startTimeCurrentDate = date('Y-m-d 00:00:00');
        $endTimeCurrentDate = date('Y-m-d 23:59:59');
        $schedule = $this->model->where('container_truck_id' ,$container_truck_id)->orderBy('pickup_plan', 'DESC')->first();
        if(!empty($schedule)){
            $transportScheduleNearly = $schedule->pickup_plan. " ~ " . $schedule->delivery_plan;
        }
        
        
        Return $transportScheduleNearly;
        
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
        
        
        Return $importTransportTotal;
        
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
        
        
        Return $exportTransportTotal;
        
    }
}
