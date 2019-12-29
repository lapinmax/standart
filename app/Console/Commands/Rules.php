<?php

namespace App\Console\Commands;

use App\Chat;
use App\Message;
use App\Rule;
use App\Zodiac;
use Illuminate\Console\Command;

class Rules extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rules:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct () {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle () {
        $rules = Rule::where('active', 1)->get();
        $rule = null;

        if (count($rules) > 0) {
            $chats = Chat::all();

            $chats = $chats->filter(function ($chat) {
                return $chat->messages->where('type', '!=', 'purchase')->last()->type == 'user';
            })->sortByDesc(function ($chat) {
                return $chat->messages->last()->id;
            });

            foreach ($chats as $chat) {
                $count = $chat->messages->where('type', 'client')->count();
                $last = $chat->messages->last();

                if ($count == 1) {
                    $rule = $rules->where('title', 'first')->first();
                } elseif ($count > 1) {
                    $rule = $rules->where('title', 'second')->first();
                }

                if (!is_null($rule) && $last->created_at->addDays($rule->days)->lt(today())) {
                    $client = $chat->client;
                    $message = $rule->message;

                    $n = explode(' ', $client->name);
                    $n = isset($n[0]) ? $n[0] : '';

                    $s = '';
                    $se = '';

                    if (!is_null($client->sign) && ($zodiac = Zodiac::find($client->sign + 1))) {
                        $s = $zodiac->name;
                        $se = $zodiac->title;
                    }

                    $message = str_replace('{nf}', $client->name, $message);
                    $message = str_replace('{n}', $n, $message);
                    $message = str_replace('{s}', $s, $message);
                    $message = str_replace('{se}', $se, $message);

                    Message::create([
                        'chat_id' => $chat->id,
                        'message' => $message,
                        'type' => 'user',
                    ]);

                    $tokens = $client->tokens;

                    if (!is_null($tokens)) {
                        foreach ($tokens as $token) {
                            \App\Jobs\SendPush::dispatch($token->type, $token->token, $message, 'New message')
                                ->onQueue('push');
                        }
                    }
                }
            }
        }
    }
}
