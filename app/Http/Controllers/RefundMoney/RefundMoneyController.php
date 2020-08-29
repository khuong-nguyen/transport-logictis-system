<?php

namespace App\Http\Controllers\RefundMoney;

use App\RefundMoney;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RefundMoneyRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\RefundMoneyRequest;

class RefundMoneyController extends Controller
{
    /**
     * @var RefundMoneyRepository
     */
    private $refundMoneyRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/refund_money';

    /**
     * Create a new controller instance.
     * @param AdvanceRepository $refundMoneyRepository
     * @return void
     */
    public function __construct(
        RefundMoneyRepository $refundMoneyRepository
    )
    {
        $this->refundMoneyRepository = $refundMoneyRepository;
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
        //load default options for refund_money_type
        $refundMoneyTypeOptions = [
            "BOOKING" => "Booking",
            "OTHER" => "Other"
        ];
        $refundMoneyTypeOptionDefault = "BOOKING";
        
        return view('refund_money.refund_money_create',[
            'refundMoneyTypeOptions' => $refundMoneyTypeOptions,
            'refundMoneyTypeOptionDefault' => $refundMoneyTypeOptionDefault
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerRequest $request
     *
     */
    public function store(RefundMoneyRequest $request)
    {
         $request = $request->all();
         
         $refundMoneyRequest =  $request['refund_money'];
         
         $refundMoneyCode = $this->refundMoneyRepository->refundMoneyCode();
         
         $refundMoneyRequest["refund_money_code"] = $refundMoneyCode;
         
         $refund_money =   $this->refundMoneyRepository->create($refundMoneyRequest);

         return redirect('/refund_money/registration/'.$refund_money->id);
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $params = http_build_query($request->all());
        $refund_money =   $this->refundMoneyRepository->find($id);
        //load default options for refund_money_type
        $refundMoneyTypeOptions = [
            "BOOKING" => "Booking",
            "OTHER" => "Other"
        ];
        $selectedRefundMoneyTypeOption = $refund_money->refund_money_type;
        
        return view('refund_money.refund_money_create',[
            'refund_money' => $refund_money,
            'refundMoneyTypeOptions' => $refundMoneyTypeOptions,
            'selectedRefundMoneyTypeOption' => $selectedRefundMoneyTypeOption,
            'params' => $params
        ]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(RefundMoneyRequest $request,$id)
    {
        $request = $request->all();
        $refundMoneyRequest =  $request['refund_money'];
        unset($request['_token']);
        unset($request['_method']);
        unset($request['customer']);
        $params = http_build_query($request);
        DB::beginTransaction();
        try {
            $refund_money = $this->refundMoneyRepository->update($this->refundMoneyRepository->find($id),$refundMoneyRequest);
            if ($refund_money) {
                DB::commit();
                return redirect('/refund_money/inquiry?'.$params)->with('status','Updated success!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/refund_money/inquiry?'.$params)->with('status','Updated no success!');
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
