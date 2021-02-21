<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseApiController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, $responseCode = 200)
    {
        return $this->responseJson(null, $responseCode, 'success', $data);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message = null, $responseCode = 403)
    {
        return $this->responseJson(true, $responseCode, $message);
    }

    /**
     * Response json
     *
     * @param bool $error
     * @param int $responseCode
     * @param array $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null, $keyword = ""){
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data,
            'keyword' => $keyword
        ], $responseCode);
    }

    public function authenticate()
    {
        if (empty($this->user))
        {
            header('Access-Control-Allow-Origin: *');
            response()->json(['error'=>'Un-Authorized'], 401)->send();
            die();
        }
    }

    public function user()
    {
        return $this->user;
    }
}
