<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\FixedAssetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FixedAsset;

class FixedAssetApiController extends BaseApiController
{
    /**
     * @var FixedAssetRepository
     */
    private $fixedAssetRepository;

    /**
     * Create a new controller instance.
     * @param FixedAssetRepository $fixedAssetRepository
     *
     * @return void
     */
    public function __construct(
        FixedAssetRepository $fixedAssetRepository
    )
    {
        $this->fixedAssetRepository = $fixedAssetRepository;
    }
    
    public function autoCompleteTruckNo(Request $request){
        $data = FixedAsset::select("fixed_asset_code as name")
                    ->where("fixed_asset_code","LIKE","%{$request->input('query')}%")
                    ->where("fixed_asset_type","TRUCK")
                    ->get();
                    
        return response()->json($data);
    }
}
