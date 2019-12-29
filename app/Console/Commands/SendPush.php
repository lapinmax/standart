<?php

namespace App\Console\Commands;

use App\Horoscope;
use App\PushTemplate;
use App\Token;
use App\Zodiac;
use Illuminate\Console\Command;

class SendPush extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:send';

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
        $tokens = Token::all();
        $n = '';
        $nf = '';
        $s = '';
        $se = '';

        foreach ($tokens as $token) {
            $timezone = $token->timezone;

            try {
                $now = now($timezone);
            } catch (\Exception $e) {
                $now = now('America/New_York');
            }

            if ($now->hour == 0) {
                $template = PushTemplate::all()->first();

                if ($token->client) {
                    $nf = $token->client->name;
                    $n = explode(' ', $token->client->name);
                    $n = isset($n[0]) ? $n[0] : '';

                    if (!is_null($token->client->sign)) {
                        if ($zodiac = Zodiac::find($token->client->sign + 1)) {
                            $s = $zodiac->name;
                            $se = $zodiac->title;
                        }

                        $horoscope = Horoscope::where('type', 'day')->where('zodiac_id', (int)$token->client->sign + 1)
                            ->where('template_id', '<>', $template->id)
                            ->where('filled', 1)
                            ->where('date', $now->format('Y-m-d'))->first();

                        if ($horoscope) {
                            $template = $horoscope->template;
                        }
                    }
                }

                if ($template) {
                    $message = $template->message;

                    $message = str_replace('{nf}', $nf, $message);
                    $message = str_replace('{n}', $n, $message);
                    $message = str_replace('{s}', $s, $message);
                    $message = str_replace('{se}', $se, $message);

                    \App\Jobs\SendPush::dispatch($token->type, $token->token, $message, 'Hora')
                        ->onQueue('push');
                    //'Your daily horoscope is here to give you a cosmic upper hand. ✨'
                }
            }
        }
    }
}
