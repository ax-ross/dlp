<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        if (isset($validated['avatar'])) {
            if (!$user->avatar === User::$defaultAvatar) {
                Storage::delete($user->avatar);
            }
            $validated['avatar'] = $validated['avatar']->store('images/avatars', 'public');
        }

        $user->update($validated);

        return new UserResource($user->fresh());
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();
        return response()->noContent();
    }
}
