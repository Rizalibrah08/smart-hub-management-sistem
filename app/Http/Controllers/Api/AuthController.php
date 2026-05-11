<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->error('Email atau password salah.', 401);
        }

        $user  = auth()->user();
        $token = $user->createToken('tablet-token')->plainTextToken;

        return $this->success([
            'user'       => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role],
            'token'      => $token,
            'token_type' => 'Bearer',
        ], 'Login berhasil.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(message: 'Logout berhasil.');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        return $this->success([
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'role'     => $user->role,
            'phone'    => $user->phone,
            'is_active'=> $user->is_active,
        ]);
    }
}
