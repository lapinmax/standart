<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\ChatTemplate as Template;
use App\Zodiac;
use Illuminate\Http\Request;

class ChatController extends Controller {
    public function index () {
        $chats = Chat::all();

        $new = $chats->filter(function ($chat) {
            return $chat->messages->where('type', '!=', 'purchase')->last()->type == 'client';
        })->sortBy(function ($chat) {
            return $chat->messages->last()->id;
        });


        $archive = $chats->filter(function ($chat) {
            return $chat->messages->where('type', '!=', 'purchase')->last()->type == 'user';
        })->sortByDesc(function ($chat) {
            return $chat->messages->last()->id;
        });

        return view('chats.index', compact('new', 'archive'));
    }

    public function view (Request $request, Chat $chat) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'message' => 'required',
            ]);

            Message::create([
                'chat_id' => $chat->id,
                'message' => $request->message,
                'type' => 'user',
            ]);

            $chat->client->identifierMailerLite($request->message);

            $tokens = $chat->client->tokens;

            if (!is_null($tokens)) {
                foreach ($tokens as $token) {
                    \App\Jobs\SendPush::dispatch($token->type, $token->token, $request->message, 'Answer for your question')
                        ->onQueue('push');
                }
            }

            if ($request->action == 'send') {
                return back();
            }

            $chats = Chat::all();

            $new = $chats->filter(function ($chat) {
                return $chat->messages->last()->type == 'client';
            })->sortBy(function ($chat) {
                return $chat->messages->last()->id;
            });

            if ($new->count() > 0) {
                return redirect()->route('chats.view', $new->first()->id)->with('success', true);
            }

            return redirect()->route('chats.index')->with('success', true);
        }

        $templates = Template::all();
        $client = $chat->client;

        foreach ($templates as $template) {
            $n = explode(' ', $client->name);
            $n = isset($n[0]) ? $n[0] : '';

            $s = '';
            $se = '';

            if (!is_null($client->sign) && ($zodiac = Zodiac::find($client->sign + 1))) {
                $s = $zodiac->name;
                $se = $zodiac->title;
            }

            $template->message = str_replace('{nf}', $client->name, $template->message);
            $template->message = str_replace('{n}', $n, $template->message);
            $template->message = str_replace('{s}', $s, $template->message);
            $template->message = str_replace('{se}', $se, $template->message);
        }

        $messages = $chat->messages->map(function ($message) {
            $message->day = $message->created_at->format('M j, Y, l');

            return $message;
        })->groupBy('day');

        return view('chats.view', compact('chat', 'client', 'messages', 'templates'));
    }
}
