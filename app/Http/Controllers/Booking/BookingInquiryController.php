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
            if(!empty($request->filter_gender))
            {
                $data = $this->bookingRepository->serverPaginationFilteringFor($request);
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
                ->addColumn('action', function($row){
                    return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('booking.booking_inquiry');
    }
}
