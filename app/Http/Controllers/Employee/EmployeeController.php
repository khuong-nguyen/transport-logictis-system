<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\EmployeeRequest;
use Carbon\Carbon;
use Hash;

class EmployeeController extends Controller
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
     * @return void
     */
    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //load default options for country_code
        $countryCodeOptions = [
            "VN" => "Viet Nam",
            "HK" => "Hong Kong"
        ];
        $countryCodeOptionDefault = "VN";

        //load default options for city
        $cityCodeOptions = [
            "SGN" => "Sai Gon",
            "HN" => "Ha Noi",
            "HP" => "Hai Phong"
        ];
        $cityCodeOptionDefault = "SGN";

        //load default options for department
        $departmentCodeOptions = [
            "DRIVER" => "Driver",
            "HR" => "Human Resource",
            "TRANSPORT" => "Transport",
            "ACCOUNTING" => "Accounting",
        ];
        $departmentCodeOptionDefault = "DRIVER";
        
        //load default options for sex
        $sexOptions = [
            "MALE" => "Male",
            "FEMALE" => "Female",
        ];
        $sexOptionDefault = "MALE";

        return view('employee.employee_create',[
            'countryCodeOptions' => $countryCodeOptions,
            'countryCodeOptionDefault' => $countryCodeOptionDefault,
            'cityCodeOptions' => $cityCodeOptions,
            'cityCodeOptionDefault' => $cityCodeOptionDefault,
            'departmentCodeOptions' => $departmentCodeOptions,
            'departmentCodeOptionDefault' => $departmentCodeOptionDefault,
            'sexOptions' => $sexOptions,
            'sexOptionDefault' => $sexOptionDefault
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest $request
     *
     */
    public function store(EmployeeRequest $request)
    {
         $request = $request->all();
         $employeeRequest =  $request['employee'];
         $employeeCode = $this->employeeRepository->employeeCode();

         $employeeRequest["employee_code"] = $employeeCode;
         
         $birthday = !empty($employeeRequest["birthday"])? Carbon::createFromFormat('d/m/Y', $employeeRequest["birthday"]) : null ;
         $employeeRequest["birthday"] = !empty($birthday) ? $birthday->format('Y-m-d'):null;
         
         $employee =   $this->employeeRepository->create($employeeRequest);
         
         $otp = '123456';
         $user = new User;
         $user->email = $employee->email;
         $user->name = $employee->employee_name;
         $user->password = Hash::make($otp);
         $user->employee_id = $employee->id;
         $user->save();
  
         $employee->update(['user_id' => $user->id]);

         return redirect('/employee/registration');
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $employee =   $this->employeeRepository->find($id);

        //load default options for country_code
        $countryCodeOptions = [
            "VN" => "Viet Nam",
            "HK" => "Hong Khong"
        ];
        $selectedCountryCodeOption = $employee->country_code;

        //load default options for city
        $cityCodeOptions = [
            "SGN" => "Sai Gon",
            "HN" => "Ha Noi",
            "HP" => "Hai Phong"
        ];

        $selectedCityCodeOption = $employee->city;

        //load default options for department
        $departmentCodeOptions = [
            "DRIVER" => "Driver",
            "HR" => "Human Resource",
            "TRANSPORT" => "Transport",
            "ACCOUNTING" => "Accounting",
        ];
        $selectedDepartmentCodeOption = $employee->department_code;
        
        //load default options for sex
        $sexOptions = [
            "MALE" => "Male",
            "FEMALE" => "Female"
        ];
        $selectedSexOption = $employee->sex;
        
        $birthday= !empty($employee->birthday) ? Carbon::createFromFormat('Y-m-d', $employee->birthday) : "";
        $employee->birthday = !empty($birthday) ? $birthday->format('d/m/Y') : "";
        
        return view('employee.employee_create',['employee' => $employee,
            'countryCodeOptions' => $countryCodeOptions,
            'selectedCountryCodeOption' => $selectedCountryCodeOption,
            'cityCodeOptions' => $cityCodeOptions,
            'selectedCityCodeOption' => $selectedCityCodeOption,
            'departmentCodeOptions' => $departmentCodeOptions,
            'selectedDepartmentCodeOption' => $selectedDepartmentCodeOption,
            'sexOptions' => $sexOptions,
            'selectedSexOption' => $selectedSexOption
        ]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(EmployeeRequest $request,$id)
    {
        $request = $request->all();
        
        $employeeRequest =  $request['employee'];
        
        $birthday = !empty($employeeRequest["birthday"])? Carbon::createFromFormat('d/m/Y', $employeeRequest["birthday"]) : null ;
        $employeeRequest["birthday"] = !empty($birthday) ? $birthday->format('Y-m-d'):null;
        
        $employee =   $this->employeeRepository->update($this->employeeRepository->find($id),$employeeRequest);

        if(empty($employee->user_id)){
            //find user by email
            $user = User::where('email', $employee->email)->first();
            
            if(!empty($user) && empty($user->employee_id)){
                // map user and employee
                $employee->update(['user_id' => $user->id]);
                $user->update(['employee_id' => $employee->id]);
            }else{
                // create new user.
                $otp = '123456';
                $user = new User;
                $user->email = $employee->email;
                $user->name = $employee->employee_name;
                $user->password = Hash::make($otp);
                $user->employee_id = $employee->id;
                $user->save();
                $employee->update(['user_id' => $user->id]);
            }
        }
        //load default options for country_code
        $countryCodeOptions = [
            "VN" => "Viet Nam",
            "HK" => "Hong Khong"
        ];
        $selectedCountryCodeOption = $employee->country_code;

        //load default options for city
        $cityCodeOptions = [
            "SGN" => "Sai Gon",
            "HN" => "Ha Noi",
            "HP" => "Hai Phong"
        ];

        $selectedCityCodeOption = $employee->city;

        //load default options for department
        $departmentCodeOptions = [
            "DRIVER" => "Driver",
            "HR" => "Human Resource",
            "TRANSPORT" => "Transport",
            "ACCOUNTING" => "Accounting",
        ];
        $selectedDepartmentCodeOption = $employee->department_code;
        
        //load default options for sex
        $sexOptions = [
            "MALE" => "Male",
            "FEMALE" => "Female"
        ];
        $selectedSexOption = $employee->sex;

        return view('employee.employee_create',['employee' => $employee,
            'countryCodeOptions' => $countryCodeOptions,
            'selectedCountryCodeOption' => $selectedCountryCodeOption,
            'cityCodeOptions' => $cityCodeOptions,
            'selectedCityCodeOption' => $selectedCityCodeOption,
            'departmentCodeOptions' => $departmentCodeOptions,
            'selectedDepartmentCodeOption' => $selectedDepartmentCodeOption,
            'sexOptions' => $sexOptions,
            'selectedSexOption' => $selectedSexOption
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) {
        if ($request->has('code') && $request->has('type')) {
            $data = $this->employeeRepository->search($request->all());
            if ($data) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => $data
                ], 200);
            }
            return response()->json([
                'error' => true,
                'message' => 'This driver was not found!',
                'data' => false
            ], 403);
        }
        return response()->json([
            'error' => true,
            'message' => 'This driver was not found!',
            'data' => false
        ], 403);
    }
}
