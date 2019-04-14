<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    //
    protected $fillable = [
        'name', 'topics_id' , 'user_id'
    ];

    public function topics(){
        return $this->belongsTo(Topics::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
