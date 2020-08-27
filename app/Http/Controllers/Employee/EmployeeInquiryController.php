<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EmployeeInquiryController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/employee';

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

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $params = '';
            $search = $request->get('search');
            if($search != null)
            {
                if (isset($search['columns'])) {
                    $params = http_build_query($search['columns']);
                }
                $data = $this->employeeRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->employeeRepository->serverPaginationFilteringFor($request);
            }

            return datatables()->of($data->items())
                ->with([
                    "recordsTotal"    => $data->total(),
                    "recordsFiltered" => $data->total(),
                ])
                ->addColumn('action', function($row) use ($params) {
                    $url = '/employee/registration/'.$row->id.'?'.$params;
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('employee.employee_inquiry');
    }
}
