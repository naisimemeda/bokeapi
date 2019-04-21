<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
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
    public function login(AuthRequest $request){
        $token  = Auth::guard('api')->attempt(['name'=>$request->username,'password'=>$request->password]);
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

    public function update(Request $request,User $user,ImageUploadHandler $uploader){
        $data = $request->all();
        if($request->avatar){
            $request = $uploader->save($request->avatar,'avatars',$user->id,416);
            if($request){
                $data['avatar'] = $request['path'];
                $this->authorize('update',$user);
                $user->update($data);
                return $this->success($data);
            }
        }

    }


    public function MaliSend(){
        $name = '奈斯';
        $view = 'emails.registered';
            Mail::send($view,['name'=>$name],function($message){
                $to = '1759307013@qq.com';
                $message ->to($to)->subject('邮件测试');
            });
    }


}