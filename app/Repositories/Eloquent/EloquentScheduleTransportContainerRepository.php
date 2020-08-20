<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ScheduleTransportContainerRepository;
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

    public function saveBooking($request) {
        DB::beginTransaction();
        try {
            $result = [];
            foreach ($request->schedules as $data) {
                if ($data['id']) {
                    $oldContainer = $this->find($data['id']);
                    $this->update($oldContainer, $data);
                } else {
                    $filter = collect([$data])->whereNotNull('container_no')
                        ->whereNotNull('seal_no_1')
                        ->whereNotNull('seal_no_2')
                        ->whereNotNull('package')
                        ->whereNotNull('weight')
                        ->whereNotNull('vgm')
                        ->whereNotNull('measure')
                        ->whereNotNull('vgm')
                        ->whereNotNull('st')
                        ->whereNotNull('rf')->values()->pop();
                    if ($filter) {
//                        $filter->merge(['created_by' => $userId]);
                        $record = $this->create($filter);
                        $data['id'] = $record->id;
                        $result[] = $data;
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
