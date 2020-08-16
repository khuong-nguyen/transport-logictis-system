<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BookingRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EloquentBookingRepository extends EloquentBaseRepository implements BookingRepository
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

    public function inquirySearch(Request $request) :LengthAwarePaginator
    {
        $query = $this->model->query();

        $search = $request->get('search');

        foreach ($search['columns'] as $key => $value)
        {
            if ($value != null)
            {
                $query->where($key,'=',$value);
            }
        }

        if ($search['shipper_customer_code'] != null)
        {
            $customer_code = $search['shipper_customer_code'];
            $query->whereHas('shipper',function($q)use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if ($search['consignee_customer_code'] != null)
        {
            $customer_code = $search['consignee_customer_code'];
            $query->whereHas('consignee',function($q) use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if ($search['forwarder_customer_code'] != null)
        {
            $customer_code = $search['forwarder_customer_code'];
            $query->whereHas('forwarders',function($q) use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if ($search['sailling_due_date']['from'] != null)
        {
            $query->where('sailling_due_date','>=',$search['sailling_due_date']['from']);
        }
        if ($search['sailling_due_date']['to'] != null)
        {
            $query->where('sailling_due_date','<=',$search['sailling_due_date']['to']);
        }

        if ($search['pick_up_dt']['from'] != null)
        {
            $query->where('pick_up_dt','>=',$search['pick_up_dt']['from']);
        }
        if ($search['pick_up_dt']['to'] != null)
        {
            $query->where('pick_up_dt','<=',$search['pick_up_dt']['to']);
        }

        if ($search['pol'] != null)
        {
            $query->where(DB::raw("CONCAT_WS( '' ,pol_1,pol_2)"), '=', $search['pol']);
        }

        if ($search['pod'] != null)
        {
            $query->where(DB::raw("CONCAT_WS( '' ,pod_1,pod_2)"), '=', $search['pol']);
        }
        return $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
    }

    /**
     * @param string|null $string
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function search(?string $string)
    {

        if ($string != '')
        {
            return $this->model->with(['containerBookings' => function($q) {
                $q->with('details', 'container');
            }])->where('booking_no', "{$string}")->first();
        }
        return [];

    }

}
