<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->prefix('home')->middleware('cors')->group(function () {
    Route::post('/users','UserController@store')->name('users.store');//用户注册
    Route::post('/login','UserController@login')->name('users.login'); //用户登录
    Route::get('/topics','TopicController@index')->name('topic.index');//查询话题列表
    //文章
    Route::get('/article','ArticleController@index')->name('article.store'); //查询所有文章
    Route::post('/article','ArticleController@store')->name('article.store');//新增文章
    Route::delete('/article/{articles}','ArticleController@destroy')->name('article.delete');//删除文章
    Route::post('articles/{article}/comment','CommentController@articleStore')->name('comment.store'); //文章评论

    Route::get('articles/{article}','CommentController@show')->name('comment.show');//具体文章下的评论

    //登录后才能使用的路由
    Route::middleware('api.refresh')->group(function () {
        Route::get('/users/info','UserController@info')->name('users.info');//当前用户信息
        Route::get('/users','UserController@index')->name('users.index');//用户列表
        Route::get('/users/{user}','UserController@show')->name('users.show');//某一个用户信息
        Route::get('/logout','UserController@logout')->name('users.logout');//用户退出
        Route::delete('/delete/{user}','UserController@delete')->name('users.delete'); //用户删除
        //话题分类  管理员才能有权限操作
        Route::middleware('topic')->group(function () {
            Route::post('/topics','TopicController@store')->name('topic.store');//提交
            Route::delete('/topics/{topics}','TopicController@destroy')->name('topic.delete');//删除
            Route::patch('/topics/{topics}','TopicController@update')->name('topic.update');//修改
        });
    });
});