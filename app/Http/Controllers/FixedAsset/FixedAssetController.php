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
        
        return view('fixed_asset.fixed_asset_create',['fixedAssetTypeOptions' => $fixedAssetTypeOptions,
                                                'fixedAssetTypeOptionDefault' => $fixedAssetTypeOptionDefault
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
         
         //$fixedAssetCount = $this->fixedAssetRepository->countFixedAsset();
         
         //$fixedAssetRequest["fixed_asset_code"] = $employeeRequest["fixed_asset_type"]. ($fixedAssetCount + 1);
         
         $fixed_asset=   $this->fixedAssetRepository->create($fixedAssetRequest);

         return redirect('/fixed_asset/registration/'.$fixed_asset->id);
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
        
        return view('fixed_asset.fixed_asset_create',['fixed_asset' => $fixed_asset,
            'fixedAssetTypeOptions' => $fixedAssetTypeOptions,
            'selectedFixedAssetTypeOption' => $selectedFixedAssetTypeOption
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
        $fixed_asset =   $this->fixedAssetRepository->update($this->fixedAssetRepository->find($id),$fixedAssetRequest);
        
        //load default options for fixed asset type
        $fixedAssetTypeOptions = [
            "TRUCK" => "Truck",
            "MOOC" => "Mooc",
            "RO-MOOC" => "Ro-Mooc"
        ];
        $selectedFixedAssetTypeOption = $fixed_asset->fixed_asset_type;
        
        return view('fixed_asset.fixed_asset_create',['fixed_asset' => $fixed_asset,
            'fixedAssetTypeOptions' => $fixedAssetTypeOptions,
            'selectedFixedAssetTypeOption' => $selectedFixedAssetTypeOption
        ]);
    }
}