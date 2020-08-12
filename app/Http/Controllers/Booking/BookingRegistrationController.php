<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Repositories\BookingRepository;
use Illuminate\View\View;

class BookingRegistrationController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

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
     *
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository,BookingRepository $bookingRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->bookingRepository = $bookingRepository;
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
        return view('booking.booking_registration_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return View
     */
    public function store(Request $request)
    {
         $request = $request->all();
         $bookingRequest =  $request['booking'];
         $booking =   $this->bookingRepository->create($bookingRequest);

         return view('booking.booking_registration_create',compact('booking'));
    }
}
