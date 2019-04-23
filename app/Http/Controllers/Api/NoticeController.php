<?php

namespace App\Http\Controllers\Api;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function show(){
        $user = User::UserInfo();
        $data = $user->notice();
        return $this->setStatusCode(200)->success($data);
    }
    public function destroy(Notice $notice){
        $this->authorize('delete',$notice);
        $notice->delete();
        return $this->setStatusCode(200)->success('删除通知成功');
    }
}
