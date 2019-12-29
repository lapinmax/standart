<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject {
    use Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier () {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims () {
        return [];
    }

    protected $dates = ['birthday', 'partner_birthday'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation_token'
    ];

    public function tokens () {
        return $this->hasMany(Token::class);
    }

    public function chat () {
        return $this->hasOne(Chat::class);
    }

    public function addMailerLite () {
        if (!is_null($this->email)) {
            $groupsApi = (new \MailerLiteApi\MailerLite(env('MAILERLITE_API')))->groups();

            $groupId = 42281774;

            $subscriber = [
                'email' => $this->email,
                'fields' => $this->getMailerLiteFields()
            ];

            $addedSubscriber = $groupsApi->addSubscriber($groupId, $subscriber);

            Log::info("addMailerLite email = " . $this->email);
            Log::info(json_encode($addedSubscriber));
        }
    }

    public function updateMailerLite () {
        if (!is_null($this->email)) {

            $subscribersApi = (new \MailerLiteApi\MailerLite(env('MAILERLITE_API')))->subscribers();

            $subscriberEmail = $this->email;
            $subscriberData = [
                'fields' => $this->getMailerLiteFields()
            ];

            $subscriber = $subscribersApi->update($subscriberEmail, $subscriberData);

            Log::info("updateMailerLite email = " . $this->email);
            Log::info(json_encode($subscriber));
        }
    }

    public function identifierMailerLite ($message = null) {
        if (!is_null($this->email)) {

            $subscribersApi = (new \MailerLiteApi\MailerLite(env('MAILERLITE_API')))->subscribers();


            if (is_null($message)) {
                if ($this->chat) {
                    $last = $this->chat->messages->where('type', '!=', 'purchase')->last();

                    $message = $last ? $last->message : '-';
                } else {
                    $message = '-';
                }
            }

            $subscriberEmail = $this->email;
            $subscriberData = [
                'fields' => [
                    'reading_answer' => $message,
                    'astrologer_name' => is_null($this->name) ? $this->email : $this->name,
                    'purchaser_3_questions' => $this->three_questions == 0 ? 'False' : "True",
                    'purchaser_5_questions' => $this->five_questions == 0 ? 'False' : "True",
                    'purchaser_10_questions' => $this->ten_questions == 0 ? 'False' : "True",
                ]
            ];

            $subscriber = $subscribersApi->update($subscriberEmail, $subscriberData);

            Log::info("identifierMailerLite email = " . $this->email);
            Log::info(json_encode($subscriber));
        }
    }

    private function getMailerLiteFields () {
        return [
            'name' => is_null($this->name) ? '-' : $this->name,
            'birthday' => is_null($this->birthday) ? '-' : $this->birthday,
            'relationships' => is_null($this->relationships) ? '-' : $this->relationships,
            'partner_birthday' => is_null($this->partner_birthday) ? '-' : $this->partner_birthday,
            'color' => is_null($this->favoriteColor) ? '-' : $this->favoriteColor,
            'number' => is_null($this->favoriteNumber) ? '-' : $this->favoriteNumber,
            //'gender' => is_null($this->gender) ? '-' : $this->gender,
            //'subscription' => is_null($this->type) ? '-' : $this->type,
            'purchaser_1_month' => is_null($this->type) ? 'False' : ($this->type == 'month' ? 'True' : 'False'),
            'purchaser_6_months' => is_null($this->type) ? 'False' : ($this->type == 'sixMonth' ? 'True' : 'False'),
            'purchaser_12_months' => is_null($this->type) ? 'False' : ($this->type == 'year' ? 'True' : 'False'),
        ];
    }
}
