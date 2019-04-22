<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CommentRequest;
use App\Lisenter\CommentNotices;
use App\Models\Articles;
use App\Models\Comment;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function articleStore(Articles $article, CommentRequest $request,Comment $comment) {
        $user_id = User::UserID();
        $data = [
            'content' => $request->get('content'),
            'user_id' => $user_id,
        ];
//        event(new CommentNotices());
        $id = $article->comments()->create($data)->id;
        $notice_data = [
            'uid' => $user_id,
            'receive_id' => 4,
            'comment_id' => $id,
        ];
        $aaa = $article->notices()->create($notice_data);
        dd($aaa);
        return $this->setStatusCode(200)->success($aaa);
    }

    public function show(Articles $article){
        return $this->setStatusCode(200)->success($article->comments);
    }


    public function delete(CommentRequest $request,Comment $comment){
        $this->authorize('delete',$comment);
        $comment->delete();
        return $this->setStatusCode(200)->success('删除成功');
    }
}
