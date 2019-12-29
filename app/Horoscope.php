<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model {
    protected $guarded = ['id'];

    protected $dates = ['date'];

    public function zodiac () {
        return $this->belongsTo(Zodiac::class);
    }

    public function template () {
        return $this->belongsTo(PushTemplate::class);
    }

    public function likes () {
        return $this->hasMany(Like::class)->where('type', 1);
    }

    public function dislikes () {
        return $this->hasMany(Like::class)->where('type', 0);
    }

    public static function all ($columns = ['*']) {
        return parent::query()->where('type', 'day')->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
}
