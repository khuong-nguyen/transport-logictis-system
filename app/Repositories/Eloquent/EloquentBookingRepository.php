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

    public function inquirySearch(Request $request)
    {
        $query = $this->model->query();

        $search = $request->get('search');

        if (isset($search['columns'])){
            foreach ($search['columns'] as $key => $value)
            {
                if ($value != null)
                {
                    $query->where($key,'=',$value);
                }
            }
        }

        if (isset($search['booking_no']) && $search['booking_no'] != null)
        {
                $booking_no = $search['booking_no'];
                $query->where('booking_no','LIKE', "$booking_no%");
                $query->orWhere('request_order_no','LIKE', "$booking_no%");
                $query->orWhere('virtual_booking_no','LIKE', "$booking_no%");
        }

        if (isset($search['shipper_customer_code']) && $search['shipper_customer_code'] != null)
        {
            $customer_code = $search['shipper_customer_code'];
            $query->whereHas('shipper',function($q)use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if (isset($search['consignee_customer_code']) && $search['consignee_customer_code'] != null)
        {
            $customer_code = $search['consignee_customer_code'];
            $query->whereHas('consignee',function($q) use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if (isset($search['forwarder_customer_code']) && $search['forwarder_customer_code'] != null)
        {
            $customer_code = $search['forwarder_customer_code'];
            $query->whereHas('forwarders',function($q) use ($customer_code){
                $q->where('customer_code', $customer_code);
            });
        }

        if (isset($search['sailling_due_date']) ){
            if ($search['sailling_due_date']['from'] != null)
            {
                $query->where('sailling_due_date','>=',$search['sailling_due_date']['from']);
            }
            if ($search['sailling_due_date']['to'] != null)
            {
                $query->where('sailling_due_date','<=',$search['sailling_due_date']['to']);
            }
        }

        if (isset($search['pick_up_dt'])){
            if ($search['pick_up_dt']['from'] != null)
            {
                $query->where('pick_up_dt','>=',$search['pick_up_dt']['from']);
            }
            if ($search['pick_up_dt']['to'] != null)
            {
                $query->where('pick_up_dt','<=',$search['pick_up_dt']['to']);
            }
        }


        if (isset($search['pol']) && $search['pol'] != null)
        {
            $query->where(DB::raw("CONCAT_WS( '' ,pol_1,pol_2)"), '=', $search['pol']);
        }

        if (isset($search['pod']) && $search['pod'] != null)
        {
            $query->where(DB::raw("CONCAT_WS( '' ,pod_1,pod_2)"), '=', $search['pod']);
        }
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param string|null $string
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function search(?string $string)
    {

        if ($string != '')
        {
            $result = $this->model->with(['containerBookings' => function($q) {
                $q->with(['details' => function($q) {
                    $q->with('schedules');
                }, 'container']);
            }])->where('booking_no', "{$string}")->first();
            
            return $result;
            
        }
        return [];

    }

    /**
     * @param string|null $string
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function fullSearch($params)
    {
        try {
            if (!empty($params))
            {
                $query = $this->model->with(['shipper', 'consignee', 'containerBookings' => function($q) {
                    $q->with(['details' => function($q) {
                        $q->with(['schedules' => function($q) {
                        }]);
                    }, 'container']);
                }]);
                
                if(!empty($params['booking_no'])){
                    $query = $query->where('booking_no', $params['booking_no'])
                                ->orWhere('request_order_no', $params['booking_no'] )
                                ->orWhere('virtual_booking_no', $params['booking_no'] );
                }
                
                if(!empty($params['bkg_created_date_from']) & !empty($params['bkg_created_date_to'])){
                    $params['bkg_created_date_from'] = Carbon::createFromFormat('d/m/Y', $params['bkg_created_date_from'])->format('Y-m-d');
                    $params['bkg_created_date_to'] = Carbon::createFromFormat('d/m/Y', $params['bkg_created_date_to'])->format('Y-m-d');
                    $query = $query->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$params['bkg_created_date_from'].
                        "' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '" . $params['bkg_created_date_to']."'"
                        );
                }
                
                $result = $query->get();

                return $result;
            }
            return [];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

}
