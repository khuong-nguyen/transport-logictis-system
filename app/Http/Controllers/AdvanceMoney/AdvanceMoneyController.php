<?php

namespace App\Http\Controllers\AdvanceMoney;

use App\AdvanceMoney;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AdvanceMoneyRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\AdvanceMoneyRequest;

class AdvanceMoneyController extends Controller
{
    /**
     * @var AdvanceMoneyRepository
     */
    private $advanceMoneyRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/advance_money';

    /**
     * Create a new controller instance.
     * @param AdvanceRepository $advanceMoneyRepository
     * @return void
     */
    public function __construct(
        AdvanceMoneyRepository $advanceMoneyRepository
    )
    {
        $this->advanceMoneyRepository = $advanceMoneyRepository;
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
        //load default options for advance_money_type
        $advanceMoneyTypeOptions = [
            "BOOKING" => "Booking",
            "OTHER" => "Other"
        ];
        $advanceMoneyTypeOptionDefault = "BOOKING";
        
        return view('advance_money.advance_money_create',[
            'advanceMoneyTypeOptions' => $advanceMoneyTypeOptions,
            'advanceMoneyTypeOptionDefault' => $advanceMoneyTypeOptionDefault
            
        ]);
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
         $customerCount = $this->customerRepository->countCustomer();

         $customerRequest["customer_code"] = $customerRequest["country_code"]. ($customerCount + 1);
         $customerRequest["location_code"] = $customerRequest["country_code"]. $customerRequest["city"];
         $customer =   $this->customerRepository->create($customerRequest);

         return redirect('/customer/registration/'.$customer->id);
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $params = http_build_query($request->all());
        $customer =   $this->customerRepository->find($id);
        //load default options for country_code
        $countryCodeOptions = [
            "VN" => "Viet Nam",
            "HK" => "Hong Khong"
        ];
        $selectedCountryCodeOption = $customer->country_code;

        //load default options for city
        $cityCodeOptions = [
            "SGN" => "Sai Gon",
            "HN" => "Ha Noi",
            "HP" => "Hai Phong"
        ];

        $selectedCityCodeOption = $customer->city;

        return view('customer.customer_create',["customer" => $customer,
            'countryCodeOptions' => $countryCodeOptions,
            'selectedCountryCodeOption' => $selectedCountryCodeOption,
            'cityCodeOptions' => $cityCodeOptions,
            'selectedCityCodeOption' => $selectedCityCodeOption,
            'params' => $params
        ]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(CustomerRequest $request,$id)
    {
        $request = $request->all();
        $customerRequest =  $request['customer'];
        unset($request['_token']);
        unset($request['_method']);
        unset($request['customer']);
        $params = http_build_query($request);
        DB::beginTransaction();
        try {
            $customer = $this->customerRepository->update($this->customerRepository->find($id),$customerRequest);
            if ($customer) {
                DB::commit();
                return redirect('/customer/inquiry?'.$params)->with('status','Updated success!');
            }


            //load default options for country_code
            $countryCodeOptions = [
                "VN" => "Viet Nam",
                "HK" => "Hong Khong"
            ];
            $selectedCountryCodeOption = $customer->country_code;

            //load default options for city
            $cityCodeOptions = [
                "SGN" => "Sai Gon",
                "HN" => "Ha Noi",
                "HP" => "Hai Phong"
            ];

            $selectedCityCodeOption = $customer->city;


            return view('customer.customer_create', ["customer" => $customer,
                'countryCodeOptions' => $countryCodeOptions,
                'selectedCountryCodeOption' => $selectedCountryCodeOption,
                'cityCodeOptions' => $cityCodeOptions,
                'selectedCityCodeOption' => $selectedCityCodeOption,
                'params' => $params
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return view('customer.customer_create', ["customer" => $customer,
                'countryCodeOptions' => $countryCodeOptions,
                'selectedCountryCodeOption' => $selectedCountryCodeOption,
                'cityCodeOptions' => $cityCodeOptions,
                'selectedCityCodeOption' => $selectedCityCodeOption,
                'params' => $params
            ]);
        }

    }

    /**
     * Remove the specified resource from storage
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $customer = $this->customerRepository->find($id);
            $this->customerRepository->destroy($customer);
            DB::commit();
            if ($request->ajax()) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => true
                ], 200);
            }
            return redirect('/customer/inquiry')->with('status', 'message.save_success');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }
            return redirect('/customer/inquiry')->with('status', 'message.save_error');
        }
    }
}
