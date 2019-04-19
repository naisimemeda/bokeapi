<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $sms = app('easysms');
        $phone = $request['phone'];
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
        if (!app()->environment('production')) {
            $code = '1234';
        }else{
        try {
            $sms->send($phone, [
                'template' => 'SMS_156990210',
                'data' => [
                    'code' => 6666
                ]
            ],['aliyun']);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            dd($message);
        }
     }
   }
}
