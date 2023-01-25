<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Chat;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private Centrifugo $centrifugo)
    {
    }

    public function publish(Chat $chat, Request $request)
    {
        $requestData = $request->json()->all();
        $message = Message::create([
            'sender_id' => $request->user()->id,
            'message' => $requestData["message"],
            'chat_id' => $chat->id,
        ]);

        $channels = [];
        foreach ($chat->users as $user) {
            $channels[] = "personal:user#" . $user->id;
        }

        $messageResource = new MessageResource($message);

        $this->centrifugo->broadcast($channels, $messageResource->toArray($request));

        return response()->noContent();
    }

    public function show(Chat $chat)
    {
        return new ChatResource($chat);
    }

    public function messages(Chat $chat)
    {
        $messages = $chat->messages()->with('user')->get();
        return MessageResource::collection($messages);
    }
}
