<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 400);
        }

        $user = User::where('email', $request->post('email'))->first();

        if (!$user || !Hash::check($request->post('password'), $user->password)) {
            return response()->json([
                'message' => '유효하지 않은 인증 정보'
            ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message' => 'success',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
