<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
