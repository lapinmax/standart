<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\Http\Resources\UserResource;
use App\Message;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller {
    public function user () {
        return response()->json(JSONSuccess(UserResource::make(auth()->user())));
    }

    public function password (Request $request) {
        $validator = validator($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = auth()->user();

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(JSONSuccess());
    }

    public function subscription (Request $request) {
        $validator = validator($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = auth()->user();

        $user->type = $request->type;
        $user->save();

        $user->updateMailerLite();

        return response()->json(JSONSuccess());
    }

    public function questions (Request $request) {
        $validator = validator($request->all(), [
            'questions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = auth()->user();

        $message = '';

        switch ((int)$request->questions) {
            case 3:
                $user->three_questions = 1;
                $message = 'Purchased 3 questions';

                break;

            case 5:
                $user->five_questions = 1;
                $message = 'Purchased 5 questions';

                break;


            case 10:
                $user->ten_questions = 1;
                $message = 'Purchased 10 questions';

                break;
        }

        $user->save();

        $user->identifierMailerLite();

        $chat = Chat::firstOrCreate([
            'client_id' => auth()->user()->id
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'message' => $message,
            'type' => 'purchase',
        ]);

        return response()->json(JSONSuccess());
    }

    public function update (Request $request) {
        $user = auth()->user();

        if ($request->has('email')) {
            $user->email = empty($request->email) ? '-' : $request->email;
        }

        if ($request->has('sign')) {
            $user->sign = empty($request->sign) ? '-' : $request->sign;
        }

        if ($request->has('name')) {
            $user->name = empty($request->name) ? '-' : $request->name;
        }

        if ($request->has('relationships')) {
            $user->relationships = empty($request->relationships) ? '-' : $request->relationships;
        }

        if ($request->has('gender')) {
            $user->gender = empty($request->gender) ? '-' : $request->gender;
        }

        if ($request->has('favoriteColor')) {
            $user->favoriteColor = empty($request->favoriteColor) ? '-' : $request->favoriteColor;
        }

        if ($request->has('favoriteNumber')) {
            $user->favoriteNumber = empty($request->favoriteNumber) ? '-' : $request->favoriteNumber;
        }

        if ($request->has('birthday')) {
            $user->birthday = empty($request->birthday) ? '-' : Carbon::createFromTimestamp($request->birthday)->format('Y-m-d');
        }

        if ($request->has('partner_birthday')) {
            $user->partner_birthday = empty($request->partner_birthday) ? '-' : Carbon::createFromTimestamp($request->partner_birthday)->format('Y-m-d');
        }

        if ($request->has('timeBirth')) {
            $user->time_birth = empty($request->time_birth) ? '-' : $request->time_birth;
        }

        if ($request->has('placeBirth')) {
            $user->time_birth = empty($request->time_birth) ? '-' : $request->time_birth;
        }

        $user->save();

        $user->updateMailerLite();

        return response()->json(JSONSuccess());
    }

    public function push (Request $request) {
        $validator = validator($request->all(), [
            'device_id' => 'required',
            'type' => 'required',
            'token' => 'required',
            'timezone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->messages()));
        }

        if (!preg_match('/^.{11}:/', $request->token)) {
            return response()->json(JSONError(['token' => 'Invalid token']));
        }

        $token = Token::where('device_id', $request->device_id)->orWhere('token', $request->token)->first();

        if (!$token) {
            $token = new Token();
        }

        $timezones = [
            'MYT' => 'GMT+8',
            'EDT' => 'GMT-4',
            'PDT' => 'GMT-7',
            'CDT' => 'GMT-5',
            'CEST' => 'GMT+2',
            'IST' => 'GMT+5:30',
            'AEST' => 'GMT+10',
            'BST' => 'GMT+1',
            'SGT' => 'GMT+8',
            'MDT' => 'GMT-6',
        ]; //todo delete

        $token->token = $request->token;
        $token->device_id = $request->device_id;
        $token->type = $request->type;
        $token->timezone = isset($timezones[$request->timezone]) ? $timezones[$request->timezone] : $request->timezone;

        if (auth()->guard('api')->check()) {
            $token->client_id = auth()->guard('api')->user()->id;
        }

        $token->save();

        return response()->json(JSONSuccess());
    }
}
