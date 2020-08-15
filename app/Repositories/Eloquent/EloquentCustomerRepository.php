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
        $query =  $this->model->query()->where('customer_code','=',$country.$code);

        return $query ? $query->first() :[];
    }

}
