<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransportScheduleRequest;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\FixedAssetRepository;
use App\Repositories\ScheduleTransportContainerRepository;
use App\ScheduleTransportContainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportScheduleInquiryController extends Controller
{
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * @var BookingContainerDetailRepository
     */
    private $bookingContainerDetailRepository;

    /**
     * @var ScheduleTransportContainerRepository
     */
    private $scheduleTransportContainerRepository;

    /**
     * @var FixedAssetRepository
     */
    private $fixedAssetRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * Create a new controller instance.
     * @param BookingRepository $bookingRepository
     * @param BookingContainerDetailRepository $bookingContainerDetailRepository
     * @return void
     */
    public function __construct(
        BookingRepository $bookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        ScheduleTransportContainerRepository $scheduleTransportContainerRepository,
        FixedAssetRepository $fixedAssetRepository,
        EmployeeRepository $employeeRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
        $this->scheduleTransportContainerRepository = $scheduleTransportContainerRepository;
        $this->fixedAssetRepository = $fixedAssetRepository;
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
                $data = $this->scheduleTransportContainerRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->scheduleTransportContainerRepository->serverPaginationFilteringFor($request);
            }

            return datatables()->of($data->items())
                ->with([
                    "recordsTotal"    => $data->total(),
                    "recordsFiltered" => $data->total(),
                ])
                ->editColumn('router', function($row) {
                    return '{'.$row->por_1.'}'.'{'.$row->por_2.'}'.'{'.$row->pol_1.'}'.'{'.$row->pol_2.'} ~ '.'{'.$row->pod_1.'}'.'{'.$row->pod_2.'}'.'{'.$row->del_1.'}'.'{'.$row->del_2.'}';
                })
                ->editColumn('eta', function($row) {
                    return $row->eta?Carbon::parse($row->eta)->format('d/m/Y H:i:s'):'';
                })
                ->editColumn('etd', function($row) {
                    return $row->etd?Carbon::parse($row->etd)->format('d/m/Y H:i:s'):'';
                })
                ->addColumn('action', function($row) use ($params) {
                    $url = '/booking/transport/schedule/registration?bookingNo='.$row->booking_no.'&'.$params;
                    if (!$row->booking_container_detail_id) {
                        return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Schedule</a>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transport.schedule.inquiry');
    }
}
