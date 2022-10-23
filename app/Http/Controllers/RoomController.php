<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function __construct(private Centrifugo $centrifugo)
    {
    }

    public function index()
    {
        $rooms = Room::with(['users', 'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'desc')->get();
        return $rooms;
    }

    public function show(int $id)
    {
        $room = Room::with(['users', 'messages.user' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->find($id);

        return $room;
    }

    public function join(int $id)
    {
        $room = Room::find($id);
        $room->users()->attach(auth()->user());
        return response()->noContent();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:32', 'unique:rooms'],
        ]);

        $room = Room::create(['name' => $request->get('name')]);
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
            'room_id' => $id,
        ]);
        $room = Room::with('users')->find($id);

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
