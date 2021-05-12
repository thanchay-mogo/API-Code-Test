<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $meta=false, $duration=false)
    {
    	$response = [
            'success' => 1,
            'code'=> 200,
            'meta' => json_decode('{}'),
            'data' => $result,
            'error' =>  json_decode('{}'),
            "duration" => $duration
        ];
        return response()->json($response, 200);
    }

    //public function sendError($error, $meta=false, $duration=false)
    public function sendError($error, $errorMessages = [], $meta, $duration)
    {
    	$response = [
            'success' => 0,
            'code'=> 404,
            'meta' => json_decode('{}'),
            'error' => $error
            
            
        ];

        if(!empty($errorMessages)){
            $response['validation'] = $errorMessages;
        };

        $response["duration"] = $duration;
        
        return response()->json($response, 404);
    }

}
