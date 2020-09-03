<?php
namespace App\Repositories\Eloquent;

use App\Repositories\VirtualBookingRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentVirtualBookingRepository extends EloquentBaseRepository implements VirtualBookingRepository
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

    public function virtualBookingCode($branchCode = 'HCM'){
        $current_month = date("Ym");
        $virtualBookingCode = "VT".$branchCode.$current_month;
        $virtualBookingCount = $this->model
            ->where('virtual_booking_no','LIKE',$virtualBookingCode.'%')
            ->count();
        
        $newCode = $virtualBookingCount + 1;
        
        $numberCode = substr("00000".$newCode,strlen($newCode));
        $virtualBookingCode .= $numberCode;

        return $virtualBookingCode;
    }
}
