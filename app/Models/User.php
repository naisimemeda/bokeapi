<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    const INVALID = -1; //已删除
    const NORMAL = 0; //正常
    const FREEZE = 1;
    const ADMIN = 1;
    protected $table = 'users';

    protected $fillable = [
        'name', 'password' , 'last_token'
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
            case self::NORMAL:
                return '正常';
            case self::FREEZE:
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
}
