<?php
namespace App\Repositories\Eloquent;

use App\Repositories\AdvanceMoneyRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentAdvanceMoneyRepository extends EloquentBaseRepository implements AdvanceMoneyRepository
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
    
    public function advanceMoneyCode():string{
        
        $currentMonth = date('m');
        $currentYear = date('Y');

        $advanceMoneyCode = $currentYear.$currentMonth;
        
        $advanceMoneyCodeInMonthCount = $this->model
            ->whereYear('created_at',$currentYear)
            ->whereMonth('created_at',$currentMonth)
            ->count();
            
        $newCode = $advanceMoneyCodeInMonthCount + 1;
        $numberCode = substr("00000".$newCode,strlen($newCode));
        $advanceMoneyCode .= $numberCode;
        
        return $advanceMoneyCode;
    }
    
    public function advanceMoneyForBooking($booking_id){
        return $this->model->where('booking_id',$booking_id)->get();
    }

}
