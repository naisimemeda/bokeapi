<?php

namespace App\Lisenter;

use App\Events\CommentNotice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentNotices
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentNotice  $event
     * @return void
     */
    public function handle(CommentNotice $event)
    {
        //
    }
}
