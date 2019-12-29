<?php

namespace App\Console\Commands;

use App\Zodiac;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class CheckHoroscopes extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:horoscopes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $chat = '-329613465';

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
        $messages = [
            '00:00' => ['⚠️Warning before 24 hours: horoscopes for ', ' are not ready for tomorrow'],
            '12:00' => ['⚠️Warning before 12 hours: horoscopes for ', ' are not ready for tomorrow'],
            '23:00' => ['🆘Emergency before 1 hour: horoscopes for ', ' are still not ready'],
            '23:45' => ['🆘Emergency before 15 minutes: horoscopes for ', ' are still not ready'],
        ];

        Telegram::sendChatAction([
            'chat_id' => $this->chat,
            'action' => 'typing'
        ]);

        $now = now('America/New_York')->addDay();

        Log::info('TELEGRAM CHECK ' . $now->format('H:i'));

        $filled = [];

        $zodiacs = Zodiac::all();

        foreach ($zodiacs as $zodiac) {
            $check = $zodiac->horoscopes()->where('filled', 1)->where('date', $now->format('Y-m-d'))->get();

            if (count($check) == 0) {
                $filled[] = $zodiac->title;
            }
        }

        if (!empty($filled) && isset($messages[$now->format('H:i')])) {
            Telegram::sendMessage([
                'chat_id' => $this->chat,
                'text' => $messages[$now->format('H:i')][0] . implode(', ', $filled) . $messages[$now->format('H:i')][1],
            ]);
        }
    }
}
