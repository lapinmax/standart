<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HoroscopeResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray ($request) {
        return [
            'id' => $this->id,
            'zodiac' => $this->zodiac->id,
            'type' => $this->type,

            $this->mergeWhen($this->type == 'year', function () {
                return ['year' => '2020'];
            }),

            $this->mergeWhen($this->type == 'day', function () {
                return ['date' => $this->date->format('d.m.Y')];
            }),

            'love_title' => $this->love_title,
            'love_image' => config('app.url') . \Storage::url($this->love_image),
            'love_subtitle' => $this->love_subtitle,

            'overall_title' => $this->overall_title,
            'overall_image' => config('app.url') . \Storage::url($this->overall_image),
            'overall_subtitle' => $this->overall_subtitle,
            'overall_text' => $this->overall_text,

            'career_title' => $this->career_title,
            'career_image' => config('app.url') . \Storage::url($this->career_image),
            'career_subtitle' => $this->career_subtitle,

            'health_title' => $this->health_title,
            'health_image' => config('app.url') . \Storage::url($this->health_image),
            'health_subtitle' => $this->health_subtitle,

            'lucky_number' => $this->lucky_number,
            'lucky_human' => $this->lucky_human,

            'dream_sex' => $this->dream_sex,
            'dream_hustle' => $this->dream_hustle,
            'dream_vibe' => $this->dream_vibe,
            'dream_success' => $this->dream_success,

            'biorhythms_physical_number' => $this->biorhythms_physical_number,
            'biorhythms_intellectual_number' => $this->biorhythms_intellectual_number,
            'biorhythms_emotional_number' => $this->biorhythms_emotional_number,
            'biorhythms_average_number' => $this->biorhythms_average_number,
        ];
    }
}
