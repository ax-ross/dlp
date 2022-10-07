<?php

namespace App\Services;

use App\Mail\InvitationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class InvitationService
{
    public function sendInvitation(User $from, string $to, string $code)
    {
        Mail::to($to)->send(new InvitationMail($from, $code));
    }
}
