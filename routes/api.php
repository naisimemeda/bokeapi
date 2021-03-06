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
    //用户注册
    Route::post('/users','UserController@store')->name('users.store');
    //用户登录
    Route::post('/login','UserController@login')->name('users.login');
    //获取图片验证码
    Route::get('/VerifyCode','CaptchasController@VerifyCode')->name('Captcha.VerifyCode');
    //核实验证码
    Route::post('/Verify','CaptchasController@Verify')->name('Captcha.Verify');
    //请求短信验证码
    Route::post('/verificationCodes','VerificationCodesController@store')->name('api.verificationCodes.store');
    //邮箱发送
    Route::post('mail/send','UserController@MailSend')->name('user.mail');
    //邮箱验证
    Route::post('mail/verifymail','UserController@VerifyMail')->name('user.verifymail');
    Route::middleware('api.refresh')->group(function () {
        //当前用户信息
        Route::get('/users/info','UserController@info')->name('users.info');
        //用户列表
        Route::get('/users','UserController@index')->name('users.index');
        //用户信息
        Route::get('/users/{user}','UserController@show')->name('users.show');
        //用户退出
        Route::get('/logout','UserController@logout')->name('users.logout');
        //用户删除
        Route::delete('/users/delete/{user}','UserController@delete')->name('users.delete');
        //用户修改资料
        Route::post('/users/{user}','UserController@update')->name('users.update');

        //话题
        Route::middleware('topic')->group(function () {
            Route::get('/topics','TopicController@index')->name('topic.index');
            Route::post('/topics','TopicController@store')->name('topic.store');
            Route::delete('/topics/{topics}','TopicController@destroy')->name('topic.delete');
            Route::patch('/topics/{topics}','TopicController@update')->name('topic.update');
        });

        //新增文章
        Route::post('/article','ArticleController@store')->name('article.store');
        //查询所有文章
        Route::get('/article','ArticleController@index')->name('article.store');
        //删除文章
        Route::delete('/article/{articles}','ArticleController@destroy')->name('article.delete');
        //文章评论
        Route::post('articles/{article}/comment','CommentController@articleStore')->name('comment.store');
        //获取某篇文章下的评论
        Route::get('articles/{article}','CommentController@show')->name('comment.show');
        //查询当前人的所有通知
        Route::get('/notice','NoticeController@show')->name('notice.show');
        //查看当前人的通知
        Route::get('/see/notice','NoticeController@SeeNotice')->name('notice.see');
        //删除评论
        Route::delete('/comment/delete/{comment}','CommentController@delete')->name('comment.delete');
    });
});