<?php
namespace App\Repositories\Eloquent;

use App\Repositories\RefundMoneyRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentRefundMoneyRepository extends EloquentBaseRepository implements RefundMoneyRepository
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
    
    public function refundMoneyCode():string{
        
        $currentMonth = date('m');
        $currentYear = date('Y');

        $refundMoneyCode = $currentYear.$currentMonth;
        
        $refundMoneyCodeInMonthCount = $this->model
            ->whereYear('created_at',$currentYear)
            ->whereMonth('created_at',$currentMonth)
            ->count();
            
        $newCode = $refundMoneyCodeInMonthCount + 1;
        $numberCode = substr("00000".$newCode,strlen($newCode));
        $refundMoneyCode .= $numberCode;
        
        return $refundMoneyCode;
    }
    
    public function refundMoneyForBooking($booking_id){
        return $this->model->where('booking_id',$booking_id)->get();
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
        return $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
    }

}
