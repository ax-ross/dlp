<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CentrifugoProxyController extends Controller
{
    public function connect(): JsonResponse
    {
        Log::error(Auth::user());
        return new JsonResponse([
            'result' => [
                'user' => (string) Auth::user()->id,
                'channels' => ["personal:user#".Auth::user()->id],
            ]
        ]);
    }
}
