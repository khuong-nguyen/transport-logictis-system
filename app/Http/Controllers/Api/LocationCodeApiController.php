<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Repositories\LocationCodeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LocationCode;

class LocationCodeApiController extends BaseApiController
{
    /**
     * @var LocationCodeRepository
     */
    private $locationCodeRepository;

    /**
     * Create a new controller instance.
     * @param LocationCodeRepository $locationCodeRepository
     *
     * @return void
     */
    public function __construct(
        LocationCodeRepository $locationCodeRepository
    )
    {
        $this->locationCodeRepository = $locationCodeRepository;
    }
    
    public function autocompleteNodeCode(Request $request){
        $data = LocationCode::select("node_code as name")
                    ->where("node_code","LIKE","%{$request->input('query')}%")
                    ->get();
                    
        return response()->json($data);
    }
    
    public function getLocationCode(Request $request){
        $data = LocationCode::where("node_code",$request->input('nodeCode'))->first();
        
        return response()->json($data);
    }
    
}
