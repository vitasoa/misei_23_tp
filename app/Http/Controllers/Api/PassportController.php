<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PassportController extends Controller
{
    public function login(Request $request){
        $input = $request->all();

        $validation = Validator::make($input, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'statusCode' => 400,
                'message' => $validation->errors()
            ], 400);
        }

        if(auth()->attempt([
            'email' => $input['email'],
            'password' => $input['password']
        ])){
            $token = \Auth::user()->createToken('Token')->accessToken;

            return response()->json([
                'statusCode' => 200,
                'token' => $token
            ]);
        }else {
            return response()->json([
                'statusCode' => 401,
                'message' => 'Login or password'
            ], 401);
        }
    }

    public function logout() {
		if(Auth::check()){
			Auth::user()->token()->revoke();
			return response()->json([
                'statusCode' => 200,
                'message' => 'Logout success'
            ], 200); 
		}else {
			return response()->json([
                'statusCode' => 500,
                'message' => 'API Error'
            ], 500);
		}
	}
}
