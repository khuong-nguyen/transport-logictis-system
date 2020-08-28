<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ScheduleTransportContainerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\BookingContainerDetail;

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
}
