<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller {
    public function login (Request $request) {
        $validator = validator($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        if ($token = auth()->guard('api')->attempt($request->only(['email', 'password']))) {
            return response()->json(JSONSuccess(['token' => $token]));
        }

        return response()->json(JSONError(['email' => __('auth.failed')]));
    }

    public function register (Request $request) {
        $validator = validator($request->all(), [
            'email' => [
                'required',
                Rule::unique('clients', 'email')->where(function ($query) {
                    return $query->where('socialType', null);
                })
            ],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $token = Str::random(16);

        $client = Client::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'confirmation_token' => $token,
            'name' => $request->has('name') ? $request->name : null,
            'relationships' => $request->has('relationships') ? $request->relationships : null,
            'sign' => $request->has('sign') ? $request->sign : null,
            'gender' => $request->has('gender') ? $request->gender : null,
            'favoriteColor' => $request->has('favoriteColor') ? $request->favoriteColor : null,
            'favoriteNumber' => $request->has('favoriteNumber') ? $request->favoriteNumber : null,
            'time_birth' => $request->has('timeBirth') ? $request->timeBirth : null,
            'place_birth' => $request->has('placeBirth') ? $request->placeBirth : null,
            'birthday' => $request->has('birthday') ? Carbon::createFromTimestamp($request->birthday)->format('Y-m-d') : null,
            'partner_birthday' => $request->has('partner_birthday') ? Carbon::createFromTimestamp($request->partner_birthday)->format('Y-m-d') : null,
        ]);

        if ($token = auth()->guard('api')->login($client)) {
            $client->addMailerLite();

            return response()->json(JSONSuccess(['token' => $token]));
        }

        return response()->json(JSONError(['email' => __('auth.failed')]));
    }

    public function social (Request $request) {
        $validator = validator($request->all(), [
            'socialType' => 'required',
            'token' => 'required',
            'profileID' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = Client::updateOrCreate([
            'socialProfileID' => $request->profileID
        ], [
            'socialType' => $request->socialType,
            'socialToken' => $request->token,
            'active' => 1,
            'email' => $request->has('email') ? $request->email : null,
            'name' => $request->has('name') ? $request->name : null,
            'relationships' => $request->has('relationships') ? $request->relationships : null,
            'sign' => $request->has('sign') ? $request->sign : null,
            'gender' => $request->has('gender') ? $request->gender : null,
            'favoriteColor' => $request->has('favoriteColor') ? $request->favoriteColor : null,
            'favoriteNumber' => $request->has('favoriteNumber') ? $request->favoriteNumber : null,
            'time_birth' => $request->has('timeBirth') ? $request->timeBirth : null,
            'place_birth' => $request->has('placeBirth') ? $request->placeBirth : null,
            'birthday' => $request->has('birthday') ? Carbon::createFromTimestamp($request->birthday)->format('Y-m-d') : null,
            'partner_birthday' => $request->has('partner_birthday') ? Carbon::createFromTimestamp($request->partner_birthday)->format('Y-m-d') : null,
        ]);

        if ($token = auth()->guard('api')->login($user)) {
            $user->addMailerLite();

            return response()->json(JSONSuccess(['token' => $token]));
        }

        return response()->json(JSONError(['email' => __('auth.failed')]));
    }

    public function refresh () {
        try {
            if ($token = auth()->guard('api')->refresh()) {
                return response()->json(JSONSuccess(['token' => $token]));
            }

            return response()->json(JSONError(['unauthenticated' => 'Your session is invalidated. Please re-login']));
        } catch (TokenInvalidException $e) {
            return response()->json(JSONError(['invalid' => 'Your session is invalidated. Please re-login']));
        } catch (JWTException $e) {
            return response()->json(JSONError(['unauthenticated' => 'Your session is invalidated. Please re-login']));
        }
    }

    public function logout () {
        auth()->guard('api')->logout();

        return response()->json(JSONSuccess());
    }

    public function reset (Request $request) {
        $validator = validator($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = Client::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(JSONError(['email' => __('auth.not_found')]));
        }

        $password = Str::random(10);

        $user->password = bcrypt($password);
        $user->save();

        $mail = (new SendMail('Your new password', 'emails.password', ['password' => $password]))->onQueue('mails');

        Mail::to($user->email)->queue($mail);

        return response()->json(JSONSuccess());
    }
}
