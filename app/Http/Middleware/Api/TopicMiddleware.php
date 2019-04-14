<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6 0006
 * Time: 20:53
 */

namespace App\Http\Middleware\Api;
use App\Models\User;
use Closure;
use Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TopicMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next){
        $user = Auth::user();
        if($user->is_admin != User::ADMIN){
            return redirect('/');
        }
        return $next($request);
    }
}