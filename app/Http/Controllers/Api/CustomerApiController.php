<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Customer;

class CustomerApiController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Create a new controller instance.

     * @param CustomerRepository $customerRepository
     *
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param  Request $request
     *
     * @return array
     */
    public function search(Request $request)
    {
        if($request->get('code'))
            {
                return $this->customerRepository->search($request->get('code'));
            }
    }
    
    public function autocompleteCustomerNo(Request $request){
        $data = Customer::select("customer_code as name")
        ->where("customer_code","LIKE","%{$request->input('query')}%")
        ->get();
        
        return response()->json($data);
    }
}
