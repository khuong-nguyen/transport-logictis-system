<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BookingRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentBookingRepository extends EloquentBaseRepository implements BookingRepository
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

    /**
     * @param string|null $string
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function search(?string $string)
    {

        if ($string != '')
        {
            return $this->model->with(['containerBookings' => function($q) {
                $q->with('details', 'container');
            }])->where('booking_no', "{$string}")->first();
        }
        return [];

    }
}
