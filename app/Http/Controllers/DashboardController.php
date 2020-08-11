<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DashboardController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    public function home()
    {
        return view('dashboard');
    }
}
