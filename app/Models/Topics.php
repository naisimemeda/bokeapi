<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = 'topics';

    protected $fillable = [
        'name', 'status'
    ];

    public function articles()
    {
        return $this->hasMany(Articles::class);
    }
}
