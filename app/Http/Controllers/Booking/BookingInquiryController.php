<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Repositories\BookingContainerRepository;
use App\Repositories\ContainerRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ConsigneeBookingRepository;
use App\Repositories\ShipperBookingRepository;
use App\Repositories\ForwarderBookingRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\BookingRegistrationRequest;

class BookingInquiryController extends Controller
{
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/booking';

    /**
     * Create a new controller instance.
     * @param BookingRepository $bookingRepository
     *
     * @return void
     */
    public function __construct(
        BookingRepository $bookingRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function index(Request $request)
    {

        if(request()->ajax())
        {
            $search = $request->get('search');
            if($search != null)
            {
                $data = $this->bookingRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->bookingRepository->serverPaginationFilteringFor($request);
            }
            return datatables()->of($data->items())
                ->with([
                    "recordsTotal"    => $data->total(),
                    "recordsFiltered" => $data->total(),
                ])
                ->editColumn('pol_1', function ($row) {
                    return $row->pol_1.$row->pol_2;
                })
                ->editColumn('pod_1', function ($row) {
                    return $row->pod_1.$row->pod_2;
                })
                ->addColumn('action', function($row){
                    $url = '/booking/registration/'.$row->id;
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('booking.booking_inquiry');
    }
}
