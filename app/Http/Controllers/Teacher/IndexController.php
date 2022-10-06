<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvitationRequest;
use App\Http\Resources\InvitationResource;
use App\Models\Invitation;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('teacher.index');
    }

    public function createInvitation(CreateInvitationRequest $request)
    {
        $validated = $request->validated();
        $inviterId = $request->user()->id;
        $invitation = Invitation::createInvitation($inviterId, $validated['email']);
        return new InvitationResource($invitation);
    }
}
