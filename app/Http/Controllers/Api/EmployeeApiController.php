<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use App\Employee;

class EmployeeApiController extends BaseApiController
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * Create a new controller instance.
     * @param EmployeeRepository $employeeRepository
     *
     * @return void
     */
    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeByEmployeeCode(Request $request)
    {
        try {
            $employee = $this->employeeRepository->getEmployeeByEmployeeCode($request->get('employeeCode',''));
            if ($employee) {
                return $this->success($employee);
            }
            return $this->error('Employee not found');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    public function autoCompleteDriverNo(Request $request){
        $data = Employee::select("employee_code as name")
        ->where("employee_code","LIKE","%{$request->input('query')}%")
        ->where("department_code","DRIVER")
        ->get();
        
        return response()->json($data);
    }
}
