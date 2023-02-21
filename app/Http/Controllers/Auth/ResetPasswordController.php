<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(SendResetPasswordRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        $email = $request->validated();
        $status =  Password::sendResetLink($email);
        if ($status === Password::RESET_LINK_SENT) {
            return response()->noContent();
        } else {
            return response()->json([
                'message' => 'error',
                'errors' => __($status)
            ], 500);
        }
    }

    public function showResetForm($token): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('reset-password', compact('token'));
    }

    public function resetPassword(ResetPasswordRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $status = Password::reset(
            $validated, function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
        }
        );

        return $status === Password::PASSWORD_RESET
            ? back()->with('success', 'Пароль успешно изменён')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
