<?php
namespace App\Repositories\Eloquent;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentEmployeeRepository extends EloquentBaseRepository implements EmployeeRepository
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

    public function countEmployee(){
        $employeeCount = $this->model->get()->count();
        return $employeeCount;
    }
    
    public function getEmployeeByEmployeeCode(?string $employeeCode)
    {
        
        if ($employeeCode != '')
        {
            return $this->model->where('employee_code', "{$employeeCode}")->first();
        }
        return [];
        
    }

    public function search($data) {
        return $this->model->where(['employee_code' => $data['code'], 'department_code' => $data['type']])->first();
    }
}
