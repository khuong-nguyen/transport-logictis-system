<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Repositories\BookingRepository;
use App\Repositories\ShipperBookingRepository;
use App\Repositories\ConsigneeBookingRepository;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\ScheduleTransportContainerRepository;
use App\Repositories\EmployeeRepository;
use App\Employee;

class ReportController extends Controller
{

    /**
     * @var BookingRepository
     */
    private $bookingRepository;
    
    /**
     * @var ShipperBookingRepository
     */
    private $shipperBookingRepository;
    
    /**
     * @var ConsigneeBookingRepository
     */
    private $consigneeBookingRepository;
    
    /**
     * @var BookingContainerDetailRepository
     */
    private $bookingContainerDetailRepository;
    
    /**
     * @var ScheduleTransportContainerRepository
     */
    private $scheduleTransportContainerRepository;
    
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;
    
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(BookingRepository $bookingRepository,
        ShipperBookingRepository $shipperBookingRepository,
        ConsigneeBookingRepository $consigneeBookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        ScheduleTransportContainerRepository $scheduleTransportContainerRepository,
        EmployeeRepository $employeeRepository
        )
    {
        
        $this->bookingRepository = $bookingRepository;
        $this->shipperBookingRepository = $shipperBookingRepository;
        $this->consigneeBookingRepository = $consigneeBookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
        $this->employeeRepository = $employeeRepository;
    }
    
    /**
     * @param   $request
     *
     * @return View
     */
    public function reportSalaryMonthlyForDriver(Request $request){
        
        $params = [];
        
        if($request->has('salary_month_from')){
            $params['salary_month_from'] = $request->salary_month_from;
        }else{
            $params['salary_month_from'] = date("m/Y");
        }
        
        if($request->has('salary_month_to')){
            $params['salary_month_to'] = $request->salary_month_to;
        }else{
            $params['salary_month_to'] = date("m/Y");
        }
        
        if($request->has('driver_code')){
            $params['driver_code'] = $request->driver_code;
        }else{
            $params['driver_code'] = '';
        }
        
        if($request->has('driver_name')){
            $params['driver_name'] = $request->driver_name;
        }else{
            $params['driver_name'] = '';
        }
        
        $salary_monthly_driver = $this->employeeRepository->salaryMonthlyForDriverSearch($params);
        
        return view('report.report_salary_monthly_driver',[
            'salary_monthly_driver' => $salary_monthly_driver,
            'params' => $params
        ]);
    }

}
