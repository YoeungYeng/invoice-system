<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    // login for admin only 
    public function login(Request $request)
    {
        // Validate the request
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // If validation fails, return errors
        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors(),
            ], 422);
        }

        // try to get token jwt
        if (!$token = JWTAuth::attempt($validated->validated())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }
        // check role
        $user = JWTAuth::user();
        if ($user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        // If authentication is successful, return the token
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }
}
