<?php

namespace App\Http\Controllers\Api;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function show(){
        $id = User::UserID();
        $data = User::find($id)->notice()->get();
        return $this->setStatusCode(200)->success($data);
    }
    public function destroy(Notice $notice){
        $this->authorize('delete',$notice);
        $notice->delete();
        return $this->setStatusCode(200)->success('删除通知成功');
    }

    public function SeeNotice(){
        $user = User::UserInfo();
        $user->notice_count = 0;
        $user->save();
        return $this->setStatusCode(200)->success('成功');
    }
}
