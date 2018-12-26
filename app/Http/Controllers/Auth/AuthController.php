<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
       
        $credentials = $request->only(['email', 'password']);
        $token = auth()->attempt($credentials);

        if(!$token) { //ako nema token vrati ovu poruku
            return response()->json([
                'message' => 'You are not authorized!'
            ], 401);
        }
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function register(RegisterRequest $request) {
       
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save(); 


        return $this->login($request);  //sa ovim requestom ulogujemo odmah usera
    }
}
