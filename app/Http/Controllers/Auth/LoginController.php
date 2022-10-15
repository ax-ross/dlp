<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            if (auth()->user()->isTeacher()) {
                return redirect()->intended('teacher');
            }
            return response()->json([
                'message' => 'ok'
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'login' => 'Неверное имя пользователя или пароль.'
            ]);
        }
    }
}
