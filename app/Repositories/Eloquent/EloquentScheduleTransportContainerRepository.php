<?php
namespace App\Repositories\Eloquent;

use App\BookingContainerDetail;
use App\Container;
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

    public function inquirySearch(Request $request) :LengthAwarePaginator
    {
        $query = new BookingContainerDetail();

        $search = $request->get('search');
        $query = $query->leftJoin('container', 'booking_container_details.container_id', 'container.id')
            ->leftJoin('booking', 'booking_container_details.booking_id', 'booking.id')
            ->leftJoin('scheduled_transport_container', 'scheduled_transport_container.booking_container_detail_id', 'booking_container_details.id')
            ->leftJoin('fixed_asset', 'scheduled_transport_container.driver_id', 'fixed_asset.id');
        if (isset($search['columns'])) {
            foreach ($search['columns'] as $key => $value)
            {
                try {
                    if (is_array($value)) {
                        if (strpos($key, 'etd')) {
                            $etd_from = Carbon::createFromFormat('d/m/Y H:i', $value['from'])->format('d-m-Y H:i:s');
                            $etd_to = Carbon::createFromFormat('d/m/Y H:i', $value['to'])->format('d-m-Y H:i:s');
                            $query = $query->whereBetween('scheduled_transport_container.etd', [$etd_from, $etd_to]);
                        } else {
                            $eta_from = Carbon::createFromFormat('d/m/Y H:i', $value['from'])->format('d-m-Y H:i:s');
                            $eta_to = Carbon::createFromFormat('d/m/Y H:i', $value['to'])->format('d-m-Y H:i:s');
                            $query->whereBetween('scheduled_transport_container.eta', [$eta_from, $eta_to]);
                        }
                    } else {
                        $query->where($key, '=' , $value);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return $query->select('scheduled_transport_container.etd', 'scheduled_transport_container.eta', 'booking_container_details.booking_no',
            'booking_container_details.container_no',
            'booking.por_1',
            'booking.por_2',
            'booking.pol_1',
            'booking.pol_2',
            'booking.pod_1',
            'booking.pod_2',
            'booking.del_1',
            'booking.del_2',
            'container.container_code',
            'fixed_asset.fixed_asset_code',
            'scheduled_transport_container.booking_container_detail_id',
            'scheduled_transport_container.container_truck_code',
            'scheduled_transport_container.driver_name',
            'scheduled_transport_container.id',
            'scheduled_transport_container.container_truck_code')->orderBy('booking_container_details.created_at', 'desc')->paginate($request->get('per_page', 10));
    }
}
