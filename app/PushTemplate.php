<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushTemplate extends Model {
    use SoftDeletes;

    protected $dates = ['date'];

    protected $guarded = ['id'];

    public static function all ($columns = ['*']) {
        return parent::query()->orderBy('sort', 'asc')->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
}
