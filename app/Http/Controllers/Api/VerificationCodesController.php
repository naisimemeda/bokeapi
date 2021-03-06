<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use App\Jobs\TranslateSlug;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $request,EasySms $easySms)
    {
        $phone = $request->phone;
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
//        if (!app()->environment('production')) {
//            $code = '1234';
//        }else{
          dispatch(new TranslateSlug($phone,$code))->onQueue('phone');
//        }
        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinutes(10);
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
        return $this->setStatusCode(200)->success(['key' => $key,'expired_at' => $expiredAt->toDateTimeString()]);
   }
}
