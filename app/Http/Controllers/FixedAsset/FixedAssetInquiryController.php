<?php

namespace App\Http\Controllers\FixedAsset;

use App\Http\Controllers\Controller;
use App\Repositories\FixedAssetRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FixedAssetInquiryController extends Controller
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

    public function index(Request $request)
    {
        
        if($request->ajax())
        {
            $params = '';
            $search = $request->get('search');
            if($search != null)
            {
                if (isset($search['columns'])) {
                    $params = http_build_query($search['columns']);
                }
                $data = $this->fixedAssetRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->fixedAssetRepository->inquirySearch($request);
            }
            
            return datatables()->of($data)
                ->with([
                    "recordsTotal"    => count($data),
                    "recordsFiltered" => count($data),
                ])
                ->addColumn('action', function($row) use ($params) {
                    $url = '/fixed_asset/registration/'.$row->id.'?'.$params."from=inquiry";
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('fixed_asset.fixed_asset_inquiry');
    }
}
