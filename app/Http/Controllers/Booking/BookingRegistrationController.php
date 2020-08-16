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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\BookingRegistrationRequest;

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
     *
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
        BookingContainerDetailRepository $bookingContainerDetailRepository
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
        $request = $request->all();
        $bookingRequest =  $request['booking'];

        $booking =   $this->bookingRepository->create($bookingRequest);

        $consignee = $this->customerRepository->find($bookingRequest['consignee_id'])->toArray();
        $shipper = $this->customerRepository->find($bookingRequest['shipper_id'])->toArray();
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
                $this->bookingContainerRepository->create($container);
            }
        }

        $consignee["booking_id"] = $booking->id;
        $shipper["booking_id"] = $booking->id;

        unset($consignee["id"]);
        unset($consignee["created_by"]);
        unset($consignee["updated_by"]);
        unset($consignee["created_at"]);
        unset($consignee["updated_at"]);
        unset($shipper["id"]);
        unset($shipper["created_by"]);
        unset($shipper["updated_by"]);
        unset($shipper["created_at"]);
        unset($shipper["updated_at"]);

        $this->consigneeBookingRepository->create($consignee);
        $this->shipperBookingRepository->create($shipper);

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
        $search = $booking->booking_no;
        $bookingContainerDetails = $this->bookingRepository->search($search,'');
        $bookingContainerDetails = $bookingContainerDetails?$bookingContainerDetails->toArray():[];
        $example = new BookingContainerDetail();
        $example = $example->attributesToArray();

        return view('booking.booking_registration_create',compact('booking','forwarder','consignee','shipper','containers', 'bookingContainerDetails', 'search', 'example'));
    }


    /**
     * @param BookingRegistrationRequest $request
     * @param   $id
     *
     */
    public function update(BookingRegistrationRequest $request,$id)
    {
        $booking = $this->bookingRepository->find($id);
        if ($request->has('save-container')) {
            try {
                $data = [];
                if ($booking->booking_status !== Booking::STATUS_APPROVED) {
                    $data = $this->bookingContainerDetailRepository->saveBooking($request);
                }
                return response()->json([
                    'error' => null,
                    'message' => 'Updated success!',
                    'data' => $data
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }

        }
        if ($request->has('confirm-booking')) {
            try {
                $data = [];
                if ($booking->booking_status !== Booking::STATUS_APPROVED) {
                    $data = $this->bookingRepository->update($booking, ['booking_status' => Booking::STATUS_APPROVED]);
                }

                return response()->json([
                    'error' => null,
                    'message' => 'Updated success!',
                    'data' => $data
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }

        }
        $url = $request->getRequestUri();
        $request = $request->all();
        $bookingRequest =  $request['booking'];
        $shipperRequest =  $request['shipper'];
        $consigneeRequest =  $request['consignee'];
        $forwarderRequest =  $request['forwarder'];

        $booking =   $this->bookingRepository->update($booking,$bookingRequest);

        $shipper =   $this->shipperBookingRepository->update($this->shipperBookingRepository->findByAttributes(['booking_id'=>$booking->id]),$shipperRequest);
        $consignee =   $this->consigneeBookingRepository->update($this->consigneeBookingRepository->findByAttributes(['booking_id'=>$booking->id]),$consigneeRequest);

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
                    $this->containerRepository->update($oldContainer,$container);

                }else{
                    $container['booking_id'] = $booking->id;
                    $container['container_id'] = $key;
                    $this->bookingContainerRepository->create($container);
                }
            }
        }
        return redirect($url)->with('status','message.save_success');
    }

    public function delete($id)
    {
        $booking = $this->bookingRepository->find($id);
        return $this->bookingRepository->destroy($booking);
    }
}
