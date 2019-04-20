<?php

namespace App\Jobs;

use App\Models\Topics;
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

    public $tries = 1;

    public $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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

            logger("已发送至" . $this->phone . ",code:");
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            dd($message);
        }
    }
}
