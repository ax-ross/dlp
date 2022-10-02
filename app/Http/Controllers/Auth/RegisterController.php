<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Email\Teacher\EmailRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(EmailRegisterRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = Hash::make($credentials['password']);
        $credentials['role'] = 'teacher';
        $user = User::create($credentials);
        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Вы успешно зарегестрировались. Для доступа ко всем функциям подтвердите свой email.');
    }
}
