<?php

namespace App\Http\Controllers\FixedAsset;

use App\FixedAsset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FixedAssetRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\FixedAssetRequest;
use App\Employee;

class FixedAssetController extends Controller
{
    /**
     * @var FixedAssetRepository
     */
    private $fixedAssetRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/fixed_asset';

    /**
     * Create a new controller instance.
     * @param FixedAssetRepository $eixedAssetRepository
     * @return void
     */
    public function __construct(
        FixedAssetRepository $fixedAssetRepository
    )
    {
        $this->fixedAssetRepository = $fixedAssetRepository;
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
        //load default options for fixed asset type
        $fixedAssetTypeOptions = [
            "TRUCK" => "Truck",
            "MOOC" => "Mooc",
            "RO-MOOC" => "Ro-Mooc"
        ];
        $fixedAssetTypeOptionDefault = "TRUCK";
        
        //load driver list
        $driverOptions = [];
        
        $driver_list = Employee::where('department_code', 'DRIVER')->get();
        if($driver_list){
            foreach($driver_list as $driver){
                $driverOptions[]= [
                    $driver->id => $driver->employee_name
                ];
            }
            
        }
        $driverOptionDefault = 0;
        
        return view('fixed_asset.fixed_asset_create',[
            'fixedAssetTypeOptions' => $fixedAssetTypeOptions,
            'fixedAssetTypeOptionDefault' => $fixedAssetTypeOptionDefault,
            'driverOptions' => $driverOptions,
            'driverOptionDefault' => $driverOptionDefault
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FixedAssetRequest $request
     *
     */
    public function store(FixedAssetRequest $request)
    {
         $request = $request->all();

         $fixedAssetRequest =  $request['fixed_asset'];

         if($fixedAssetRequest['driver_id']>0){
             $driver = Employee::find($fixedAssetRequest['driver_id']);
             if($driver){
                 $fixedAssetRequest['driver_code'] = $driver->employee_code;
                 $fixedAssetRequest['driver_name'] = $driver->employee_name;
             }
         }

         $fixed_asset = $this->fixedAssetRepository->create($fixedAssetRequest);

         return redirect('/fixed_asset/registration');
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $fixed_asset =   $this->fixedAssetRepository->find($id);

        //load default options for fixed asset type
        $fixedAssetTypeOptions = [
            "TRUCK" => "Truck",
            "MOOC" => "Mooc",
            "RO-MOOC" => "Ro-Mooc"
        ];
        $selectedFixedAssetTypeOption = $fixed_asset->fixed_asset_type;
        
        //load driver list
        $driverOptions = [];
        
        $driver_list = Employee::where('department_code', 'DRIVER')->get();
        if($driver_list){
            foreach($driver_list as $driver){
                $driverOptions[]= [
                    $driver->id => $driver->employee_name
                ];
            }
            
        }
        $driverOptionDefault = 0;
        if(!empty($fixed_asset->driver_id)){
            $selectedDriverOption = $fixed_asset->driver_id;
        }else{
            $selectedDriverOption = 0;
        }
        

        return view('fixed_asset.fixed_asset_create',[
            'fixed_asset' => $fixed_asset,
            'fixedAssetTypeOptions' => $fixedAssetTypeOptions,
            'selectedFixedAssetTypeOption' => $selectedFixedAssetTypeOption,
            'driverOptions' => $driverOptions,
            'selectedDriverOption' => $selectedDriverOption,
            'driverOptionDefault' => $driverOptionDefault
            
        ]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(FixedAssetRequest $request,$id)
    {
        $request = $request->all();
        $fixedAssetRequest =  $request['fixed_asset'];
        $params = http_build_query($request);
        
        if($fixedAssetRequest['driver_id']>0){
            $driver = Employee::find($fixedAssetRequest['driver_id']);
            if($driver){
                $fixedAssetRequest['driver_code'] = $driver->employee_code;
                $fixedAssetRequest['driver_name'] = $driver->employee_name;
            }
        }
        $fixed_asset =   $this->fixedAssetRepository->update($this->fixedAssetRepository->find($id),$fixedAssetRequest);

        if (!empty($params)) {
            return redirect('/fixed_asset/inquiry?'.$params)->with('status','Updated success!');
        }
        
        //load default options for fixed asset type
        $fixedAssetTypeOptions = [
            "TRUCK" => "Truck",
            "MOOC" => "Mooc",
            "RO-MOOC" => "Ro-Mooc"
        ];
        $selectedFixedAssetTypeOption = $fixed_asset->fixed_asset_type;
        
        //load driver list
        $driverOptions = [];
        
        $driver_list = Employee::where('department_code', 'DRIVER')->get();
        if($driver_list){
            foreach($driver_list as $driver){
                $driverOptions[]= [
                    $driver->id => $driver->employee_name
                ];
            }
            
        }
        $driverOptionDefault = 0;
        
        if(!empty($fixed_asset->driver_id)){
            $selectedDriverOption = $fixed_asset->driver_id;
        }else{
            $selectedDriverOption = 0;
        }

        return view('fixed_asset.fixed_asset_create',['fixed_asset' => $fixed_asset,
            'fixedAssetTypeOptions' => $fixedAssetTypeOptions,
            'selectedFixedAssetTypeOption' => $selectedFixedAssetTypeOption,
            'driverOptions' => $driverOptions,
            'selectedDriverOption' => $selectedDriverOption,
            'driverOptionDefault' => $driverOptionDefault
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) {
        if ($request->has('code') && $request->has('type')) {
            $data = $this->fixedAssetRepository->search($request->all());
            if ($data) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => $data
                ], 200);
            }
            return response()->json([
                'error' => true,
                'message' => 'This container truck code was not found!',
                'data' => false
            ], 403);
        }
        return response()->json([
            'error' => true,
            'message' => 'This container truck code was not found!',
            'data' => false
        ], 403);
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $fixed_asset = $this->fixedAssetRepository->find($id);
            $this->fixedAssetRepository->destroy($fixed_asset);
            DB::commit();
            if ($request->ajax()) {
                return response()->json([
                    'error' => null,
                    'message' => 'success',
                    'data' => true
                ], 200);
            }
            return redirect('/fixed_asset/inquiry')->with('status', 'message.save_success');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'data' => false
                ], 403);
            }
            return redirect('/fixed_asset/inquiry')->with('status', 'message.save_error');
        }
    }
}
