<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CommentRequest;
use App\Models\Articles;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @param Articles $article
     * @param CommentRequest $request
     * @return mixed
     */
    public function articleStore(Articles $article, CommentRequest $request) {
        $user_id = User::UserID();
        $data = [
            'content' => $request->get('content'),
            'user_id' => $user_id,
        ];
        $id = $article->comments()->create($data)->id;
        return $this->setStatusCode(200)->success($id);
    }

    //消息通知 邮件通知 队列执行
    public function show(Articles $article){
        return $this->setStatusCode(200)->success($article->comments);
    }


    public function delete(CommentRequest $request,Comment $comment){
        $this->authorize('delete',$comment);
        $comment->delete();
        return $this->setStatusCode(200)->success('删除成功');
    }
}
