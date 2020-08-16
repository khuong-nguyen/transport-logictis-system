<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CustomerInquiryController extends Controller
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
     *
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(Request $request)
    {

        if(request()->ajax())
        {
            $search = $request->get('search');
            if($search != null)
            {
                $data = $this->customerRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->customerRepository->serverPaginationFilteringFor($request);
            }
            return datatables()->of($data->items())
                ->with([
                    "recordsTotal"    => $data->total(),
                    "recordsFiltered" => $data->total(),
                ])
                ->editColumn('pol_1', function ($row) {
                    return $row->pol_1.$row->pol_2;
                })
                ->editColumn('pod_1', function ($row) {
                    return $row->pod_1.$row->pod_2;
                })
                ->addColumn('action', function($row){
                    $url = '/customer/registration/'.$row->id;
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('customer.customer_inquiry');
    }
}