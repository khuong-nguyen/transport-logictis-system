<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use Illuminate\Http\Request;

class BookingContainerRegistrationController extends Controller
{
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $search = '';
        if ($request->has('search')) {
            $search = $request->get('search');
            $bookingContainerDetails = $this->bookingRepository->search($search,'');
            $bookingContainerDetails = $bookingContainerDetails?$bookingContainerDetails:[];
        }
        $container = $this->bookingRepository->all();
        return view('transport.booking_container_registration_create',compact('bookingContainerDetails', 'container', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking =  $this->bookingRepository->find($id);
        return view('transport.booking_container_registration_create', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
