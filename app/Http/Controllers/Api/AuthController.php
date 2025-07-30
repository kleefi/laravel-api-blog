<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|email',
            'password' => 'string|required|min:8',
        ]);

        if (!$validated) {
            return response()->json(
                [
                    "status" > false,
                    "message" => "failed to create user",
                ]

            );
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'user created',
            'data' => new AuthResource($user)
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "password or email not match"
            ], 422);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "login succedd",
            "token" => $token
        ], 200);
    }
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'user logged'
        ], 200);
    }
}
