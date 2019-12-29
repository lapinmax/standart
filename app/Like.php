<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
    protected $guarded = ['id'];

    public function client () {
        return $this->belongsTo(Client::class);
    }

    public function horoscope () {
        return $this->belongsTo(Horoscope::class);
    }
}
