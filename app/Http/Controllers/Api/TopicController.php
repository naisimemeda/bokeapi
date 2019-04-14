<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\Api\TopicResource;
use App\Models\Topics;
use Illuminate\Http\Request;

class TopicController extends Controller
{

    public function index(){
        $topic = Topics::all();
        return $this->setStatusCode(200)->success($topic);
    }


    public function store(TopicRequest $request){
        Topics::create($request->all());
        return $this->setStatusCode(200)->success('添加话题成功');
    }

    public function destroy(Topics $topics){
        $topics->delete();
        return $this->setStatusCode(200)->success('删除话题成功');
    }

    public function update(TopicRequest $request,Topics $topics){
        $this->authorize('update',$topics);
        $topics->update($request->all());
        return $this->setStatusCode(200)->success('修改话题成功');
    }
}
