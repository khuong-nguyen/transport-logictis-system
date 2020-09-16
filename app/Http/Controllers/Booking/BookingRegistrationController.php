<?php

namespace App\Http\Controllers\Booking;

use App\Booking;
use App\BookingContainerDetail;
use App\Http\Controllers\Controller;
use App\Repositories\BookingContainerDetailRepository;
use App\Repositories\BookingContainerRepository;
use App\Repositories\ContainerRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ConsigneeBookingRepository;
use App\Repositories\ShipperBookingRepository;
use App\Repositories\ForwarderBookingRepository;
use App\Repositories\AdvanceMoneyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\BookingRegistrationRequest;
use App\RequestOrder;
use App\VirtualBooking;
use App\Repositories\RequestOrderRepository;
use App\Repositories\RequestOrderContainerRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\VirtualBookingRepository;
use App\Repositories\VirtualBookingContainerRepository;



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
     * @var ContainerRepository
     */
    private $containerRepository;

    /**
     * @var ShipperBookingRepository
     */
    private $shipperBookingRepository;

    /**
     * @var ForwarderBookingRepository
     */
    private $forwarderBookingRepository;

    /**
     * @var ConsigneeBookingRepository
     */
    private $consigneeBookingRepository;

    /**
     * @var BookingContainerRepository
     */
    private $bookingContainerRepository;

    /**
     * @var BookingContainerDetailRepository
     */
    private $bookingContainerDetailRepository;

    /**
     * @var AdvanceMoneyRepository
     */
    private $advanceMoneyRepository;
    
    /**
     * @var RequestOrderRepository
     */
    private $requestOrderRepository;
    
    /**
     * @var RequestOrderContainerRepository
     */
    private $requestOrderContainerRepository;
    
    /**
     * @var VirtualBookingRepository
     */
    private $virtualBookingRepository;

    /**
     * @var VirtualBookingContainerRepository
     */
    private $virtualBookingContainerRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/booking';

    /**
     * Create a new controller instance.
     * @param CustomerRepository $customerRepository
     * @param BookingRepository $bookingRepository
     * @param ContainerRepository $containerRepository
     * @param ConsigneeBookingRepository $consigneeBookingRepository
     * @param ShipperBookingRepository $shipperBookingRepository
     * @param ForwarderBookingRepository $forwarderBookingRepository
     * @param BookingContainerRepository $bookingContainerRepository
     * @param BookingContainerDetailRepository $bookingContainerDetailRepository
     * @param AdvanceMoneyRepository $advanceMoneyRepository
     * @param RequestOrderRepository $requestOrderRepository
     * @param RequestOrderContainerRepository $requestOrderContainerRepository
     * @param VirtualBookingRepository $virtualBookingRepository
     * @param VirtualBookingContainerRepository $virtualBookingContainerRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        BookingRepository $bookingRepository,
        ContainerRepository $containerRepository,
        ConsigneeBookingRepository $consigneeBookingRepository,
        ShipperBookingRepository $shipperBookingRepository,
        ForwarderBookingRepository $forwarderBookingRepository,
        BookingContainerRepository $bookingContainerRepository,
        BookingContainerDetailRepository $bookingContainerDetailRepository,
        AdvanceMoneyRepository $advanceMoneyRepository,
        RequestOrderRepository $requestOrderRepository,
        RequestOrderContainerRepository $requestOrderContainerRepository,
        VirtualBookingRepository $virtualBookingRepository,
        VirtualBookingContainerRepository $virtualBookingContainerRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->bookingRepository = $bookingRepository;
        $this->containerRepository = $containerRepository;
        $this->consigneeBookingRepository = $consigneeBookingRepository;
        $this->shipperBookingRepository = $shipperBookingRepository;
        $this->forwarderBookingRepository = $forwarderBookingRepository;
        $this->bookingContainerRepository = $bookingContainerRepository;
        $this->bookingContainerDetailRepository = $bookingContainerDetailRepository;
        $this->advanceMoneyRepository = $advanceMoneyRepository;
        $this->requestOrderRepository = $requestOrderRepository;
        $this->requestOrderContainerRepository = $requestOrderContainerRepository;
        
        $this->virtualBookingRepository = $virtualBookingRepository;
        $this->virtualBookingContainerRepository = $virtualBookingContainerRepository;
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
        $container = $this->containerRepository->all();
        return view('booking.booking_registration_create',compact('container'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookingRegistrationRequest $request
     *
     */
    public function store(BookingRegistrationRequest $request)
    {
        try{
            DB::beginTransaction();
            $request = $request->all();
            $bookingRequest =  $request['booking'];
            
            $booking =   $this->bookingRepository->create($bookingRequest);
            
            //Create Request Order
            unset($bookingRequest["booking_no"]);
            
            $bookingRequest['request_order_no'] = $this->requestOrderRepository->requestOrderCode('HCM');
            $request_order = RequestOrder::create($bookingRequest);
            
            //update request_order_id to booking
            //dd($request_order->request_order_no);
            $booking= $this->bookingRepository->update(
                $booking,
                ['request_order_id' => $request_order->id,
                'request_order_no' => $request_order->request_order_no
            ]);
            
            if ($bookingRequest['shipper_id'] != null){
                $shipper = $this->customerRepository->find($bookingRequest['shipper_id'])->toArray();
                unset($shipper["id"]);
                unset($shipper["created_by"]);
                unset($shipper["updated_by"]);
                unset($shipper["created_at"]);
                unset($shipper["updated_at"]);
                
                $shipper["booking_id"] = $booking->id;
                $this->shipperBookingRepository->create($shipper);
            }
            
            if ($bookingRequest['consignee_id'] != null){
                $consignee = $this->customerRepository->find($bookingRequest['consignee_id'])->toArray();
                unset($consignee["id"]);
                unset($consignee["created_by"]);
                unset($consignee["updated_by"]);
                unset($consignee["created_at"]);
                unset($consignee["updated_at"]);
                
                $consignee["booking_id"] = $booking->id;
                $this->consigneeBookingRepository->create($consignee);
            }
            
            if ($bookingRequest['forwarder_id'] != null)
            {
                $forwarder = $this->customerRepository->find($bookingRequest['forwarder_id'])->toArray();
                unset($forwarder["id"]);
                unset($forwarder["created_by"]);
                unset($forwarder["updated_by"]);
                unset($forwarder["created_at"]);
                unset($forwarder["updated_at"]);
                
                $forwarder["booking_id"] = $booking->id;
                $this->forwarderBookingRepository->create($forwarder);
            }
            
            if (isset($request['container']))
            {
                foreach ($request['container'] as $key => $container)
                {
                    $container['booking_id'] = $booking->id;
                    $container['container_id'] = $key;
                    $container['container_code'] = $container['text'];
                    $this->bookingContainerRepository->create($container);
                    
                    $container['request_order_id'] = $request_order->id;
                    $container['container_id'] = $key;
                    $container['container_code'] = $container['text'];
                    $this->requestOrderContainerRepository->create($container);
                    
                }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => false
            ], 403);
        }
        
        return redirect('/booking/registration/'.$booking->id)->with('status','message.save_success');
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $booking =   $this->bookingRepository->find($id);
        $forwarder =   $this->forwarderBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
        $shipper =   $this->shipperBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
        $consignee =   $this->consigneeBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
        $containers =   $this->bookingContainerRepository->getWithContainerByBookingId($booking->id);
        $search = !empty($booking->booking_no) ? $booking->booking_no : (!empty($booking->virtual_booking_no) ? $booking->virtual_booking_no : $booking->request_order_no );
        $bookingContainerDetails = $this->bookingRepository->search($search,'');
        $bookingContainerDetails = $bookingContainerDetails?$bookingContainerDetails->toArray():[];

        $advanceMoneyBookingDetails['booking'] = $booking;

        $advanceMoneyBookingDetails['advance_money_bookings'] = $this->advanceMoneyRepository->advanceMoneyForBooking($booking->id);

        $example = new BookingContainerDetail();
        $example = $example->attributesToArray();
        $statusApproved = Booking::STATUS_APPROVED;

        return view('booking.booking_registration_create',compact('booking','forwarder','consignee','shipper','containers', 'bookingContainerDetails', 'search', 'example', 'statusApproved','advanceMoneyBookingDetails'));
    }


    /**
     * @param BookingRegistrationRequest $request
     * @param   $id
     *
     */
    public function update(BookingRegistrationRequest $request,$id)
    {
        try{
            DB::beginTransaction();
            $booking = $this->bookingRepository->find($id);
            $url = $request->getRequestUri();
            $request = $request->all();
            $bookingRequest =  $request['booking'];
            $shipperRequest =  $request['shipper'];
            $consigneeRequest =  $request['consignee'];
            $forwarderRequest =  $request['forwarder'];
            
            $booking =   $this->bookingRepository->update($booking,$bookingRequest);
            $request_order = RequestOrder::where('id',$booking->request_order_id)->first();
            
            if(!empty($booking->request_order_id) && $booking->booking_status == "ORDER"){

                //update request_order
                
                unset($bookingRequest["booking_no"]);
                $bookingRequest["id"] = $booking->request_order_id;
                $request_order->update($bookingRequest);
                
            }
            
            if(empty($booking->virtual_booking_id) && $booking->booking_status == "VIRTUAL"){
                //Create Virtual Booking
                unset($bookingRequest["booking_no"]);
                
                $bookingRequest['virtual_booking_no'] = $this->virtualBookingRepository->virtualBookingCode('HCM');
                $virtual_booking = VirtualBooking::create($bookingRequest);
                
                //update virtual_booking_id to booking
                
                $booking= $this->bookingRepository->update(
                    $booking,
                    ['virtual_booking_id' => $virtual_booking->id,
                     'virtual_booking_no' => $virtual_booking->virtual_booking_no
                    ]);
                
            }elseif(!empty($booking->virtual_booking_id) && $booking->booking_status == "VIRTUAL"){
                //update virtual_booking
                $virtual_booking = VirtualBooking::where('id',$booking->virtual_booking_id)->first();
                
                unset($bookingRequest["booking_no"]);
                $bookingRequest["id"] = $booking->virtual_booking_id;
                $virtual_booking->update($bookingRequest);
            }
            
            if ($bookingRequest['shipper_id'] != null){
                $shipper = $this->shipperBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
                if ($shipper){
                    $this->shipperBookingRepository->update($shipper,$shipperRequest);
                }else{
                    $shipper = $this->customerRepository->find($bookingRequest['shipper_id'])->toArray();
                    
                    unset($shipper["id"]);
                    unset($shipper["created_by"]);
                    unset($shipper["updated_by"]);
                    unset($shipper["created_at"]);
                    unset($shipper["updated_at"]);
                    
                    $shipper['booking_id'] = $booking->id;
                    $this->shipperBookingRepository->create($shipper);
                }
            }
            
            
            if ($bookingRequest['consignee_id'] != null){
                
                $consignee = $this->consigneeBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
                
                if ($consignee){
                    $this->consigneeBookingRepository->update($consignee,$consigneeRequest);
                }else{
                    $consignee = $this->customerRepository->find($bookingRequest['consignee_id'])->toArray();
                    
                    unset($consignee["id"]);
                    unset($consignee["created_by"]);
                    unset($consignee["updated_by"]);
                    unset($consignee["created_at"]);
                    unset($consignee["updated_at"]);
                    
                    $consignee['booking_id'] = $booking->id;
                    $this->consigneeBookingRepository->create($consignee);
                    
                }
            }
            
            if ($bookingRequest['forwarder_id'] != null){
                $forwarder = $this->forwarderBookingRepository->findByAttributes(['booking_id'=>$booking->id]);
                if ($forwarder){
                    $this->forwarderBookingRepository->update($forwarder,$forwarderRequest);
                }else{
                    $forwarder = $this->customerRepository->find($bookingRequest['forwarder_id'])->toArray();
                    
                    unset($forwarder["id"]);
                    unset($forwarder["created_by"]);
                    unset($forwarder["updated_by"]);
                    unset($forwarder["created_at"]);
                    unset($forwarder["updated_at"]);
                    
                    $forwarder['booking_id'] = $booking->id;
                    $this->forwarderBookingRepository->create($forwarder);
                    
                }
            }
            if (isset($request['container']))
            {
                
                foreach ($request['container'] as $key => $container)
                {
                    if (isset($container['id'])){
                        $oldContainer = $this->bookingContainerRepository->find($container['id']);
                        $this->bookingContainerRepository->update($oldContainer,$container);
                        
                        if($booking->booking_status == "ORDER"){
                            
                            $oldRequestOrderContainer = $this->requestOrderContainerRepository->findByAttributes(["container_code" => $oldContainer->container_code,
                                "request_order_id" => $request_order->id
                            ]);
                            
                            $this->requestOrderContainerRepository->update($oldRequestOrderContainer,$container);
                        }
                        if($booking->booking_status == "VIRTUAL"){
                            
                            $oldVirtualBookingContainer = $this->virtualBookingContainerRepository->findByAttributes(["container_code" => $oldContainer->container_code,
                                "virtual_booking_id" => $booking->virtual_booking_id
                            ]);
                            if(!empty($oldVirtualBookingContainer)){
                                $this->virtualBookingContainerRepository->update($oldVirtualBookingContainer,$container);
                            }else{
                                $container['virtual_booking_id'] = $booking->virtual_booking_id;
                                $container['container_id'] = $key;
                                $container['container_code'] = $container['text'];
                                $this->virtualBookingContainerRepository->create($container);
                            }
                            
                        }
                        
                        
                    }else{
                        $container['booking_id'] = $booking->id;
                        $container['container_id'] = $key;
                        $container['container_code'] = $container['text'];
                        $this->bookingContainerRepository->create($container);
                        
                        if($booking->booking_status == "ORDER"){
                            $container['request_order_id'] = $request_order->id;
                            $container['container_id'] = $key;
                            $container['container_code'] = $container['text'];
                            $this->requestOrderContainerRepository->create($container);
                        }
                        
                        if($booking->booking_status == "VIRTUAL"){
                            $container['virtual_booking_id'] = $booking->virtual_booking_id;
                            $container['container_id'] = $key;
                            $container['container_code'] = $container['text'];
                            $this->virtualBookingContainerRepository->create($container);
                        }
                    }
                }
            }
            
            if(!empty($request['deletedBookingContainer'])){
                $deletedBookingContainers = json_decode($request['deletedBookingContainer']);
                
                foreach ($deletedBookingContainers as $key => $container_id)
                {
                    if(!empty($container_id)){
                        
                        $deletedBookingContainer = $this->bookingContainerRepository->findByAttributes(["container_id" =>$container_id,
                            "booking_id" => $booking->id
                        ]);
                        
                        if(!empty($deletedBookingContainer)){
                            $deletedBookingContainer->delete();
                        }
                        
                        if($booking->booking_status == "ORDER"){
                            
                            $deletedRequestOrderContainer = $this->requestOrderContainerRepository->findByAttributes(
                                ["container_id" => $container_id,
                                "request_order_id" => $request_order->id
                            ]);
                            
                            if(!empty($deletedRequestOrderContainer)){
                                $deletedRequestOrderContainer->delete();
                            }
                        }
                        
                        if($booking->booking_status == "VIRTUAL"){
                            
                            $deletedVirtuakBookingContainer = $this->virtualBookingContainerRepository->findByAttributes(
                                ["container_id" => $container_id,
                                    "virtual_booking_id" => $booking->virtual_booking_id
                                ]);
                            
                            if(!empty($deletedVirtuakBookingContainer)){
                                $deletedVirtuakBookingContainer->delete();
                            }
                        }
                    }
                    
                }
            }
            DB::commit();
            return redirect($url)->with('status','message.save_success');
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => false
            ], 403);
        }
    }

    public function delete($id)
    {
        $booking = $this->bookingRepository->find($id);
        return $this->bookingRepository->destroy($booking);
    }
}
