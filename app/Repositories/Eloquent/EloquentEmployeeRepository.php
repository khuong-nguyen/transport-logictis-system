<?php
namespace App\Repositories\Eloquent;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Helpers\DateFunctionHelper;

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
    
    public function salaryMonthlyForDriverSearch($params){
        
        $salary_monthly_driver = [];
        try {
            if (!empty($params))
            {
                if(!empty($params['salary_month_from']) & !empty($params['salary_month_to'])){
                    
                    $query = $this->model->with(['scheduleTransportContainer' => function($q) use($params){
                            $params['salary_month_from'] = Carbon::createFromFormat('m/Y', $params['salary_month_from'])->format('Y-m');
                            $params['salary_month_to'] = Carbon::createFromFormat('m/Y', $params['salary_month_to'])->format('Y-m');
                            $q->whereRaw("DATE_FORMAT(pickup_plan,'%Y-%m') >= '".$params['salary_month_from'].
                                "' AND DATE_FORMAT(pickup_plan,'%Y-%m') <= '" . $params['salary_month_to']."'"
                                );
                    }]); 
                    
                        
                    if(!empty($params['driver_code'])){
                        $query = $query->where('employee_code', $params['driver_code']);
                    }
                    
                    if(!empty($params['driver_name'])){
                        $query = $query->where('employee_name', $params['driver_name']);
                    }
                    
                    $query = $query->where('department_code', "DRIVER");
                    
                    $result = $query->get();
                    $dateFunctionHelper = new DateFunctionHelper;
                    
                    $salary_month_from = Carbon::createFromFormat('m/Y', $params['salary_month_from'])->format('Y-m');
                    $salary_month_to = Carbon::createFromFormat('m/Y', $params['salary_month_to'])->format('Y-m');
                    $monthCount = $dateFunctionHelper->monthCount($salary_month_from."-01", $salary_month_to."-01");
                    
                    foreach($result as $key =>$employee){
                        $basic_salary = $employee->basic_salary;
                        $salary_monthly_driver[$key]["driver_code"] = $employee->employee_code;
                        $salary_monthly_driver[$key]["driver_name"] = $employee->employee_name;
                        $salary_monthly_driver[$key]["basic_salary"] = number_format($basic_salary * $monthCount);
                        $salary_monthly_driver[$key]["transport_total"] = count($employee->scheduleTransportContainer);
                        $transport_salary = 0;
                        foreach($employee->scheduleTransportContainer as $transport){
                            $transport_salary = $transport_salary + $transport->transport_cost;
                        }
                        $salary_monthly_driver[$key]["transport_salary"] = number_format($transport_salary);
                        $salary_monthly_driver[$key]["salary_total"] = number_format($transport_salary + ($basic_salary * $monthCount));
                        $salary_monthly_driver[$key]["month"] = $params['salary_month_from'] . ' ~ ' .$params['salary_month_to'];
                    }

                }else{
                    return $salary_monthly_driver;
                }
                
                return $salary_monthly_driver;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }      
    }
}
