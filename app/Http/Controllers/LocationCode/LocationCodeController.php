<?php

namespace App\Http\Controllers\LocationCode;

use App\LocationCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\LocationCodeRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\LocationCodeRequest;
use Carbon\Carbon;

class LocationCodeController extends Controller
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
     * @return void
     */
    public function __construct(
        LocationCodeRepository $locationCodeRepository
    )
    {
        $this->locationCodeRepository = $locationCodeRepository;
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
        return view('location_code.location_code_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LocationCodeRequest $request
     *
     */
    public function store(LocationCodeRequest $request)
    {
         $request = $request->all();
         $locationCodeRequest =  $request['location_code'];
         
         $location_code=   $this->locationCodeRepository->create($locationCodeRequest);

         return redirect('/location_code/registration');
    }

    /**
     * @param   $id
     *
     * @return View
     */
    public function edit($id)
    {
        $location_code =   $this->locationCodeRepository->find($id);
  
        return view('location_code.location_code_create',['location_code' => $location_code]);
    }


    /**
     * @param Request $request
     * @param   $id
     *
     * @return View
     */
    public function update(LocationCodeRequest $request,$id)
    {
        $request = $request->all();
        
        $locationCodeRequest =  $request['location_code'];
        
        $location_code =   $this->locationCodeRepository->update($this->locationCodeRepository->find($id),$locationCodeRequest);

        return view('location_code.location_code_create',['location_code' => $location_code]);
    }

}
