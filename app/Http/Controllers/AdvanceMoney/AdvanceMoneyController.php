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
    public function store(AdvanceMoneyRequest $request)
    {
         $request = $request->all();
         
         $advanceMoneyRequest =  $request['advance_money'];
         
         $advanceMoneyCode = $this->advanceMoneyRepository->advanceMoneyCode();
         
         $advanceMoneyRequest["advance_money_code"] = $advanceMoneyCode;
         
         $advance_money =   $this->advanceMoneyRepository->create($advanceMoneyRequest);

         return redirect('/advance_money/registration/'.$advance_money->id);
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit(Request $request, $id)
    {
        $params = http_build_query($request->all());
        $advance_money =   $this->advanceMoneyRepository->find($id);
        //load default options for advance_money_type
        $advanceMoneyTypeOptions = [
            "BOOKING" => "Booking",
            "OTHER" => "Other"
        ];
        $selectedAdvanceMoneyTypeOption = $advance_money->advance_money_type;
        
        return view('advance_money.advance_money_create',[
            'advance_money' => $advance_money,
            'advanceMoneyTypeOptions' => $advanceMoneyTypeOptions,
            'selectedAdvanceMoneyTypeOption' => $selectedAdvanceMoneyTypeOption,
            'params' => $params
        ]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(AdvanceMoneyRequest $request,$id)
    {
        $request = $request->all();
        $advanceMoneyRequest =  $request['advance_money'];
        /* unset($request['_token']);
        unset($request['_method']);
        unset($request['customer']); */
        $params = http_build_query($request);
        DB::beginTransaction();
        try {
            $advance_money = $this->advanceMoneyRepository->update($this->advanceMoneyRepository->find($id),$advanceMoneyRequest);
            if ($advance_money) {
                DB::commit();
                return redirect('/advance_money/inquiry?'.$params)->with('status','Updated success!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/advance_money/inquiry?'.$params)->with('status','Updated no success!');
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
            $advance_money = $this->advanceMoneyRepository->find($id);
            $this->advanceMoneyRepository->destroy($advance_money);
            DB::commit();
            if ($request->ajax()) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => true
                ], 200);
            }
            return redirect('/advance_money/inquiry')->with('status', 'message.save_success');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }
            return redirect('/advance_money/inquiry')->with('status', 'message.save_error');
        }
    }
}
