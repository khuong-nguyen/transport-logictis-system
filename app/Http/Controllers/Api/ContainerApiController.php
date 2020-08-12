<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ContainerRepository;
use Illuminate\Http\Request;

class ContainerApiController extends Controller
{


    /**
     * @var ContainerRepository
     */
    private $containerRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/booking';

    /**
     * Create a new controller instance.

     * @param ContainerRepository $containerRepository
     *
     * @return void
     */
    public function __construct(ContainerRepository $containerRepository)
    {
        $this->containerRepository = $containerRepository;
    }

    /**
     * @param  Request $request
     *
     * @return array
     */
    public function search(Request $request)
    {
        return $this->containerRepository->search($request->get('search',''));
    }
}
