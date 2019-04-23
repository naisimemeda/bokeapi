<?php

namespace App\Policies;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticePolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser,Notice $notice){
        return $currentUser->id === $notice->receive_id;
    }
}
