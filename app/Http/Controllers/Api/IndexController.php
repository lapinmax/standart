<?php

namespace App\Http\Controllers\Api;

use App\Horoscope;
use App\Http\Resources\HoroscopeResource;
use App\Like;
use App\Token;
use App\Zodiac;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller {
    public function horoscope (Request $request) {
        $validator = validator($request->all(), [
            'zodiac' => 'required',
            'timezone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $zodiac = Zodiac::find($request->zodiac);

        if (!$zodiac) {
            return response()->json(JSONError(['zodiac' => 'Id not found.']));
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
        ];  //todo delete

        $timezone = isset($timezones[$request->timezone]) ? $timezones[$request->timezone] : $request->timezone;

        try {
            $date = now($timezone);
        } catch (\Exception $e) {
            $date = now('America/New_York');
        }

        $horoscopes = $zodiac->horoscopes->where('filled', 1);

        //dd($date->format('Y-m-d'));

        $today = $horoscopes->filter(function ($value) use ($date) {
            return $value->date->format('Y-m-d') == $date->format('Y-m-d');
        })->first();

        $yesterday = $horoscopes->filter(function ($value) use ($date) {
            return $value->date->format('Y-m-d') == $date->copy()->subDay()->format('Y-m-d');
        })->first();

        $year = $zodiac->horoscopes('year')->where('filled', 1)->first();

        $send = [
            'yesterday' => $yesterday ? HoroscopeResource::make($yesterday) : null,
            'today' => $today ? HoroscopeResource::make($today) : null,
            'year' => $year ? HoroscopeResource::make($year) : null,
        ];

        return response()->json(JSONSuccess($send));
    }

    public function rate (Request $request, Horoscope $horoscope) {
        $validator = validator($request->all(), [
            'type' => 'required',
            'isLiked' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(JSONError($validator->errors()->toArray()));
        }

        $user = auth()->user();

        $like = Like::updateOrCreate([
            'client_id' => auth()->user()->id,
            'horoscope_id' => $horoscope->id,
            'field' => $request->type,
        ], [
            'type' => $request->isLiked == 'true'
        ]);

        return response()->json(JSONSuccess());
    }
}
