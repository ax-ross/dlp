<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();

        $credentials['password'] = Hash::make($credentials['password']);

        $user = User::create($credentials);
        event(new Registered($user));
        Auth::login($user);
        return response()->noContent();
    }
}
