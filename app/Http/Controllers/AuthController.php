<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dep_id'=>'required',
            'email' => 'required|email',
            'password' => 'required',
           
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = $input['password'];
        $dep_id = BigInteger::of($input['dep_id']);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'dep_id' => $dep_id,]);

        $success['user'] =  $user;
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        
        if (! $token = JWTAuth::attempt($credentials)) {

            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
        $success = $this->respondWithToken($token);
        return $this->sendResponse($success, 'User login successfully.');
    }





    public function profile()
    {
        $success = Auth::user();
        return $this->sendResponse($success, 'User profile successfully.');
    }



    public function refresh(Request $request)
    {
        $success = $this->respondWithToken(JWTAuth::refresh());
        return $this->sendResponse($success, 'User profile successfully.');
    }
    public function logout(Request $request)
    {
        $success = JWTAuth::invalidate($request->token);
        return $this->sendResponse($success, 'User logout successfully.');
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ];
    }
}
