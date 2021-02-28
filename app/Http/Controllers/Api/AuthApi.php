<?php
namespace App\Http\Controllers\API;

use App\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthApi extends BaseApiController
{

    /**
     * AuthApi constructor.
     */
    public function __construct()
    {
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => strtolower($request->username),
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();
            /*if (empty($user->email_verified_at))
                return $this->error('USER_NOT_VERIFY', 401);*/
            
            $token = $user->createToken('Laravel')->accessToken;
            
            return $this->success([
                'token' => $token,
                'user_id' => $user->id,
                'roles' => $user->roles->pluck('name','name')->all(),
                'full_name' => $user->name,
                'employee_id' => $user->employee_id
            ]);
        }

        return $this->error('LOGIN_FAIL', 401);
    }
}
