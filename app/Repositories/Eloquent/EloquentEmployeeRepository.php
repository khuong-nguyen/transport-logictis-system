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

    public function employeeCode($branchCode = 'HCM'){
        $employeeCode = $branchCode;
        $employeeCount = $this->model
            ->where('employee_code','LIKE',$branchCode.'%')
            ->count();
        
        $newCode = $employeeCount + 1;
        
        $numberCode = substr("00000".$newCode,strlen($newCode));
        $employeeCode .= $numberCode;

        return $employeeCode;
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
    
    public function inquirySearch(Request $request) :LengthAwarePaginator
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
        return $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
    }
}
