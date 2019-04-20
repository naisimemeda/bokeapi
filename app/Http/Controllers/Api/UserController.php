<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    //返回用户列表
    public function index(){
        $users = User::paginate(3);
        return UserResource::collection($users);
    }
    //返回单一用户信息
    public function show(User $user){
        return $this->success(new UserResource($user));
    }


    //用户注册
    public function store(UserRequest $request){
        $verifyData = Cache::get($request->verification_key);
        if (!$verifyData) {
            return $this->setStatusCode(422)->success('验证码已失效');
        }
        if (!hash_equals($verifyData['code'], $request->code)) {
            $this->setStatusCode(200)->success('验证码错误');
        }
        User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);
        Cache::forget($request->verification_key);
        return $this->setStatusCode(201)->success('成功');
    }

    public function delete(User $user){
        $this->authorize('delete', $user);
        $user->delete();
        return $this->setStatusCode(200)->success('删除用户成功');
    }


    //用户登录
    public function login(Request $request){
        $token  = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        $user_id = User::UserID();
        if($token){
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token,'id' => $user_id]);
        }
        return $this->failed('账号或密码错误',400);
    }

    public function logout(){
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }


    public function info(){
        $user = User::UserInfo();
        return $this->success(new UserResource($user));
    }

    public function pictureCode(Request $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.str_random(15);
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        Cache::put($key, [ 'code' => $captcha->getPhrase()], $expiredAt);
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];
        return $this->success($result)->setStatusCode(201);
    }

    public function yz(Request $request){
        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData) {
            return $this->success('图片验证码已失效')->setStatusCode(422);
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            Cache::forget($request->captcha_key);
            return $this->success('验证码错误');
        }
        return $this->success('成功');
    }
}