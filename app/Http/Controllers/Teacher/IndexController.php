<?php

namespace App\Http\Controllers\Teacher;

use App\Events\InvitationCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvitationRequest;
use App\Http\Resources\InvitationResource;
use App\Models\Invitation;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function createInvitation(CreateInvitationRequest $request)
    {
        $validated = $request->validated();
        $inviterId = $request->user()->id;
        $invitation = Invitation::createInvitation($inviterId, $validated['email']);
        event(new InvitationCreated(auth()->user(), $validated['email'], $invitation->code));
        return new InvitationResource($invitation);
    }
}
