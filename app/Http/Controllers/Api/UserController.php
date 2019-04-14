<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        User::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    public function delete(User $user){
        $this->authorize('delete', $user);
        $user->delete();
        return $this->setStatusCode(200)->success('删除用户成功');
    }


    //用户登录
    public function login(Request $request){
        $token  = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        $user_id = Auth::guard('api')->user()->id;
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
        $user = Auth::guard('api')->user();
        return $this->success(new UserResource($user));
    }
}