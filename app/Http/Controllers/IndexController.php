<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class IndexController extends Controller {
    public function test ($email) {
        $user = Client::where('email', $email)->first();

        $data = [];

        if ($user) {
            $tokens = $user->tokens;

            foreach ($tokens as $token) {
                $timezone = $token->timezone;

                try {
                    $now = now($timezone);
                } catch (\Exception $e) {
                    $now = now('America/New_York');
                    $timezone = 'America/New_York';
                }

                $data[] = [
                    'timezone' => $timezone, 'hour' => $now->hour, 'format' => $now->format('H:i:s'), 'iso' => $now
                ];

            }
        }

        return $data;
    }
}
