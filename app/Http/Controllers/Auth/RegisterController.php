<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = Hash::make($credentials['password']);
        DB::beginTransaction();
        try {
            if (isset($credentials['invitation_code'])) {
                $credentials['inviter_id'] = Invitation::getInviterId($credentials['invitation_code']);
                Invitation::where('code', $credentials['invitation_code'])->first()->delete();
            }
            $user = User::create($credentials);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        event(new Registered($user));
        Auth::login($user);

        if ($user->isTeacher()) {
            return redirect()->route('teacher')->with('success', 'Вы успешно зарегестрировались. Для доступа ко всем функциям подтвердите свой email.');
        }

        return redirect()->route('student')->with('success', 'Вы успешно зарегестрировались. Для доступа ко всем функциям подтвердите свой email.');
    }
}
