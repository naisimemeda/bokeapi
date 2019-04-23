<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    //
    public $fillable = [
        'uid','receive_id','comment_id'
    ];

    public function noticetable()
    {
        return $this->morphTo();
    }
}
