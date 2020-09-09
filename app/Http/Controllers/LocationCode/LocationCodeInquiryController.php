<?php

namespace App\Http\Controllers\LocationCode;

use App\Http\Controllers\Controller;
use App\Repositories\LocationCodeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LocationCodeInquiryController extends Controller
{
    /**
     * @var LocationCodeRepository
     */
    private $locationCodeRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/location_code';

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
                $data = $this->locationCodeRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->locationCodeRepository->inquirySearch($request);
            }

            return datatables()->of($data)
                ->with([
                    "recordsTotal"    => count($data),
                    "recordsFiltered" => count($data),
                ])
                ->addColumn('action', function($row) use ($params) {
                    $url = '/location_code/registration/'.$row->id.'?'.$params;
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('location_code.location_code_inquiry');
    }
}
