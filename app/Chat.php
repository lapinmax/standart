<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {
    protected $guarded = ['id'];

    public function client () {
        return $this->belongsTo(Client::class);
    }

    public function messages () {
        return $this->hasMany(Message::class);
    }
}
