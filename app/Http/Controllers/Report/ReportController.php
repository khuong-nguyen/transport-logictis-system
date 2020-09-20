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
     * Create a new controller instance.
     * @return void
     */
    public function __construct(BookingRepository $bookingRepository,
        ShipperBookingRepository $shipperBookingRepository,
        ConsigneeBookingRepository $consigneeBookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository
        )
    {
        dd('11');
        $this->bookingRepository = $bookingRepository;
        $this->shipperBookingRepository = $shipperBookingRepository;
        $this->consigneeBookingRepository = $consigneeBookingRepository;
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
    }
    
    /**
     * @param   $request
     *
     * @return View
     */
    public function reportSalaryMonthlyForDriver(Request $request){
        
        $params = [];
        dd('333');
        return view('report.report_salary_monthly_driver',[
            'salary_monthly_driver' => $salary_monthly_driver,
            'params' => $params
        ]);
    }

}
