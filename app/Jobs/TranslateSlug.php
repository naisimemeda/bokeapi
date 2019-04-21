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
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function handle(EasySms $easySms)
    {
        try {
            $easySms->send($this->phone, [
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
