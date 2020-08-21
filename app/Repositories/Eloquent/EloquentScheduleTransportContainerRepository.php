<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ScheduleTransportContainerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
                if ($data['eta'] && $data['etd']) {
                    $eta = Carbon::createFromFormat('d/m/Y H:i', $data['eta']);
                    $etd = Carbon::createFromFormat('d/m/Y H:i', $data['etd']);
//                    unset($data['container_truck_code']);
                    if ($eta->gt($etd)) {
                        if ($container) {
                            $data['container_truck_id'] = $container->id;
                            $data['container_truck_code'] = $container->fixed_asset_code;
                        }
                        if ($driver) {
                            $data['driver_id'] = $driver->id;
                            $data['driver_name'] = $driver->employee_code;
                        }
                        $data['eta'] = $eta->format('Y-m-d H:i:s');
                        $data['etd'] = $etd->format('Y-m-d H:i:s');
                        if ($data['id']) {
                            $oldContainer = $this->find($data['id']);
                            $this->update($oldContainer, $data);
                        } else {

                            $filter = collect([$data])
                                ->whereNotNull('booking_container_detail_id')
                                ->whereNotNull('booking_id')
                                ->whereNotNull('booking_no')
                                ->whereNotNull('container_id')
                                ->whereNotNull('booking_container_id')
                                ->whereNotNull('container_truck_code')
                                ->whereNotNull('driver_name')
                                ->values()->pop();

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
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
