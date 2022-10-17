<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function registerTeacher($credentials)
    {
        $credentials['password'] = Hash::make($credentials['password']);
        DB::beginTransaction();
        try {
            $teacher = Teacher::create();
            $credentials['teacher_id'] = $teacher->id;
            $user = $teacher->user()->create($credentials);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        event(new Registered($user));
        Auth::login($user);
    }

    public function registerStudent($credentials)
    {
        $credentials['password'] = Hash::make($credentials['password']);
        DB::beginTransaction();
        try {

            $student = Student::create([
                'inviter_id' => Invitation::getInviterId($credentials['invitation_code'])
            ]);
            $credentials['student_id'] = $student->id;
            $user = $student->user()->create($credentials);
            Invitation::where('code', $credentials['invitation_code'])->first()->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        event(new Registered($user));
        Auth::login($user);
    }
}
