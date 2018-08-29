<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }
        return response([
            'status' => 'success',
            'token' => $token
        ]);
    }
    public function logout()
    {
        Auth::guard('api')->logout();

        return response(['message' => '退出成功']);
    }
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function done(Request $request)
    {
        return $request->input('token1');
    }


    public function guard()
    {
        return Auth::guard();
    }

}