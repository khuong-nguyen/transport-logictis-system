<?php
namespace App\Repositories\Eloquent;

use App\Repositories\FixedAssetRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentFixedAssetRepository extends EloquentBaseRepository implements FixedAssetRepository
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
    
    public function countFixedAsset(){
        $fixedAssetCount = $this->model->get()->count();
        return $fixedAssetCount;
    }
}