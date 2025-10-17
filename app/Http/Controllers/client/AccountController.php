<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccountController extends Controller
{
    //​ register
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // check validation
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // return response
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    // login 
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if ($data->fails()) {
                return response()->json([
                    'status' => 400,
                    'error' => $data->errors()
                ], 400);
            }
            // Try to generate token
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Get authenticated user
            $user = JWTAuth::user();

            // Check if user is admin
            if ($user->role !== 'customer') {
                return response()->json([
                    'status' => 403,
                    'message' => 'Access denied. Admins only.'
                ], 403);
            }
            // Find the user by email
            if (JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = User::find(Auth::user()->id);
                // check if admin
                if ($user->role == 'customer') {
                    // Generate a new token
                    $token = JWTAuth::fromUser($user);
                    // Return the token and user information
                    

                    return response()->json([
                        'status' => 200,
                        'token' => $token,
                        'id' => $user->id,
                        'email' => $user->email,
                        'password' => $user->password,
                        // 'user' => $user,

                    ], 200);
                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => "You are not authorized to access admin panel"
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => "Either email/password in incorrenct"
                ], 401);
            }
    }
}
