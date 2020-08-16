<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\EmployeeRequest;

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
        
        return view('employee.employee_create',['countryCodeOptions' => $countryCodeOptions,
                                                'countryCodeOptionDefault' => $countryCodeOptionDefault,
                                                'cityCodeOptions' => $cityCodeOptions,
                                                'cityCodeOptionDefault' => $cityCodeOptionDefault
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
         $employeeCount = $this->employeeRepository->countEmployee();
         
         $employeeRequest["employee_code"] = $employeeRequest["country_code"]. ($employeeCount + 1);
         $employee =   $this->employeeRepository->create($employeeRequest);

         return redirect('/employee/registration/'.$employee->id);
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
        
        return view('employee.employee_create',["employee" => $employee,
            'countryCodeOptions' => $countryCodeOptions,
            'selectedCountryCodeOption' => $selectedCountryCodeOption,
            'cityCodeOptions' => $cityCodeOptions,
            'selectedCityCodeOption' => $selectedCityCodeOption
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
        $employee =   $this->employeeRepository->update($this->employeeRepository->find($id),$employeeRequest);
        
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
        
        return view('employee.employee_create',["employee" => $employee,
            'countryCodeOptions' => $countryCodeOptions,
            'selectedCountryCodeOption' => $selectedCountryCodeOption,
            'cityCodeOptions' => $cityCodeOptions,
            'selectedCityCodeOption' => $selectedCityCodeOption
        ]);
    }
}