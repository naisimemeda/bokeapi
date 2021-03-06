<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject , MustVerifyEmailContract
{
    use Notifiable,MustVerifyEmailTrait;
    const INVALID = -1; //已删除
    const NORMAL = 0; //冻结
    const FREEZE = 1; //正常
    const ADMIN = 1;
    protected $table = 'users';

    protected $fillable = [
        'name', 'password' ,'phone','email','avatar','notice_count'
    ];

    protected $hidden = [
        'password'
    ];
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function username()
    {
        return 'name';
    }

    public static function getStatusName($status){
        switch ($status){
            case self::INVALID:
                return '已删除';
            case self::FREEZE:
                return '正常';
            case self::NORMAL:
                return '冻结';
            default:
                return '正常';
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function UserInfo(){
        return Auth::guard('api')->user();
    }

    public static function UserID(){
        return  Auth::guard('api')->user()->id;
    }

//    public function ArticleName()
//    {
//        return $this->hasOne('App\Comment');
//    }


    public function notice()
    {
        return $this->hasMany(Notice::class,'receive_id');
    }

    public static function getSelectUser(){
        $data = DB::table('users')->select('id','name as text')->get();
        $selectOption = [];
        foreach ($data as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

}
