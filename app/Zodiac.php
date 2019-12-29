<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zodiac extends Model {
    public function horoscopes ($type = 'day') {
        return $this->hasMany(Horoscope::class)->where('type', $type);
    }

    public static function getByDate ($date) {
        $month = $date->month - 1;
        $day = $date->day;

        $zod = [21, 20, 21, 21, 22, 22, 23, 23, 24, 24, 23, 22];

        if ($day >= $zod[$month]) {
            $month = $month + 1;
        }

        if ($month == 12) {
            $month = 0;
        }

        return self::find($month + 1);
    }
}
