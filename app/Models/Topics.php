<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getSelectName(){
        $data = DB::table('topics')->select('id','name as text')->get();
        $selectOption = [];
        foreach ($data as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }
}
