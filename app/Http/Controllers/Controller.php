<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //create response method
    public function responseMessage($data, $status = false,$message = 'Success')
    {
        if ($status) {
            return response()->json([
                'message' =>  $message,
                'status' => true,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => $message,
                'status' => false,
                'data' => $data,
            ], 400);
        }
    }
}
