<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransportScheduleRegistrationController extends Controller
{
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
    public function create()
    {
        $bookingNo = '';
        $bookingContainerDetails = [];
        $example = [];
        $statusApproved = Booking::STATUS_APPROVED;
        if ($request->has('search')) {
            $search = $request->get('search');
            $bookingContainerDetails = $this->bookingRepository->search($search,'');

            if ($bookingContainerDetails) {
                $bookingContainerDetails = $bookingContainerDetails->toArray();
                $example = new BookingContainerDetail();
                $example = $example->attributesToArray();
                return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'));
            }
            return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'))->with('searchError', 'Could not find this Booking No.');
        }
        return view('transport.booking_container_registration_create', compact('bookingContainerDetails', 'search', 'example', 'statusApproved'));
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
        //
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
