<?php

namespace App\Http\Controllers\PrintDocument;

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

class PrintDocumentController extends Controller
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
     * Create a new controller instance.
     * @return void
     */
    public function __construct(BookingRepository $bookingRepository,
        ShipperBookingRepository $shipperBookingRepository,
        ConsigneeBookingRepository $consigneeBookingRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository
        )
    {
        $this->bookingRepository = $bookingRepository;
        $this->shipperBookingRepository = $shipperBookingRepository;
        $this->consigneeBookingRepository = $consigneeBookingRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
    }
    
    /**
     * @param   $booking_id
     *
     * @return View
     */
    public function printBooking($booking_id){
        $booking =   $this->bookingRepository->find($booking_id);
        $booking_shipper = $this->shipperBookingRepository->findByAttributes(['booking_id'=> $booking->id]);
        
        $booking_consignee = $this->consigneeBookingRepository->findByAttributes(['booking_id'=> $booking->id]);
        
        $booking_container_details = $this->bookingContainerDetailRepository->getBookingContainerDetailByBookingId($booking->id);
        //dd($booking_container_details);
        $detail_booking = view('print_booking.detail_booking',compact('booking','booking_shipper','booking_consignee','booking_container_details') )->render();
        
        return view('print_booking.print_booking',[
            'booking' => $booking ,
            'detail_booking' => $detail_booking]);
    }

}
