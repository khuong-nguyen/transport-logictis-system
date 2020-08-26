<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\BookingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;

class BookingApiController extends BaseApiController
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
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $booking = $this->bookingRepository->search($request->get('search',''));
            if ($booking) {
                return $this->success($booking);
            }
            return $this->error('Booking not found');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }
    
    /**
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooking($booking_id)
    {
        try {
            
            $booking = $this->bookingRepository->find($booking_id);
            if ($booking) {
                return $this->success($booking);
            }
            return $this->error('Booking not found');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        
    }
    
    public function autoCompleteBookingNo(Request $request){
        $data = Booking::select("booking_no as name")
                    ->where("booking_no","LIKE","%{$request->input('query')}%")
                    ->get();
                    
        return response()->json($data);
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
