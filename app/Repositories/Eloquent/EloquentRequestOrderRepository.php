<?php
namespace App\Repositories\Eloquent;

use App\Repositories\RequestOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentRequestOrderRepository extends EloquentBaseRepository implements RequestOrderRepository
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

    public function requestOrderCode($branchCode = 'HCM'){
        $current_month = date("Ym");
        $requestOrderCode = "RO".$branchCode.$current_month;
        $requestOrderCount = $this->model
            ->where('request_order_no','LIKE',$requestOrderCode.'%')
            ->count();
        
        $newCode = $requestOrderCount + 1;
        
        $numberCode = substr("00000".$newCode,strlen($newCode));
        $requestOrderCode .= $numberCode;

        return $requestOrderCode;
    }
}
