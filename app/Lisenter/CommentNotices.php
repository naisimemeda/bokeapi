<?php

namespace App\Lisenter;

use App\Events\CommentNotice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentNotices implements ShouldQueue
{
    public $connection = 'redis';
    public $queue = 'notice';
    public function __construct()
    {
    }

    public function handle(CommentNotice $event)
    {
        $articleUser = $event->article->user()->first();
        $notice_data = [
            'uid' => $event->user_id,
            'receive_id' => $articleUser->id,
            'comment_id' => $event->id,
        ];
        $event->article->notices()->create($notice_data);
        $event->article->increment('comment_count');
    }
}
