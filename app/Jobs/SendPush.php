<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPush implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $type;
    protected $token;
    protected $text;
    protected $title;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct ($type, $token, $text, $title = null) {
        $this->type = $type;
        $this->token = $token;
        $this->text = $text;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle () {
        $url = "https://fcm.googleapis.com/fcm/send";

        $token = $this->token;
        $serverKey = env('PUSH_TOKEN');

        $notification = ['title' => $this->title, 'text' => $this->text, 'sound' => 'default', 'badge' => '1'];
        $arrayToSend = ['registration_ids' => [$token], 'notification' => $notification, 'priority' => 'high'];
        $json = json_encode($arrayToSend);

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //Send the request
        $response = curl_exec($ch);

        //Close request
        if ($response === false) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);


        //try {
        //    $options = [
        //        'sound' => 'default',
        //        'badge' => 1
        //    ];
        //
        //    if (!is_null($this->title)) {
        //        $options['title'] = $this->title;
        //    }
        //
        //    echo "&emsp;&emsp;&emsp;Попытка отправки push (" . $this->type . ") " . $this->token . "\n";
        //
        //    //$url = 'https://fcm.googleapis.com/v1/projects/hora-426c5/messages:send';
        //    $url = 'https://fcm.googleapis.com/fcm/send';
        //
        //        $headers = [
        //            'Authorization: key=' . env('PUSH_TOKEN'),
        //            'Content-Type: application/json'
        //        ];
        //
        //        $fields['registration_ids'] = [$this->token];
        //
        //        $fields['priority'] = 'high';
        //        $fields['notification'] = ['body' => $this->text, 'title' => $this->title];
        //        $fields['data'] = ['message' => $this->text, 'title' => $this->title];
        //
        //        $ch = \curl_init();
        //        curl_setopt_array($ch, [
        //            CURLOPT_URL => $url,
        //            CURLOPT_POST => true,
        //            CURLOPT_HTTPHEADER => $headers,
        //            CURLOPT_RETURNTRANSFER => true,
        //            CURLOPT_SSL_VERIFYHOST => 0,
        //            CURLOPT_SSL_VERIFYPEER => false,
        //            CURLOPT_POSTFIELDS => json_encode($fields)
        //        ]);
        //        $result = curl_exec($ch);
        //        curl_close($ch);
        //
        //        echo "&emsp;&emsp;&emsp;Успешная отправка push (" . $this->type . ") " . $this->token . "\n";
        //
        //        return $result;
        //} catch (Exception $e) {
        //    echo "&emsp;&emsp;&emsp;Ошибка push (" . $this->type . ") " . $this->token . "\n";
        //    dd($e->getMessage());
        //}
    }
}
