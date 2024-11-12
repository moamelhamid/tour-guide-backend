<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
 public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);    
}

public function sendError($error, $Errormessage=[],$code = 404)
    {
        $response = [
            'success' => false,
            'data'    => $error,
            
        ];
        if(!empty($Errormessage)){
            $response['message'] = $Errormessage;
        }
        return response()->json($response, $code);    
}
}
