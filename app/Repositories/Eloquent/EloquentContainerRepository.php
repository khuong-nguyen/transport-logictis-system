<?php
namespace App\Repositories\Eloquent;

use App\Repositories\ContainerRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentContainerRepository extends EloquentBaseRepository implements ContainerRepository
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

    public function search(?string $string)
    {
        $query = $this->model->query();
        if ($string != ''){
            $query->where('container_code','LIKE', "%{$string}%");
        }
        return $query->orderBy('container_code', 'ASC')->get(['id','container_code as text'])->toArray();

    }
}
