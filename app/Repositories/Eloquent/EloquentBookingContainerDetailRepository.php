<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BookingContainerDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class EloquentBookingContainerDetailRepository extends EloquentBaseRepository implements BookingContainerDetailRepository
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
            foreach ($request->containerbookingdetail as $data) {
                if ($data['id']) {
                    $oldContainer = $this->find($data['id']);
                    $this->update($oldContainer, $data);
                } else {
                    if ($request->has('add-full')) {
                        $data['container_no'] = $data['container_no']?$data['container_no']:'CONT'.substr(str_shuffle("0123456789"), 0, 5);
                        $data['seal_no_1'] = $data['seal_no_1']?$data['seal_no_1']:'SEAL'.substr(str_shuffle("0123456789"), 0, 5);
                        $data['seal_no_2'] = $data['seal_no_2']?$data['seal_no_2']:'SEAL'.substr(str_shuffle("0123456789"), 0, 5);
                        $data['package'] = $data['package']?$data['package']:0;
                        $data['weight'] = $data['weight']?$data['weight']:0;
                        $data['vgm'] = $data['vgm']?$data['vgm']:0;
                        $data['measure'] = $data['measure']?$data['measure']:0;
                        $data['rf'] = $data['rf']?$data['rf']:0;
                        $data['st'] = $data['st']?$data['st']:'ST'.substr(str_shuffle("0123456789"), 0, 5);
                        $record = $this->create($data);
                        $data['id'] = $record->id;
                        $result[] = $data;
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
                            $record = $this->create($filter);
                            $data['id'] = $record->id;
                            $result[] = $data;
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
