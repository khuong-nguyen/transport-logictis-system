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
     * @param  CustomerRequest $request
     *
     */
    public function store(CustomerRequest $request)
    {
         $request = $request->all();
         $customerRequest =  $request['customer'];
         $customer =   $this->customerRepository->create($customerRequest);

         return redirect('/customer/registration/'.$customer->id);
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $customer =   $this->customerRepository->find($id);
        return view('customer.customer_create',compact('customer'));
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
        $customerRequest =  $request['customer'];
        $customer =   $this->customerRepository->update($this->customerRepository->find($id),$customerRequest);
        return view('customer.customer_create',compact('customer'));
    }
}