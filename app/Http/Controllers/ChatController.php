<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Chat;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(private Centrifugo $centrifugo)
    {
    }

    public function index()
    {
        $rooms = Chat::with(['users', 'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'desc')->get();
        return $rooms;
    }

    public function show(int $id)
    {
        $room = Chat::with(['users', 'messages.user' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->find($id);

        return $room;
    }

    public function join(int $id)
    {
        $room = Chat::find($id);
        $room->users()->attach(auth()->user());
        return response()->noContent();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:32', 'unique:chats'],
        ]);
        $room = Chat::create(['title' => $request->get('title')]);
        $room->users()->attach(Auth::user()->id);

        return $room->id;
    }
    public function publish(int $id, Request $request)
    {
        $requestData = $request->json()->all();
        $status = Response::HTTP_OK;
        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'message' => $requestData["message"],
            'chat_id' => $id,
        ]);
        $room = Chat::with('users')->find($id);

        $channels = [];
        foreach ($room->users as $user) {
            $channels[] = "personal:user#" . $user->id;
        }
        $this->centrifugo->broadcast($channels, [
            "text" => $message->message,
            "createdAt" => $message->created_at->toDateTimeString(),
            "createdAtFormatted" => $message->created_at->toFormattedDateString() . ", " . $message->created_at->toTimeString(),
            "roomId" => $id,
            "senderId" => Auth::user()->id,
            "senderName" => Auth::user()->name,
        ]);

        return response()->noContent();
    }
}
