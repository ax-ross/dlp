<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'inviter_id', 'to'];

    public static function createInvitation(int $inviterId, string $to = null)
    {
        $invitationCode = Str::random(15);
        while (Invitation::where('code', $invitationCode)->exists()) {
            $invitationCode = Str::random(15);
        }
        return Invitation::create([
            'code' => $invitationCode,
            'inviter_id' => $inviterId,
            'to' => $to
        ]);
    }

    public static function getInviterId(string $code) {
        return Invitation::where('code', $code)->first()->inviter_id;
    }
}
