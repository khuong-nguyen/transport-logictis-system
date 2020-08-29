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

    public function search($data) {
        return $this->model->where(['fixed_asset_code' => $data['code'], 'fixed_asset_type' => $data['type']])->first();
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
        //return $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
        return $query->orderBy('created_at', 'desc')->get();
    }
}
