<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer';

    /**
     * Create a new controller instance.
     * @param CustomerRepository $customerRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
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
        return view('customer.customer_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookingRegistrationRequest $request
     *
     */
    public function store(BookingRegistrationRequest $request)
    {
         $request = $request->all();
         $bookingRequest =  $request['booking'];
         $booking =   $this->bookingRepository->create($bookingRequest);

        return redirect('/booking/registration/'.$booking->id);
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $booking =   $this->bookingRepository->find($id);
        return view('booking.booking_registration_create',compact('booking'));
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(Request $request,$id)
    {
        $request = $request->all();
        $bookingRequest =  $request['booking'];
        $booking =   $this->bookingRepository->update($this->bookingRepository->find($id),$bookingRequest);
        return view('booking.booking_registration_create',compact('booking'));
    }
}