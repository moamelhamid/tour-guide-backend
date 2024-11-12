<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['user'] =  $user;
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        
        if (! $token = auth()->attempt($credentials)) {

            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
        $success = $this->respondWithToken($token);
        return $this->sendResponse($success, 'User login successfully.');
    }





    public function profile()
    {
        $success = auth()->user();
        return $this->sendResponse($success, 'User profile successfully.');
    }


    public function refresh(Request $request)
    {
        $success = $this->respondWithToken(auth()->refresh());
        return $this->sendResponse($success, 'User profile successfully.');
    }
    public function logout(Request $request)
    {
        $success = auth()->logout();
        return $this->sendResponse($success, 'User logout successfully.');
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
    }
}
