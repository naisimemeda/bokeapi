<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\EasySms;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $phone;
    public $code;
    public function __construct($phone,$code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    public function handle(EasySms $easySms)
    {
        try {
            $easySms->send($this->phone, [
                'template' => 'SMS_163853034',
                'data' => [
                    'code' => $this->code
                ]
            ],['aliyun']);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            dd($message);
        }
    }
}
