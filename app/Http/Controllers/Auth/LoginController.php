<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return response()->noContent();
        } else {
            return response()->json(['errors' => ['login' => 'Неверный email или пароль']], 422);
        }
    }

    public function logout(Request $request): \Illuminate\Http\Response
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent();
    }
}
