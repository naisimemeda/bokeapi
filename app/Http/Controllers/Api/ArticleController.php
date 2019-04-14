<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleRequest;
use App\Models\Topics;
use Illuminate\Http\Request;
use App\Models\Articles;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    //
    public function index(Articles $articles){
        $articles = Articles::with('user:id,name','topics:id,name')->get();
        return $this->success($articles);
    }

    public function store(ArticleRequest $request){
        Articles::create($request->all());
        return $this->setStatusCode(200)->success('添加文章成功');
    }

    public function destroy(Articles $articles){
        $this->authorize('delete', $articles);
        $articles->delete();
        return $this->setStatusCode(200)->success('删除文章成功');
    }


    public function update(ArticleRequest $request,Articles $articles){
        $this->authorize('update',$articles);
        Articles::update($request->all());
        return $this->setStatusCode(200)->success('修改文章成功');
    }
}
