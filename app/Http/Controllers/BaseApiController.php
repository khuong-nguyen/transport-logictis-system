<?php

namespace App\Http\Controllers;

class BaseApiController extends Controller
{
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
}
