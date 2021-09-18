<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response_success($data, $msg = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $msg
        ], 200);
    }

    public function response_failed($error)
    {
        return response()->json([
            'success' => false,
            'error' => $error
        ], 200);
    }
}
