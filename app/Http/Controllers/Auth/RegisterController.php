<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(private RegisterService $registerService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        if ($request->role === 'teacher') {
            $this->registerService->registerTeacher($credentials);
        } else {
            $this->registerService->registerStudent($credentials);
        }
        return response()->noContent();
    }
}
