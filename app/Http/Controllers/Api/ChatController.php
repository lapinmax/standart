<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\Http\Resources\MessageResource;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller {
    public function index () {
        $chat = Chat::where('client_id', auth()->user()->id)->first();

        $messages = [];

        if ($chat) {
            $messages = MessageResource::collection($chat->messages()->where('type', '<>', 'purchase')->get());
        }

        return response()->json(JSONSuccess(compact('messages')));
    }

    public function message (Request $request) {
        $validator = validator($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->messages()));
        }

        $chat = Chat::firstOrCreate([
            'client_id' => auth()->user()->id
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'message' => $request->message,
            'type' => 'client',
        ]);

        return response()->json(JSONSuccess());
    }
}
