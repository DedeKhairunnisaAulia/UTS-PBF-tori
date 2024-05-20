<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;


class AuthController extends Controller
{
    public function login(Request $request) {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if(Auth::attempt($validator->validate())){
            $user = Auth::user();
            $payload = [
                'iss' => "UTS-PBF.com",
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'iat' => now()->timestamp,
                'exp' => now()->timestamp * 60
            ];
            
            $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');

            return response()->json([
                'msg' => 'token berhasil dibuat',
                'data' => 'Bearer'.$token
            ],200);

        } else {

            return response()->json([
                'msg' => 'Email atau password salah',
            ],422);
        }   
    }  

    public function register(Request $request) {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Default role
        ]);

        //generate token
        $payload = [
            'iss' => "UTS-PBF.com",
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'iat' => now()->timestamp,
            'exp' => now()->addMinutes(60)->timestamp // Token expiration time
        ];

        $token = JWT::encode($payload, env('JWT_SECRET_KEY'), 'HS256');

        return response()->json([
            'msg' => 'User successfully registered',
            'data' => 'Bearer '.$token
        ], 201);
    }
    
}
