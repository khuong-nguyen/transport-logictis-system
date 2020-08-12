<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

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
        if($request->get('country') && $request->get('code'))
            {
                return $this->customerRepository->search($request->get('country'), $request->get('code'));
            }
    }
}
