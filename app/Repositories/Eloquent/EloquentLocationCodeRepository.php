<?php
namespace App\Repositories\Eloquent;

use App\Repositories\LocationCodeRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentLocationCodeRepository extends EloquentBaseRepository implements LocationCodeRepository
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
    
    public function inquirySearch(Request $request)
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
        return $query->orderBy('created_at', 'desc')->get();
    }
}
