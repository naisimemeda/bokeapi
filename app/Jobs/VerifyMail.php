<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class VerifyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $code;
    public $to;
    public $subject;

    public function __construct($code,$to,$subject)
    {
        $this->code = $code;
        $this->to = $to;
        $this->subject = $subject;
    }
    public function handle()
    {
        $to = $this->to;
        $subject =  $this->subject;
        $view = 'emails.registered';
        $code = $this->code;
         Mail::send($view,['code'=>$code],function ($message) use ($to,$subject) {
          $message->to($to)->subject($subject);
         });
    }
}
