<?php
namespace App\Repositories\Eloquent;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCustomerRepository extends EloquentBaseRepository implements CustomerRepository
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function serverPaginationFilteringFor(Request $request) : LengthAwarePaginator
    {
        $categories = $this->allWithBuilder();

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $categories->orderBy($request->get('order_by'), $order);
        } else {
            $categories->orderBy('created_at', 'desc');
        }
        return $categories->paginate($request->get('per_page', 10));
    }

    public function search(string $country, string $code)
    {
        $query =  $this->model->query()->where('customer_code','=',$country.$code)->first();
        return $query ? $query->first() :[];
    }

    public function countCustomer(){
        $customerCount = $this->model->get()->count();
        return $customerCount;
    }

    public function inquirySearch(Request $request) :LengthAwarePaginator
    {
        $query = $this->model->query();

        $search = $request->get('search');

        if (isset($search['columns'])) {
            foreach ($search['columns'] as $key => $value)
            {
                if ($value != null)
                {
                    $query->where($key,'=',$value);
                }
            }
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

        if (isset($search['sailling_due_date'])) {
            if ($search['sailling_due_date']['from'] != null)
            {
                $query->where('sailling_due_date','>=',$search['sailling_due_date']['from']);
            }
            if ($search['sailling_due_date']['to'] != null)
            {
                $query->where('sailling_due_date','<=',$search['sailling_due_date']['to']);
            }
        }

        if (isset($search['pick_up_dt'])) {
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
            $query->where(DB::raw("CONCAT_WS( '' ,pod_1,pod_2)"), '=', $search['pol']);
        }
        return $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
    }

}
