<?php

namespace App\Http\Controllers\Api;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends Controller
{
    //
    public function VerifyCode(CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.str_random(15);
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        Cache::put($key, [ 'code' => $captcha->getPhrase()], $expiredAt);
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];
        return $this->success($result)->setStatusCode(201);
    }

    public function Verify(Request $request){
        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData) {
            return $this->success('图片验证码已失效')->setStatusCode(422);
        }
        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            Cache::forget($request->captcha_key);
            return $this->success('验证码错误');
        }
        return $this->success('成功');
    }
}
